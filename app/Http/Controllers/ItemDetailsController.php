<?php

namespace App\Http\Controllers;

use App\Models\ItemDetails;
use App\Http\Requests\StoreItemDetailsRequest;
use App\Http\Requests\UpdateItemDetailsRequest;

class ItemDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemDetailsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemDetails $itemDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemDetails $itemDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemDetailsRequest $request, ItemDetails $itemDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemDetails $itemDetails)
    {
        //
    }
}
