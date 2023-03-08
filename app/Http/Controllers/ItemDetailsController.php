<?php

namespace App\Http\Controllers;

use App\Models\ItemDetails;
use App\Http\Requests\StoreItemDetailsRequest;
use App\Http\Requests\UpdateItemDetailsRequest;

class ItemDetailsController extends Controller
{


    public function store(StoreItemDetailsRequest $request)
    {
        //
    }



    public function show(ItemDetails $itemDetails)
    {

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
