<?php

namespace Bot\Commands\Chat;

use Bot\Commands\VKCommand;
use Bot\Utils\VKAdvancedAPI;

class HelloCommand extends VKCommand
{
    public function __construct(VKAdvancedAPI $vkApi)
    {
        parent::__construct($vkApi);
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

        $this->sendMessage($user_id, "Hello, ${user["first_name"]}!");
    }
}
