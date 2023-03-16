<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Http\Requests\StoreCollectionRequest;
use App\Http\Requests\UpdateCollectionRequest;
use App\Services\HandleDataLoading;

class CollectionController extends Controller
{
    private HandleDataLoading $handleDataLoading;

    public function __construct(HandleDataLoading $handleDataLoading)
    {
        $this->handleDataLoading = $handleDataLoading;
    }


    public function index()
    {
        return $this->handleDataLoading->handleCollection(function () {
            return Collection::all();
        }, 'collections');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCollectionRequest $request)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Collection $collection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCollectionRequest $request, Collection $collection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($collection)
    {
        $collection = Collection::find($collection);
        return $this->handleDataLoading->handleDestroy($collection, 'collection','delet');
    }
}
