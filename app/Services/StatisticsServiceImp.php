<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use function count;

class StatisticsServiceImp implements StatisticsService
{

    public function getStatisticsForSeller(): array
    {
        $seller = Auth::user();
        $sales = Order::with('OrderItems.item')
            ->whereHas('orderItems', function($query) use ($seller){
                $query->whereHas('item', function($query) use ($seller){
                    $query->where('seller_id', $seller->id);
                });
            })
            ->where('status',OrderStatus::DELIVERED)
            ->get();
        $totalSales = count($sales);
        $sellerClients = $sales->unique('user_id');
        $totalClients = count($sellerClients);
        $totalItems = Item::where('seller_id', $seller->id)->count();
        return [
            'totalSales' => $totalSales,
            'totalClients' => $totalClients,
            'totalItems' => $totalItems,
        ];
    }

    public function getStatisticsForEmployee(): array
    {
        return [
            'totalSales' => 0,
            'totalClients' => 0,
            'totalItems' => 0,
        ];
    }

    public function getStatisticsForAdmin(): array
    {
        $sales = Order::where('status',OrderStatus::DELIVERED)->get();
        $totalSales = count($sales);
        $sellerClients = $sales->unique('user_id');
        $totalClients = count($sellerClients);
        $totalItems = Item::all()->count();
        return [
            'totalSales' => $totalSales,
            'totalClients' => $totalClients,
            'totalItems' => $totalItems,
        ];
    }
}
