<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Models\Item;
use App\Models\Seller;
use App\Services\HandleDataLoading;
use App\Services\ItemService;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    private $itemService;
    private HandleDataLoading $handleDataLoading;

    public function __construct(ItemService $itemService, HandleDataLoading $handleDataLoading)
    {
        $this->handleDataLoading = $handleDataLoading;
        $this->itemService = $itemService;
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
    public function getSellers(){
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




}
