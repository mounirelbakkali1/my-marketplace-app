<?php

namespace App\Observers;

use App\Models\Item;
use Illuminate\Support\Facades\Cache;

class ItemObserver
{
    /**
     * Handle the Item "created" event.
     */
    public function created(Item $item): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Item "updated" event.
     */
    public function updated(Item $item): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Item "deleted" event.
     */
    public function deleted(Item $item): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Item "restored" event.
     */
    public function restored(Item $item): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Item "force deleted" event.
     */
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
