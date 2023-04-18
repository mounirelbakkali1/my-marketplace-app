<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Http\Requests\StoreAdressRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\StoreShippingInfoRequest;
use App\Models\Address;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderServiceImpl implements OrderService
{

    public function createOrder(StoreOrderRequest $orderItemRequest,
                                StoreShippingInfoRequest $shippingInfoRequest,
                                StoreAdressRequest $addressRequest)
    {
       return  DB::transaction(function() use ($orderItemRequest, $shippingInfoRequest, $addressRequest){
           $user = Auth::user();
            $address = $addressRequest->validated();
            $address = Address::create($address);
            $orderItem = $orderItemRequest->validated();
            $item = Item::find($orderItem['item_id']);
           $order = Order::create(['user_id' => $user->id,'total_price' => $item['price']*$orderItem['quantity']]);
           $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $orderItem['item_id'],
                'quantity' => $orderItem['quantity'],
                'item_price' => $item['price'],
            ]);
           $shippingInfo = $shippingInfoRequest->validated();
            ShippingInfo::create([
                'order_id' => $order->id,
                'address_id' => $address->id,
                'name' => $shippingInfo['name'],
                'phone' => $shippingInfo['phone'],
            ]);
       return $order;
        }, 5);
    }

    public function getCustomerOrders($customer_id)
    {
        $orders = Order::with('orderItems.item', 'shippingInfo.address')
            ->where('user_id', $customer_id)
            ->get();
        foreach ($orders as $key => $order){
            $order->git  = Carbon::parse($order->created_at)->diffForHumans();
        }
        return $orders;
    }

    public function deleteOrder($id)
    {
        // TODO: Implement deleteOrder() method.
    }

    public function showOrder($id)
    {
        // TODO: Implement showOrder() method.
    }

    public function makeOrderAsShipped($order)
    {
        $order->update(['status' => OrderStatus::SHIPPED]);
    }

    public function makeOrderAsDelivered($order)
    {
        $order->status = OrderStatus::DELIVERED;
        $order->save();
        return $order;
    }
    public function makeOrderAsCancelled($order)
    {
        $order->status = OrderStatus::CANCELLED;
        $order->save();
        return $order;
    }
    public function makeOrderAsConfirmed($order)
    {
        $order->status = OrderStatus::CONFIRMED;
        $order->save();
        return $order;
    }


    public function getOrders(){
        // get all orders related to seller items
        $seller = Auth::user();
        $orders = Order::with('OrderItems.item','user', 'shippingInfo.address')
            ->whereHas('orderItems', function($query) use ($seller){
            $query->whereHas('item', function($query) use ($seller){
                $query->where('seller_id', $seller->id);
            });
        })->get();
        foreach ($orders as $key => $order){
            $order->create_at_for_humman = Carbon::parse($order->created_at)->diffForHumans();
        }
        return $orders;
    }
}
