<?php

namespace App\Http\Controllers;

use App\Enums\ComplaintStatus;
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
            return Complaint::with('user:id,name,image')->get();
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


    public function escalateComplaint(Request $request, Complaint $complaint)
    {
        $this->handleDataLoading->handleAction(function () use ($complaint) {
            $complaint->complaint_status = ComplaintStatus::ESCALATED;
            $complaint->save();
            return $complaint;
        }, 'complaint', 'escalat');
    }

    public function closeComplaint(Request $request, Complaint $complaint)
    {
        $this->handleDataLoading->handleAction(function () use ($complaint) {
            $complaint->complaint_status = ComplaintStatus::REJECTED;
            $complaint->save();
            return $complaint;
        }, 'complaint', 'reject');
    }
}
