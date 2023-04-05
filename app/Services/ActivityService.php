<?php

namespace App\Services;

use App\Models\User;
use function class_exists;

class ActivityService
{
    public function createActivity($action,$model,$causer,$message)
    {
        activity()
            ->performedOn($model)
            ->causedBy($causer)
            ->withProperties([
                'causer_id' => $causer->id,
                'model_id' => $model->id,
                'message' => $message
            ])
            ->log($action);
    }

    private function getModel($model){

        $className = "App\Models\\".ucfirst($model);
        if (class_exists($className))
            return new  $className;
        return null;
    }

}
