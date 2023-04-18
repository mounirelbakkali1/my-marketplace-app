<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdressRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\StoreShippingInfoRequest;
use App\Models\OrderItem;
use App\Models\User;
use App\Services\HandleDataLoading;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;

class OrderItemController extends Controller
{

    private OrderService $orderService;
    private HandleDataLoading $handleDataLoading;



    public function __construct(OrderService $orderService,HandleDataLoading $handleDataLoading)
    {
        $this->orderService = $orderService;
        $this->handleDataLoading = $handleDataLoading;
        $this->middleware(['auth:api']);
    }

    public function store(StoreOrderRequest $orderItemRequest,
                          StoreShippingInfoRequest $shippingInfoRequest,
                          StoreAdressRequest $addressRequest)
    {
        return $this->handleDataLoading->handleAction(function() use ($orderItemRequest, $shippingInfoRequest, $addressRequest){
            return $this->orderService->createOrder($orderItemRequest, $shippingInfoRequest, $addressRequest);
        }, 'order', 'creat');
    }

    public function show(OrderItem $orderItem)
    {
        //
    }
    public function findCustomerOrders(User $user){
        if($user->id != Auth::user()->id){
            return response()->json(['message' => 'You are not authorise to view this customer orders'], 403);
        }
        return $this->handleDataLoading->handleAction(function() use ($user){
            return $this->orderService->getCustomerOrders($user->id);
        }, 'orders', 'retreiv');
    }

}
