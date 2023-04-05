<?php

namespace App\Services;

use App\Models\Item;
use App\Models\Seller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use function activity;
use function response;

class HandleDataLoading
{
    public function handleCollection($call,$callable)
    {
        try{
            $data = $call();
            if (!$data || $data->isEmpty())
                return response()->json([
                    'status' => 'error',
                    'message' => 'No '.$callable.' found',
                ], 204);
            return response()->json([
                'message' => $callable.' retrieved successfully',
                $callable => $data
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving '.$callable,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function handleDetails($call , $callable,$nullable,$action){
        // nullable is the piece of data to get its details
        if (!$nullable)
            return response()->json([
                'message' => $callable.' not found',
            ], 204);
        return $this->handleAction(function () use ($call){
            return $call();
        },$callable,$action);
    }

    public function handleDestroy($nullable,$callable,$action){
            if (!$nullable)
                return response()->json([
                    'status' => false,
                    'message' => $callable.' not found',
                ], 204);
            return $this->handleAction(function () use ($nullable){
                $nullable->delete();
            },$callable,$action);
        }




        public function handleAction($call,$callable,$action){
        // TODO: to modify just for testing
            $seller = User::where('id',27)->first();
            $item = Item::where('seller_id',27)->first();
            try{
                $return  = $call();
                $message = $callable .' '.$action.'ed';
                activity()
                    ->performedOn($item)
                    ->causedBy($seller)
                    ->log($message);
                return response()->json([
                    'message' => $message,
                    $callable => $return
                ], 200);
            }catch (Exception $e){
                return response()->json([
                    'message' => 'Error '.$action.'ing '.$callable,
                    'error' => $e->getMessage()
                ], 500);

            }
        }

}
