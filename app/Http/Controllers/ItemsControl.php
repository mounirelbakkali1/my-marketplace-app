<?php

namespace App\Http\Controllers;

use App\Enums\ItemStatus;
use App\Models\Item;
use App\Services\HandleDataLoading;
use App\Services\ItemDTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ItemsControl extends Controller
{

    private HandleDataLoading $handleDataLoading;
    private ItemDTO $itemDTO;

    /**
     * @param HandleDataLoading $handleDataLoading
     */
    public function __construct(HandleDataLoading $handleDataLoading, ItemDTO $itemDTO)
    {
        $this->middleware(['auth:api','employeeOnly']);
        $this->handleDataLoading = $handleDataLoading;
        $this->itemDTO = $itemDTO;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->handleDataLoading->handleCollection(function () {
            return Cache::remember('items_for_control', 60 * 60 * 24, function () {
                return $this->itemDTO->mapItems(Item::with('seller', 'category', 'collection')->latest()->take(100)->get());
            });
        }, 'items');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    public function suspendItem(Request $request,Item $item){
        $item->update([
            'status' => ItemStatus::SUSPENDED
        ]);
        return response()->json([
            'message' => 'Item suspended successfully'
        ]);
    }
    public function unsuspendItem(Request $request,Item $item){
        $item->update([
            'status' => ItemStatus::AVAILABLE
        ]);
        return response()->json([
            'message' => 'Item unsuspended successfully'
        ]);
    }
}
