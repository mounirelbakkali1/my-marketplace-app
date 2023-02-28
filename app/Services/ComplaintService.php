<?php

namespace App\Services;

interface ComplaintService
{
    public function createComplaint($request);
    public function updateComplaint($request, $id);
    public function deleteComplaint($id);
    public function showComplaint($id);
    public function showComplaintsByUser($user);
    public function showComplaintsByStatus($status);
    public function showComplaintsByType($type);
    public function escalateComplaint($id);
}
