<?php

namespace App\Services;

interface ChatService
{
    public function createChat($request);
    public function deleteChat($chat_id);
    public function showChat($chat_id);
    public function showChatsByUser($user);
    public function sendMessage($user, $chat_id, $message);
    public function showMessages($chat_id);

}
