<?php

namespace App\Services;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use Illuminate\Support\Facades\DB;

class ItemServiceImp implements ItemService
{

    public function createItem(StoreItemRequest $request)
    {

    }

    public function updateItem(UpdateItemRequest $request, $id)
    {
    }

    public function deleteItem($id)
    {
    }

    public function getMostPopularItems()
    {
        return "Hello from ItemServiceImp";
        /*$items = DB::table('items')
            ->join('ratings', 'items.id', '=', 'ratings.item_id')
            ->select('items.*', DB::raw('AVG(ratings.rating) as rating_average'))
            ->groupBy('items.id')
            ->orderBy('rating_average', 'desc')
            ->limit(15)
            ->get();*/
    }
}
