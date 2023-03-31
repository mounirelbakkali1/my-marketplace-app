<?php

namespace App\Services;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use App\Models\ItemDetails;
use Illuminate\Support\Facades\DB;
use function array_merge;
use function auth;
use function dd;

class ItemServiceImp implements ItemService
{

    private ItemDTO $itemDTO;
    private MediaService $mediaService;

    public function __construct(ItemDTO $itemDTO, MediaService $mediaService)
    {
        $this->itemDTO = $itemDTO;
        $this->mediaService = $mediaService;
    }


    public function createItem($item)
    {
        $item['seller_id'] = auth()->user()->id;
        return DB::transaction(function () use ($item){
            $item['primary_image']=$this->mediaService->upload($item['primary_image']);
            $itemCreated = Item::create($item);
            $item['item_id'] = $itemCreated->id;
            ItemDetails::create($item);
            return $itemCreated;
        });
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
        $items =Item::with('seller', 'category', 'collection')
            ->leftJoin('ratings', 'items.id', '=', 'ratings.rateable_id')
            ->selectRaw('items.*, AVG(ratings.rating) as rating_average, COALESCE(COUNT(ratings.rating), 0) as rating_count')
            ->groupBy('items.id')
            ->orderByDesc('rating_average')
            ->limit(20)
            ->get();
        if($items->isEmpty())
            return null;
        return $this->itemDTO->mapItems($items);
    }

    public function showItem($id)
    {
        $item= Item::findOrFail($id);
        if(!$item)
            return null;
        return $this->itemDTO->mapItem($item);
    }
    public function showItemDetails($id)
    {
        return   Item::with('itemDetails')->findOrFail($id);
    }

    public function showItemsByCategory($category)
    {
        $items = Item::with('seller', 'category', 'collection')
            ->join('ratings', 'items.id', '=', 'ratings.rateable_id')
            ->selectRaw('items.*, AVG(ratings.rating) as rating_average')
            ->groupBy('items.id')
            ->orderByDesc('rating_average')
            ->limit(20)
            ->where('category_id', $category)
            ->get();
        if($items->isEmpty())
            return null;
        return $this->itemDTO->mapItems($items);
    }
    public function showItemsByCollection($collection)
    {
        $items = Item::with('seller', 'category', 'collection')
            ->join('ratings', 'items.id', '=', 'ratings.rateable_id')
            ->selectRaw('items.*, AVG(ratings.rating) as rating_average')
            ->groupBy('items.id')
            ->orderByDesc('rating_average')
            ->limit(20)
            ->where('collection_id', $collection->id)
            ->get();
        if($items->isEmpty())
            return null;
        return $this->itemDTO->mapItems($items);
    }


    public function showItemsBySeller($seller)
    {
        $items = Item::where('seller_id', auth()->user()->id)->get();
        return $items;
    }

    public function showItemsForSeller($seller)
    {
        $items = Item::where('seller_id', $seller->id)->get();
        return $this->itemDTO->mapItems($items);
    }

    public function updateStock($request, $item)
    {
        // TODO: Implement updateStock() method.
    }

    public function queryItems($category_ids, $collection_ids){
        $query = DB::table('items');
        if ($category_ids) {
            foreach ($category_ids as $category_id)
            $query->where('category_id', $category_id);
        }
        if ($collection_ids) {
            foreach ($collection_ids as $collection_id)
            $query->where('collection_id', $collection_id);
        }
        $items = $query->get();
        return $items;
        if ($items->isEmpty()) {
            return null;
        }
        return $this->itemDTO->mapItems($items);
    }
}
