<?php

namespace App\Services;

class UISGeneratorImpl implements UISGenerator
{
    public function generateUIS($data): string
    {
        $jsonData = json_encode($data);
        $base64Data = base64_encode($jsonData);
        $token = bin2hex(random_bytes(16));
        $uis = $token . '|' . $base64Data;
        return $uis;
    }

    public function decodeUIS($uis): array
    {
        $tokenAndData = explode('|', $uis);
        $token = $tokenAndData[0];
        $base64Data = $tokenAndData[1];
        $jsonData = base64_decode($base64Data);
        $data = json_decode($jsonData, true);
        return $data;
    }
}

