<?php

namespace Bot\Commands\Chat;

use Bot\Commands\Command;
use Bot\Commands\Utils\VKAdvancedAPI;

class HelloCommand implements Command
{
    private VKAdvancedAPI $vkApi;

    public function __construct(VKAdvancedAPI $vkApi)
    {
        $this->vkApi = $vkApi;
    }

    public function getNames(): array
    {
        return ["hello"];
    }

    public function getDescription(): string
    {
        return "Prints hello message to the chat";
    }

    public function execute(int $user_id, array $args): void
    {
        $users_get_response = $this->vkApi->users()->get(BOT_TOKEN, [
            "user_ids" => [$user_id]
        ]);
        $user = $users_get_response[0];

        $this->vkApi->messages()->send(BOT_TOKEN, [
            "peer_id" => $user_id,
            "random_id" => random_int(0, PHP_INT_MAX),
            "message" => "Hello, ${user["first_name"]}!",
        ]);
    }
}
