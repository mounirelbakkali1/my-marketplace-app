<?php

namespace App\Services;

interface StatisticsService
{
    public function getStatisticsForSeller(): array;
    public function getStatisticsForEmployee(): array;
    public function getStatisticsForAdmin(): array;
}
