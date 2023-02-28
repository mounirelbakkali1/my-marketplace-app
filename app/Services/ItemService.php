<?php

namespace App\Services;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;

interface ItemService
{
    public function createItem(StoreItemRequest $request);
    public function updateItem(UpdateItemRequest $request, $id);
    public function deleteItem($id);
    public function showItem($id);
    public function showItemsByCategory($category);
    public function showItemsBySeller($seller);
    public function getMostPopularItems();
    public function updateStock($request, $item);
}
