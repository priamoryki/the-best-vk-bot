<?php

namespace Bot\Commands\Deadline;

use Bot\Commands\Command;
use Bot\Commands\Utils\VKAdvancedAPI;

class GetDeadlines implements Command
{
    private VKAdvancedAPI $vkApi;

    public function __construct(VKAdvancedAPI $vkApi)
    {
        $this->vkApi = $vkApi;
    }

    public function getNames(): array
    {
        return ["get_deadlines"];
    }

    public function getDescription(): string
    {
        return "Sends message with all your deadlines";
    }

    public function execute(int $user_id, array $args): void
    {
        // TODO: Implement execute() method.
        $this->vkApi->messages()->send(BOT_TOKEN, [
            "peer_id" => $user_id,
            "random_id" => random_int(0, PHP_INT_MAX),
            "message" => "It's not working yet!",
        ]);
    }
}
