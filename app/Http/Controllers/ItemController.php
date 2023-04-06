<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemDetailsRequest;
use App\Models\Item;
use App\Models\Seller;
use App\Services\HandleDataLoading;
use App\Services\ItemDTO;
use App\Services\ItemService;
use Illuminate\Http\Request;
use function response;

class ItemController extends Controller
{
    private $itemService;
    private $handleDataLoading;
    private $itemDTO;

    public function __construct(ItemService $itemService, HandleDataLoading $handleDataLoading, ItemDTO $itemDTO)
    {
        $this->itemService = $itemService;
        $this->itemDTO = $itemDTO;
        $this->handleDataLoading = $handleDataLoading;
      //  $this->middleware(['fromCookie'], ['except' => ['index', 'show','getDetails','queryItems']]);
    }


    public function index()
    {

        return $this->handleDataLoading->handleCollection(function () {
            return $this->itemService->getMostPopularItems();
        }, 'items');
    }



    public function store(StoreItemRequest $request)
    {
     //   $this->authorize('create', Item::class);
        $item = $request->validated();
        return  $this->handleDataLoading->handleAction(function() use ($item){
            return $this->itemService->createItem($item);
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



    public function update(UpdateItemDetailsRequest $request, Item $item)
    {
        $validated = $request->validated();
       // $this->authorize('update items', $item);
        return $this->handleDataLoading->handleAction(function () use ($validated,$item){
            $this->itemService->updateItem($validated, $item);
        }, 'item','updat');
    }

    public function destroy(Item $item)
    {
       // $this->authorize('delete items', $item);
       return $this->handleDataLoading->handleDestroy($item,'item', 'delet');
    }

    public function getDetails($item)
    {
        $item = Item::find($item);
        return $this->handleDataLoading->handleDetails(function () use ($item){
        //return Item::with('itemDetails')->findOrfail($item->id);
            /*if(!Auth::user()->id==$item->seller_id)
                $item->increment('views');*/
            //return $this->itemDTO->mapItem(Item::with('itemDetails.images')->find($item->id));
            return Item::with('itemDetails')->find($item->id);
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


    public function getItemsBySeller(Request $request,Seller $seller){
        if($seller->hasPermissionTo('read items'))
        return $this->handleDataLoading->handleCollection(function () use ($seller){
            return $this->itemService->showItemsForSeller($seller);
        }, 'items');
        else
            return response()->json(['message' => 'You are not authorized to view this page'], 403);
    }

    public function rateItem(Request $request, Item $item)
    {
    //    $this->authorize('rate items', $item);
        return $this->handleDataLoading->handleAction(function () use ($request, $item){
            $item->rateOnce($request->rating,$request->comment);
            return $item;
        }, 'item', $item,'rat');
    }


}
