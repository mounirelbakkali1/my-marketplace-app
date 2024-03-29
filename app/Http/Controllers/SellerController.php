<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSellerRequest;
use App\Http\Requests\UpdateSellerInfoRequest;
use App\Models\AdditionalProfilSettings;
use App\Models\Address;
use App\Models\Employee;
use App\Models\Seller;
use App\Services\HandleDataLoading;
use App\Services\ItemService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SellerController extends Controller
{
    private $itemService;
    private HandleDataLoading $handleDataLoading;

    public function __construct(ItemService $itemService, HandleDataLoading $handleDataLoading)
    {
        $this->handleDataLoading = $handleDataLoading;
        $this->itemService = $itemService;
       $this->middleware('auth:api',['except'=>['getSeller','getSellerInfo','createSeller']]);
    }

    public function getSeller($sellerID){
        $seller = Seller::find($sellerID);
        if (!$seller) {
            return response()->json([
                'message' => 'Seller not found with id ' . $sellerID,
            ], 404);
        }
        return response()->json([
            'seller' =>$seller,
        ]);
    }
    public function index(){
        if(!Auth::user()->hasPermissionTo('manage sellers')){
            return response()->json([
                'message' => 'You are not authorized to view sellers',
            ], 401);
        }
        return $this->handleDataLoading->handleCollection(function () {
            return  Seller::with('roles')->whereHas('roles',function ($query){
                $query->where('name','seller');
            })->get();
        }, 'sellers');
    }


    public function getSellerInfo($sellerId){
        $seller = Seller::find($sellerId);
        return $this->handleDataLoading->handleDetails(function() use ($sellerId){
            return Seller::with('AdditionalInfo.address')->find($sellerId);
        }, 'seller', $seller,'retreiv');
    }


    public function createSeller(CreateSellerRequest $request){
       $validated = $request->validated();
       return AuthController::registerSeller($validated); // how has the information is how do the work (design pattern)
    }

    public function updateSeller(UpdateSellerInfoRequest $request, $sellerId){
        $seller = Seller::find($sellerId);
        if (!$seller) {
            return response()->json([
                'message' => 'Seller not found with id ' . $sellerId,
            ], 404);
        }
        $validated = $request->validated();
        $seller->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);
        $seller->AdditionalInfo->update([
            'phone' => $validated['phone'],
            'intro'=>$validated['intro'],
            'websiteUrl'=>$validated['websiteUrl'],
        ]);
        $seller->AdditionalInfo->address->update([
            'city' => $validated['city'],
            'street' => $validated['street'],
            'zip_code' => $validated['zip_code'],
        ]);
        return response()->json([
            'message' => 'Seller updated successfully',
        ]);
    }




}
