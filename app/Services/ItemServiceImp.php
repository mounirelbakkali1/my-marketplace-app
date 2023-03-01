<?php

namespace App\Services;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use function auth;

class ItemServiceImp implements ItemService
{

    public function createItem(StoreItemRequest $request)
    {
        $item = $request->validated();
        $item['seller_id'] = auth()->user()->id;
        Item::create($item);
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

    public function showItem($id)
    {
        return "item ".$id." found";
        // TODO: Implement showItem() method.
    }

    public function showItemsByCategory($category)
    {
        // TODO: Implement showItemsByCategory() method.
    }

    public function showItemsBySeller($seller)
    {
        $items = Item::where('seller_id', auth()->user()->id)->get();
        return $items;
    }

    public function updateStock($request, $item)
    {
        // TODO: Implement updateStock() method.
    }
}
