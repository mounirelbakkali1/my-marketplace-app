<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Models\Item;
use App\Services\ItemService;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    private $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    public function addItem(StoreItemRequest $request)
    {
        $this->itemService->createItem($request);
        return redirect()->back();
    }
    public function editItem(StoreItemRequest $request, Item $item)
    {
        // TODO: include edit Item Page
        return redirect()->back();
    }

    public function updateItem(StoreItemRequest $request, Item $item)
    {
        $this->itemService->updateItem($request, $item);
        return redirect()->back();
    }

    public function deleteItem(Item $item)
    {
        $this->itemService->deleteItem($item);
        return redirect()->back();
    }
    public function showItems()
    {
        $items = $this->itemService->showItemsBySeller(auth()->user()->id);
       // return view('seller.items', compact('items'));
    }
    public function updateStock(Request $request, Item $item)
    {
        $this->itemService->updateStock($request, $item);
        return redirect()->back();
    }


    public function consultDashboard()
    {

    }


}
