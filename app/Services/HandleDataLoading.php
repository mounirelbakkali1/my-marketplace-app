<?php

namespace App\Services;

use Exception;
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
            try{
                $return  = $call();
                return response()->json([
                    'message' => $callable.' '.$action.'ed successfully',
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
