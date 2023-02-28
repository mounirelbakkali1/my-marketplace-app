<?php

namespace App\Services;

interface OrderService
{
    public function createOrder($request);
    public function deleteOrder($id);
    public function showOrder($id);
    public function makeOrderAsShipped($id);
    public function makeOrderAsDelivered($id);
}
