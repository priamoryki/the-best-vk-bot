<?php

namespace Bot\Commands\Deadline;

use Bot\Commands\Command;
use Bot\Commands\Utils\Utils;
use VK\Client\VKApiClient;

class SetDeadline implements Command
{
    private VKApiClient $vkApi;

    public function __construct(VKApiClient $vkApi)
    {
        $this->vkApi = $vkApi;
    }

    public function getNames(): array
    {
        return ["set_deadline"];
    }

    public function getDescription(): string
    {
        return "Sets deadline";
    }

    public function execute(int $user_id, array $args): void
    {
        // TODO: Implement execute() method.
        $date = "0-59 * * * *";
        // TODO: edit DB
        $command = Utils::getDeadlineNotificationCommand($date, $user_id);
        Utils::addCrontabTask($command);

        $this->vkApi->messages()->send(BOT_TOKEN, [
            "peer_id" => $user_id,
            "random_id" => random_int(0, PHP_INT_MAX),
            "message" => "Deadline has been successfully set!",
        ]);
    }
}
