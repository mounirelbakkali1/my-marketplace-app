<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Models\Item;
use App\Models\Seller;
use App\Services\ItemService;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    private $itemService;

    public function __construct(ItemService $itemService)
    {
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
        $sellers = Seller::all();
        if($sellers->isEmpty())
        {
            return response()->json([
                'message' => 'No sellers found',
            ], 404);
        }
        return response()->json([
            'sellers' =>$sellers,
        ]);
    }


    public function getSellerInfo($sellerId){
        // get seller with additional info (and also additional info with address)
        $seller = Seller::with('AdditionalInfo.address')->find($sellerId);
        if (!$seller) {
            return response()->json([
                'message' => 'Seller not found with id ' . $sellerId,
            ], 404);
        }
        return response()->json([
            'seller' =>$seller,
        ]);
    }




}
