<?php

namespace App\Observers;

use App\Models\Item;
use Illuminate\Support\Facades\Cache;

class ItemObserver
{

    public function created(Item $item): void
    {
        $this->clearCache();
    }


    public function updated(Item $item): void
    {
        $this->clearCache();
    }


    public function deleted(Item $item): void
    {
        $this->clearCache();
    }



    public function restored(Item $item): void
    {
        $this->clearCache();
    }


    public function forceDeleted(Item $item): void
    {
        $this->clearCache();
    }


    private function clearCache(): void
    {
        Cache::forget('most_popular_items');
        Cache::forget('item_');
        Cache::forget('item_details');
        Cache::forget('items_by_category');
        Cache::forget('items_by_collection');
        Cache::forget('items_for_seller');
    }
}
