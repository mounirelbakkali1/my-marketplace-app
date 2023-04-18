<?php

namespace App\Services;

use App\Enums\ComplaintStatus;
use App\Models\Complaint;
use App\Models\ComplaintResolved;
use Illuminate\Support\Facades\Auth;
use function dd;

class ComplaintServiceImpl implements ComplaintService
{

    public function createComplaint($complaint)
    {
        return Complaint::create([
            'user_id' => Auth::user()->id,
            'complaint' => $complaint['complaint'],
            'complaint_type' => $complaint['complaint_type'],
            'additional_info' => $complaint['additional_info'],
        ]);
    }


    public function deleteComplaint($id)
    {
        // TODO: Implement deleteComplaint() method.
    }


    public function showComplaintsByUser($user)
    {
        // TODO: Implement showComplaintsByUser() method.
    }

    public function showComplaintsByStatus($status)
    {
        // TODO: Implement showComplaintsByStatus() method.
    }

    public function showComplaintsByType($type)
    {
        // TODO: Implement showComplaintsByType() method.
    }

    public function escalateComplaint($complaint,$note)
    {
        $complaint->complaint_status = ComplaintStatus::ESCALATED;
        $complaint->save();
        ComplaintResolved::create([
           'complaint_id' => $complaint->id,
              'resolved_by' => Auth::user()->id,
            'resolved_note' => $note,
        ]);
        return $complaint;
    }

    public function rejectComplaint($complaint,$note)
    {
        $complaint->complaint_status = ComplaintStatus::REJECTED;
        $complaint->save();
        ComplaintResolved::create([
            'complaint_id' => $complaint->id,
            'resolved_by' => Auth::user()->id,
            'resolved_note' => $note,
        ]);
        return $complaint;
    }
}
