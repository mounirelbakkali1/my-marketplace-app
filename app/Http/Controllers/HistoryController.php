<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Spatie\Activitylog\Models\Activity;
use function response;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activities  = Activity::with('causer:id,name')->get();
        $activities->map(function ($activity) {
            $createdAt = Carbon::parse($activity->created_at);
            $activity->created_at_human = $createdAt->diffForHumans();
            return $activity;
        });
        return response()->json([
            'message' => 'History retrieved successfully',
            'history' => $activities
        ],200);
    }

    public function show(string $id)
    {
        return response()->json([
            'message' => 'History retrieved successfully',
            'history' => activity()->where('id', $id)->get()
        ]);
    }

}
