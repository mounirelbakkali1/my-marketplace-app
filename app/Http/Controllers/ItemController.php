<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateItemDetailsRequest;
use App\Models\Item;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Services\ItemService;
use Exception;
use Illuminate\Http\Request;
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

    public function show($item)
    {
        $item = $this->itemService->getItem($item);
        if (!$item)
            return response()->json([
                'message' => 'Item not found',
            ], 404);
        return response()->json([
            'message' => 'Item retrieved successfully',
            'item' => $item
        ], 200);
    }



    public function update(UpdateItemRequest $request, Item $item)
    {
        $item = $this->itemService->updateItem($request, $item);
        return response()->json([
            'message' => 'Item updated successfully',
            'item' => $item
        ], 200);
    }

    public function destroy(Item $item)
    {
        $item = $this->itemService->deleteItem($item);
        return response()->json([
            'message' => 'Item deleted successfully',
            'item_id' => $item->id
        ], 200);
    }

    public function getDetails(Item $item)
    {
      try{
          $item = Item::with('itemDetails')->findOrFail($item->id);
          return response()->json([
              'message' => 'Item details retrieved successfully',
              'item' => $item
          ], 200);
      }catch (Exception $e){
            return response()->json([
                'message' => 'Error retrieving item details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateDetails(UpdateItemDetailsRequest $request, Item $item)
    {
        try{
            $item->itemDetails->update($request->validated());

            return response()->json([
                'message' => 'Item details updated successfully',
                'item' => $item
            ], 200);
        }catch (Exception $e){
            return response()->json([
                'message' => 'Error updating item details',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
