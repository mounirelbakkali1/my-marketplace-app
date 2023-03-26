<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSellerRequest;
use App\Models\AdditionalProfilSettings;
use App\Models\Address;
use App\Models\Seller;
use App\Services\HandleDataLoading;
use App\Services\ItemService;
use Illuminate\Http\Request;
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
        $this->authorize('read users', Seller::class);
        return $this->handleDataLoading->handleCollection(function () {
            return Seller::all();
        }, 'sellers');
    }


    public function getSellerInfo($sellerId){
        $seller = Seller::find($sellerId);
        return $this->handleDataLoading->handleDetails(function() use ($sellerId){
            return Seller::with('AdditionalInfo.address')->find($sellerId);
        }, 'seller details', $seller,'retreiv');
    }


    public function createSeller(CreateSellerRequest $request){
       $validated = $request->validated();
       return AuthController::register(function () use ($validated) {
           $seller = Seller::create([
               'name' => $validated['name'],
               'email' => $validated['email'],
               'password' => Hash::make($validated['password']),
           ]);
           $additionalInfo = new AdditionalProfilSettings();
           $additionalInfo->phone = $validated['phone'];
           $additionalInfo->websiteUrl = $validated['websiteUrl'];
           $address = new Address();
            $address->street = $validated['street'];
            $address->city = $validated['city'];
            $address->zip_code = $validated['zip_code'];
            $additionalInfo->address()->save($address);
            $additionalInfo->address_id = $address->id;
           $seller->AdditionalInfo()->save($additionalInfo);
           return $seller;
        });
    }



}
