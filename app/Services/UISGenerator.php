<?php

namespace App\Services;

interface UISGenerator
{
    public function generateUIS(array $data): string;
    public function decodeUIS(string $uis): array;
}
