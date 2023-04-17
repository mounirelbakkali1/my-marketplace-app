<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdressRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\StoreShippingInfoRequest;
use App\Models\OrderItem;
use App\Services\HandleDataLoading;
use App\Services\OrderService;

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

}
