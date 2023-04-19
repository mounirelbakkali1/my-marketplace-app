<?php

namespace App\Services;

use App\Enums\ItemStatus;
use App\Models\Item;
use App\Models\ItemDetails;
use Illuminate\Support\Facades\Cache;
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
       // $item['seller_id'] = auth()->user()->id;
        $item['seller_id'] =27;
        return DB::transaction(function () use ($item){
            $item['primary_image']=$this->mediaService->upload($item['primary_image']);
            $itemCreated = Item::create($item);
            $item['item_id'] = $itemCreated->id;
            $itemDetails  = ItemDetails::create($item);
            return array_merge($itemCreated->toArray(), $itemDetails->toArray());
        });
    }

    public function updateItem( $validated, $item)
    {
       // $item['primary_image']!=null  ? $this->mediaService->upload($item['primary_image']) : $item['primary_image'] = $item->primary_image;
        $item->ItemDetails->update([
            'description' => $validated['description'],
            'stock' => $validated['stock'],
            'size' => $validated['size'],
            'color' => $validated['color'],
            'item_id' => $item->id,
            'condition' => $validated['condition'],
        ]);
        $item = $item->update([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'collection_id' => $validated['collection_id'],
            'primary_image' => $item['primary_image'],
            'seller_id' => $item->seller_id,
            'status' => $validated['status'],
            'price' => $validated['price'],
        ]);
        return $item;
    }

    public function deleteItem($id)
    {
        $item = Item::where('id', $id)->delete();
        return $item;
    }

    public function getMostPopularItems($categories, $collections)
    {
            $all =   Item::with('seller', 'category', 'collection')
                ->leftJoin('ratings', 'items.id', '=', 'ratings.rateable_id')
                ->selectRaw('items.*, AVG(ratings.rating) as rating_average')
                ->where('items.status', ItemStatus::AVAILABLE) // Add where clause to filter by status
                ->groupBy('items.id')
                ->orderByDesc('rating_average')
                ->limit(50);
            if (!empty($categories)) {
                $all->whereIn('category_id', $categories);
            }
            if (!empty($collections)) {
                $all->whereIn('collection_id', $collections);
            }
            $all = $all->get();
        if($all->isEmpty())
            return null;
        return $this->itemDTO->mapItems($all);
    }

    public function showItem($id)
    {
        $item= Cache::remember('item_',1,function() use ($id){
           return Item::with('itemDetails','ratings.user')->find($id);
        });
        if(!$item)
            return null;
        return $this->itemDTO->mapItem($item);
    }
    public function showItemDetails($id)
    {
        $item = Cache::remember('item_details',60*60,function() use ($id){
            return Item::with('itemDetails')->findOrFail($id);
        });
        return $item;
    }

    public function showItemsByCategory($category)
    {
        $items = Cache::remember('items_by_category',60*60,function() use ($category){
           return Item::with('seller', 'category', 'collection')
                ->join('ratings', 'items.id', '=', 'ratings.rateable_id')
                ->selectRaw('items.*, AVG(ratings.rating) as rating_average')
                ->groupBy('items.id')
                ->orderByDesc('rating_average')
                ->limit(20)
                ->where('category_id', $category)
                ->get();
        });
        if($items->isEmpty())
            return null;
        return $this->itemDTO->mapItems($items);
    }
    public function showItemsByCollection($collection)
    {
        $items = Cache::remember('items_by_collection',60*60,function() use ($collection){
            return Item::with('seller', 'category', 'collection')
                ->join('ratings', 'items.id', '=', 'ratings.rateable_id')
                ->selectRaw('items.*, AVG(ratings.rating) as rating_average')
                ->groupBy('items.id')
                ->orderByDesc('rating_average')
                ->limit(20)
                ->where('collection_id', $collection->id)
                ->get();
        });
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
        $items = Cache::remember('items_for_seller',60*60,function() use ($seller){
            return  Item::where('seller_id', $seller->id)->get();
        });
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
