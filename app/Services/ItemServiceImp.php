<?php

namespace App\Services;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use function auth;

class ItemServiceImp implements ItemService
{

    public function createItem($request)
    {
        return 0 ;
        //$item['seller_id'] = auth()->user()->id;
        $item = $request->validated();
        $item = Item::create($item);
        return $item;
    }

    public function updateItem(UpdateItemRequest $request, $id)
    {
        $item = $request->validated();
        $item = Item::where('id', $id)->update($item);
        return $item;
    }

    public function deleteItem($id)
    {
        $item = Item::where('id', $id)->delete();
        return $item;
    }

    public function getMostPopularItems()
    {
         return Item::join('ratings', 'items.id', '=', 'ratings.rateable_id')
             ->selectRaw('items.*, AVG(ratings.rating) as rating_average')
             ->groupBy('items.id')
             ->orderByDesc('rating_average')
             ->limit(15)
             ->get();
    }

    public function showItem($id)
    {
        return  Item::where('id', $id);
    }
    public function showItemDetails($id)
    {
        return   Item::with('itemDetails')->findOrFail($id);
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
