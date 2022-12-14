<?php

namespace Bot\Commands;

use Bot\Utils\VKAdvancedAPI;

abstract class VKCommand implements Command
{
    protected VKAdvancedAPI $vkApi;

    public function __construct(VKAdvancedAPI $vkApi)
    {
        $this->vkApi = $vkApi;
    }

    protected function sendMessage(int $user_id, string $message): void
    {
        $this->vkApi->messages()->send(BOT_TOKEN, [
            "peer_id" => $user_id,
            "random_id" => random_int(0, PHP_INT_MAX),
            "message" => $message,
        ]);
    }
}
