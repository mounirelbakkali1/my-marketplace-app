<?php

namespace App\Services;

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
}
