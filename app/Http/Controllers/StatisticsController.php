<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Services\HandleDataLoading;
use App\Services\StatisticsService;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    private StatisticsService $statisticsService;
    private HandleDataLoading $handleDataLoading;

    /**
     * @param StatisticsService $statisticsService
     * @param HandleDataLoading $handleDataLoading
     */
    public function __construct(StatisticsService $statisticsService, HandleDataLoading $handleDataLoading)
    {
        $this->statisticsService = $statisticsService;
        $this->handleDataLoading = $handleDataLoading;
    }


    public function getStatisticsForSeller()
    {
        return  $this->handleDataLoading->handleAction(function ()  {
            return $this->statisticsService->getStatisticsForSeller();
        }, 'statistics', 'retriev');
    }

    public function getStatisticsForEmployee(): array
    {
        return [];
    }

    public function getStatisticsForAdmin()
    {
        return  $this->handleDataLoading->handleAction(function ()  {
            return $this->statisticsService->getStatisticsForAdmin();
        }, 'statistics', 'retriev');
    }
}
