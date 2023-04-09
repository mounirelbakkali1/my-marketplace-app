<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Seller;
use App\Models\User;
use function dd;
use function get_class;

class ActivityService
{
    public function createActivity($action,$model,$causer,$message)
    {
        $causerType = $this->getModel($causer);
        dd($causerType,$causer->getRoleNames());
        activity()
            ->performedOn($model)
            ->causedBy($causer)
            ->withProperties([
                'causer_id' => $causer->id,
                'causer_type' => $causerType,
                'model_id' => $model->id,
                'message' => $message
            ])
            ->log($action);
    }

    private function getModel($model){

        if($model instanceof Seller)
            return Seller::class;
        elseif($model instanceof Employee)
            return Employee::class;
        elseif($model instanceof Admin)
            return Admin::class;
        elseif($model instanceof Client)
            return Client::class;
        else
            return User::class;
    }

}
