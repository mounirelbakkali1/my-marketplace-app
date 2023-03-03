<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Services\ItemService;
use function response;

class ItemController extends Controller
{
    private $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }


    public function index()
    {
        try{
            $items = $this->itemService->getMostPopularItems();
            return response()->json([
                'message' => 'Items retrieved successfully',
                'items' => $items
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving items',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function create()
    {
        return view('item.create');
    }


    public function store(StoreItemRequest $request)
    {
        $item = $this->itemService->createItem($request);
        return response()->json([
            'message' => 'Item created successfully',
            'item' => $item
        ], 201);
    }

    public function show(Item $item)
    {
        $item = $this->itemService->showItem($item);
    }


    public function edit(Item $item)
    {
        return view('item.edit', compact('item'));
    }


    public function update(UpdateItemRequest $request, Item $item)
    {
        $this->itemService->updateItem($request, $item);
        return redirect()->back();
    }

    public function destroy(Item $item)
    {
        $this->itemService->deleteItem($item);
        return redirect()->back();
    }




}
