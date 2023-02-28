<?php

namespace App\Http\Controllers;

use App\Services\ItemService;

class HomeController extends Controller
{
    private $itemService ;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    public function index()
    {
        $items = $this->itemService->getMostPopularItems();
        return $items;
    }
}
