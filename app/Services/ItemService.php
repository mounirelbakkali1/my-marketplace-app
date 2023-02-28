<?php

namespace App\Services;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;

interface ItemService
{
    public function createItem(StoreItemRequest $request);
    public function updateItem(UpdateItemRequest $request, $id);
    public function deleteItem($id);
    public function getMostPopularItems();
}
