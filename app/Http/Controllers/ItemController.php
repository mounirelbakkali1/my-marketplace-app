<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Services\ItemService;

class ItemController extends Controller
{
    private $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }


    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(StoreItemRequest $request)
    {
        $this->itemService->createItem($request);
    }

    public function show(Item $item)
    {
        //
    }


    public function edit(Item $item)
    {
        //
    }


    public function update(UpdateItemRequest $request, Item $item)
    {
        //
    }

    public function destroy(Item $item)
    {
        //
    }
}
