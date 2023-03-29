<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemDetailsRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use App\Models\Seller;
use App\Services\HandleDataLoading;
use App\Services\ItemService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    private $itemService;
    private $handleDataLoading;

    public function __construct(ItemService $itemService, HandleDataLoading $handleDataLoading)
    {
        $this->itemService = $itemService;
        $this->handleDataLoading = $handleDataLoading;
        $this->middleware('auth:api', ['except' => ['index', 'show','getDetails','queryItems']]);
    }


    public function index()
    {
        return $this->handleDataLoading->handleCollection(function () {
            return $this->itemService->getMostPopularItems();
        }, 'items');
    }



    public function store(StoreItemRequest $request)
    {
        $this->authorize('create items', Item::class);
        $item = $request->validated();
        return  $this->handleDataLoading->handleAction(function() use ($item){
            $item = $this->itemService->createItem($item);
            return $item;
        }, 'item', 'creat');
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
        $this->authorize('update items', $item);
        return $this->handleDataLoading->handleAction(function () use ($request,$item){
            $this->itemService->updateItem($request, $item);
        }, 'item', $item,'updat');
    }

    public function destroy(Item $item)
    {
        $this->authorize('delete items', $item);
       return $this->handleDataLoading->handleDestroy($item,'item', 'delet');
    }

    public function getDetails($item)
    {
        $item = Item::find($item);
        return $this->handleDataLoading->handleDetails(function () use ($item){
            $item->increment('views');
            return Item::with('itemDetails.images')->find($item->id);
        }, 'item', $item,'retreiv');
    }

    public function updateDetails(UpdateItemDetailsRequest $request, Item $item)
    {
        $this->authorize('update items', $item);
        $item = Item::find($item->id);
        return $this->handleDataLoading->handleDetails(function () use ($request, $item){
            $item->itemDetails->update($request->validated());
        }, 'item', $item,'updat');
    }

   public function queryItems(Request $request)
    {
        $category_id = $request->category;
        $collection_id = $request->collection;
        return $this->handleDataLoading->handleCollection(function () use ($category_id, $collection_id){
            return $this->itemService->queryItems($category_id, $collection_id);
        }, 'items');
    }


    public function getItemsBySeller(Seller $seller){
        if($seller->hasPermissionTo('read items'))
        return $this->handleDataLoading->handleCollection(function () use ($seller){
            return $this->itemService->showItemsForSeller($seller);
        }, 'items');
        else
            return response()->json(['message' => 'You are not authorized to view this page'], 403);
    }


}
