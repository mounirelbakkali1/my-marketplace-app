<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Models\Item;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function addItem(StoreItemRequest $request)
    {
        $item = $request->validated();
        $item['seller_id'] = auth()->user()->id;
        Item::create($item);
        return redirect()->back();
    }
    public function editItem(StoreItemRequest $request, Item $item)
    {
        $item->update($request->validated());
        return redirect()->back();
    }
    public function deleteItem(Item $item)
    {
        $item->delete();
        return redirect()->back();
    }
    public function showItems()
    {
        $items = Item::where('seller_id', auth()->user()->id)->get();
       // return view('seller.items', compact('items'));
    }
    public function updateStock(Request $request, Item $item)
    {
        $item->update($request->only('stock'));
        return redirect()->back();
    }


}
