<?php

namespace App\Services;

interface ComplaintService
{
    public function createComplaint($request);
    public function deleteComplaint($id);
    public function showComplaintsByUser($user);
    public function showComplaintsByStatus($status);
    public function showComplaintsByType($type);
    public function escalateComplaint($complaint,$note);
    public function rejectComplaint($complaint,$note);
}
