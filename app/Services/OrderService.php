<?php

namespace App\Services;

use App\Http\Requests\StoreAdressRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\StoreShippingInfoRequest;

interface OrderService
{
    public function createOrder(StoreOrderRequest $orderItemRequest,
                                StoreShippingInfoRequest $shippingInfoRequest,
                                StoreAdressRequest $addressRequest);
    public function deleteOrder($id);
    public function showOrder($id);
    public function makeOrderAsShipped($id);
    public function makeOrderAsConfirmed($id);
    public function makeOrderAsDelivered($id);
    public function makeOrderAsCancelled($id);
}
