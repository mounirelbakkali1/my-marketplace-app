<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComplaintRequest;
use App\Models\Complaint;
use App\Services\HandleDataLoading;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    private HandleDataLoading $handleDataLoading;

    /**
     * @param HandleDataLoading $handleDataLoading
     */
    public function __construct(HandleDataLoading $handleDataLoading)
    {
        $this->handleDataLoading = $handleDataLoading;
    }


    public function index()
    {
        return $this->handleDataLoading->handleCollection(function () {
            return Complaint::with('user:id,name')->get();
        }, 'complaints');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComplaintRequest $request)
    {
        $validated = $request->validated();
        $this->handleDataLoading->handleAction(function () use ($validated) {
            return Complaint::create($validated);
        }, 'complaint', 'creat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Complaint $complaint)
    {
        $this->handleDataLoading->handleDetails(function () use ($complaint) {
            return $complaint;
        }, 'complaint', $complaint, 'retriev');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreComplaintRequest $request, Complaint $complaint)
    {
        $validated = $request->validated();
        $this->handleDataLoading->handleAction(function () use ($validated, $complaint) {
            return $complaint->update($validated);
        }, 'complaint', 'updat');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complaint $complaint)
    {
        $this->handleDataLoading->handleDestroy($complaint, 'complaint', 'delet');
    }
}
