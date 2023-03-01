<?php

namespace App\Services;

use App\Http\Requests\StoreAdressRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\StoreShippingInfoRequest;
use App\Models\Address;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderServiceImpl implements OrderService
{
    private $orderItemRequest;
    private $shippingInfoRequest;
    private $addressRequest;

    public function __construct
    (
        StoreOrderRequest $orderItemRequest,
        StoreShippingInfoRequest $shippingInfoRequest,
        StoreAdressRequest $addressRequest
    ){
        $this->orderItemRequest = $orderItemRequest;
        $this->shippingInfoRequest = $shippingInfoRequest;
        $this->addressRequest = $addressRequest;
    }



    public function createOrder($request)
    {
        $order = Order::create(['user_id' => Auth::user()->id]);
        $address = $this->addressRequest->validated();
        $orderItem = $this->orderItemRequest->validated();
        $shippingInfo = $this->shippingInfoRequest->validated();
        $order->orderItem->create(['order_id' => $order->id,$orderItem]);
        $order->shippingInfo->create(['order_id' => $order->id,$shippingInfo,new Address($address)]);
    }

    public function deleteOrder($id)
    {
        // TODO: Implement deleteOrder() method.
    }

    public function showOrder($id)
    {
        // TODO: Implement showOrder() method.
    }

    public function makeOrderAsShipped($id)
    {
        // TODO: Implement makeOrderAsShipped() method.
    }

    public function makeOrderAsDelivered($id)
    {
        // TODO: Implement makeOrderAsDelivered() method.
    }
}
