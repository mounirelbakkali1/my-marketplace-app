<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Services\HandleDataLoading;
use App\Services\OrderService;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use function dd;
use function in_array;
use function retry;

class OrderController extends Controller
{
    private OrderService $orderService;
    private HandleDataLoading $handleDataLoading;

    public function __construct(OrderService $orderService,HandleDataLoading $handleDataLoading)
    {
        $this->orderService = $orderService;
        $this->handleDataLoading = $handleDataLoading;
        $this->middleware(['auth:api']);
    }

    public function index()
    {
        $user = Auth::user();
        if($user->hasRole('seller')){
            return $this->handleDataLoading->handleAction(function(){
                return $this->orderService->getOrders();
            }, 'orders', 'get');
        }
    }
    public function confirmOrder(Order $order){
    /*    if(!$this->owner($order)){
            return response()->json(['message' => 'You are not authorise to confirm the order'], 403);
        }*/
        return $this->handleDataLoading->handleAction(function() use ($order){
            return $this->orderService->makeOrderAsConfirmed($order);
        }, 'order', 'confirm');
    }

    public function cancelOrder(Order $order){
      /*  if (!$this->owner($order)){
            return response()->json(['message' => 'You are not authorise to cancle the order'], 403);
        }*/
        return $this->handleDataLoading->handleAction(function() use ($order){
            return $this->orderService->makeOrderAsCancelled($order);
        }, 'order', 'cancl');
    }


    public function deliverOrder(Order $order){
      /*  if (!$this->owner($order)){
            return response()->json(['message' => 'You are not authorise to deliver the order'], 403);
        }*/
        return $this->handleDataLoading->handleAction(function() use ($order){
            return $this->orderService->makeOrderAsDelivered($order);
        }, 'order', 'deliver');
    }




    private function owner($order){
        $user = Auth::user();
        $in =false;
        if($user->hasRole('seller')){
          $orders = $this->orderService->getOrders();
            foreach ($orders as $o){
                if($o->id == $order->id){
                    $in= true;
                }
            }
        }
        return $in;
    }

}
