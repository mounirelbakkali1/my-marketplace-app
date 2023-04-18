<?php

namespace App\Http\Controllers;

use App\Enums\ComplaintStatus;
use App\Http\Requests\StoreComplaintRequest;
use App\Models\Complaint;
use App\Services\ComplaintService;
use App\Services\HandleDataLoading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function dd;

class ComplaintController extends Controller
{
    private HandleDataLoading $handleDataLoading;
    private ComplaintService $complaintService;

    /**
     * @param HandleDataLoading $handleDataLoading
     */
    public function __construct(HandleDataLoading $handleDataLoading,ComplaintService $complaintService)
    {
        $this->handleDataLoading = $handleDataLoading;
        $this->complaintService = $complaintService;
    }


    public function index()
    {
        return $this->handleDataLoading->handleCollection(function () {
            return Complaint::with('user:id,name,image')->orderByRaw("FIELD(complaint_status, 'pending', 'escalated','rejected')")
                ->get();
        }, 'complaints');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComplaintRequest $request)
    {
        $validated = $request->validated();
        return $this->handleDataLoading->handleAction(function () use ($validated) {
            return $this->complaintService->createComplaint($validated);
        }, 'complaint', 'creat');
    }


    public function show(Complaint $complaint)
    {
        $this->handleDataLoading->handleDetails(function () use ($complaint) {
            return $complaint;
        }, 'complaint', $complaint, 'retriev');
    }


    public function escalateComplaint(Request $request, Complaint $complaint)
    {
        $note = $request->note;
        $this->handleDataLoading->handleAction(function () use ($complaint,$note) {
            return $this->complaintService->escalateComplaint($complaint,$note);
        }, 'complaint', 'escalat');
    }

    public function closeComplaint(Request $request, Complaint $complaint)
    {
        $note = $request->note;
        $this->handleDataLoading->handleAction(function () use ($complaint,$note) {
            return $this->complaintService->rejectComplaint($complaint,$note);
        }, 'complaint', 'reject');
    }
}
