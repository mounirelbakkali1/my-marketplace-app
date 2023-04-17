<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ItemDTO
{
    public function mapItems(Collection $items)
    {
        return $items->map(function ($item) {
            return $this->mapItem($item);
        });
    }



    public function mapItem($item){
            $item['seller_name'] = $item->seller->name;
            $item['category_name'] = $item->category->name;
            $item['collection_name'] = $item->collection->name;
            $item['seller_image'] = $item->seller->image;

            unset($item['seller'], $item['category'], $item['collection'],$item['seller_id'], $item['category_id'], $item['collection_id']);
            return $item;
    }


    public function mapItemWithRating($item){
        $item = $this->mapItem($item);
        foreach ($item['ratings'] as $key => $rating){
            $createdAt = Carbon::parse($rating['created_at']);
            $ratings[$key]['created_at'] = $createdAt->diffForHumans();
        }
        return $rating;
    }

}
