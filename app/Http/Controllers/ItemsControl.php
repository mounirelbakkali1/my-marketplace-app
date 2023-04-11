<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Services\HandleDataLoading;
use App\Services\ItemDTO;
use Illuminate\Http\Request;

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
            return $this->itemDTO->mapItems(Item::with('seller', 'category', 'collection')->latest()->take(100)->get());
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
        //TODO: suspend item
    }
}
