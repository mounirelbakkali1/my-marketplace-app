<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Services\ItemService;

class ItemController extends Controller
{
    private $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }


    public function index()
    {
        $items = $this->itemService->getMostPopularItems();
        return view('item.index', compact('items'));
    }


    public function create()
    {
        return view('item.create');
    }


    public function store(StoreItemRequest $request)
    {
        $this->itemService->createItem($request);
    }

    public function show(Item $item)
    {
        $item = $this->itemService->showItem($item);
    }


    public function edit(Item $item)
    {
        return view('item.edit', compact('item'));
    }


    public function update(UpdateItemRequest $request, Item $item)
    {
        $this->itemService->updateItem($request, $item);
        return redirect()->back();
    }

    public function destroy(Item $item)
    {
        $this->itemService->deleteItem($item);
        return redirect()->back();
    }




}
