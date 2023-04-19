<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemDetailsRequest;
use App\Models\Item;
use App\Models\Seller;
use App\Models\User;
use App\Policies\ItemPolicy;
use App\Services\HandleDataLoading;
use App\Services\ItemDTO;
use App\Services\ItemService;
use App\Services\UISGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function dd;
use function response;

class ItemController extends Controller
{
    private $itemService;
    private $handleDataLoading;
    private $itemDTO;
    private ItemPolicy $itemPolicy;
    private UISGenerator $uisGenerator;


    public function __construct(ItemService $itemService, HandleDataLoading $handleDataLoading, ItemDTO $itemDTO, ItemPolicy $itemPolicy, UISGenerator $uisGenerator
)
    {
        $this->itemService = $itemService;
        $this->itemPolicy = $itemPolicy;
        $this->itemDTO = $itemDTO;
        $this->handleDataLoading = $handleDataLoading;
        $this->uisGenerator = $uisGenerator;
        // TODO: remove this line
      //  Auth::login(User::find(55));
         $this->middleware(['auth:api'], ['except' => ['index', 'show','getDetails','queryItems','getItemByUIS']]);
    }


    public function index(Request $request)
    {
        $categories = $request->get('categories', []);
        $collections = $request->get('collections', []);

        return $this->handleDataLoading->handleCollection(function () use ($categories, $collections) {
            return $this->itemService->getMostPopularItems($categories, $collections);
        }, 'items');
    }



    public function store(StoreItemRequest $request)
    {
        $this->itemPolicy->create(Auth::user());
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
        $this->itemPolicy->update(Auth::user(), $item);
        $validated = $request->validated();
        return $this->handleDataLoading->handleAction(function () use ($validated,$item){
            $this->itemService->updateItem($validated, $item);
        }, 'item','updat');
    }

    public function destroy(Item $item)
    {
        $this->itemPolicy->delete(Auth::user(), $item);
       return $this->handleDataLoading->handleDestroy($item,'item', 'delet');
    }

    public function getDetails($item)
    {
        $item = Item::find($item);
        return $this->handleDataLoading->handleDetails(function () use ($item){
       // return Item::with('itemDetails')->findOrfail($item->id);
            if(Auth::check() && !Auth::user()->id==$item->seller_id)
                $item->increment('views');
           // return $this->itemDTO->mapItem(Item::with('itemDetails.images')->find($item->id));
           //return Item::with('itemDetails')->find($item->id);
            return $this->itemService->showItem($item->id);
        }, 'item', $item,'retreiv');
    }

    public function updateDetails(UpdateItemDetailsRequest $request, Item $item)
    {
        $this->authorize('update', $item);
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
        if($item->seller_id==Auth::user()->id)
            return response()->json(['message' => 'You cannot rate your own item'], 200);
        if ($request->rating > 5 || $request->rating < 1)
            return response()->json(['message' => 'Rating must be between 1 and 5'], 200);

        if($item->ratings()->where('user_id',Auth::user()->id)->exists())
            return response()->json(['message' => 'You have already rated this item'], 200);
        return $this->handleDataLoading->handleAction(function () use ($request, $item){
            // authenticated user with id 7
            // TODO : to be removed after testing
            $item->rateOnce($request->rating,$request->comment);
            return $item;
        }, 'item','rat');
    }


    public function getUIS(Item $item){
        return response()->json([
            'uis' => $this->uisGenerator->generateUIS(['item'=>$item])
        ]);
    }

    public function getItemByUIS(Request $request){
        $request->validate([
            'uis' => 'required'
        ],[
            'uis.required' => 'invalid uis (Unique Identifier Serial)'
        ]);
        $item = $this->uisGenerator->decodeUIS($request->uis);
        if(!$item){
            return response()->json([
                'message' => 'Item not found'
            ],404);
        }
        return response()->json([
            'item' =>  $this->itemDTO->mapItem(Item::find($item['item']['id']))
        ]);
    }


}
