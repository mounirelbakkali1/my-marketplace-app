<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\Seller;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use function response;

class HistoryController extends Controller
{
    public function __construct()
    {
      //  Auth::login(Seller::find(27));   // TODO: remove this line
        $this->middleware(['auth:api'], ['except' => ['index', 'show','getDetails','queryItems']]);
    }
    public function getSellersLogs()
    {
        // TODO : check the user role and return the history of the user
        $activities  = Activity::with('causer:id,name')
            ->whereHasMorph('causer', ['App\Models\User'], function ($query) {
                $query->where('model_type', Role::SELLER);
            })
            ->get();
        return $this->mapAndReturn($activities);
    }

    public function show(string $id)
    {
        return response()->json([
            'message' => 'History retrieved successfully',
            'history' => activity()->where('id', $id)->get()
        ]);
    }

    public function getSellerActivities(Seller $seller){
        $user = Auth::user();
        $activities  = Activity::with('causer:id,name')
            ->where(function ($query) use ($user) {
                $itemIds = Seller::find($user->id)->items()->pluck('id');
                $query->where('subject_type', 'App\Models\Item')
                    ->whereIn('subject_id', $itemIds)
                    ->where('causer_id', $user->id);
            })->get();
        return $this->mapAndReturn($activities);
    }



    private function mapAndReturn(Collection|array $data)
    {
        $data->map(function ($activity) {
            $createdAt = Carbon::parse($activity->created_at);
            $activity->created_at_human = $createdAt->diffForHumans();
            return $activity;
        });
        return response()->json([
            'message' => 'history retrieved successfully',
            'history' => $data,
        ],200);
    }

}
