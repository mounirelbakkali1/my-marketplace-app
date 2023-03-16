<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemDetailsRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use App\Services\HandleDataLoading;
use App\Services\ItemService;

class ItemController extends Controller
{
    private $itemService;
    private $handleDataLoading;

    public function __construct(ItemService $itemService, HandleDataLoading $handleDataLoading)
    {
        $this->itemService = $itemService;
        $this->handleDataLoading = $handleDataLoading;

    }


    public function index()
    {
        return $this->handleDataLoading->handleCollection(function () {
            return $this->itemService->getMostPopularItems();
        }, 'items');
    }



    public function store(StoreItemRequest $request)
    {
        return  $this->handleDataLoading->handleAction(function() use ($request){
            $item = $this->itemService->createItem($request);
            return $item;
        });
    }

    public function show($item)
    {

       return $this->handleDataLoading->handleAction(function () use ($item){
            $item = $this->itemService->showItem($item);
            $item->increment('views');
            return $item;
        }, 'item','retreiv');
    }



    public function update(UpdateItemRequest $request, Item $item)
    {
        return $this->handleDataLoading->handleAction(function () use ($request,$item){
            $this->itemService->updateItem($request, $item);
        }, 'item', $item,'updat');
    }

    public function destroy(Item $item)
    {
       return $this->handleDataLoading->handleDestroy($item,'item', 'delet');

    }

    public function getDetails($item)
    {
        $item = Item::find($item);
        return $this->handleDataLoading->handleDetails(function () use ($item){
            return Item::with('itemDetails.images')->find($item->id);
        }, 'item', $item,'retreiv');
    }

    public function updateDetails(UpdateItemDetailsRequest $request, Item $item)
    {
        $item = Item::find($item->id);
        return $this->handleDataLoading->handleDetails(function () use ($request, $item){
            $item->itemDetails->update($request->validated());
        }, 'item', $item,'updat');
    }


}
