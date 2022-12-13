<?php

namespace Bot\Commands\Deadline;

use Bot\Commands\Command;
use Bot\Commands\Utils\Utils;
use Bot\Commands\Utils\VKAdvancedAPI;

class SetDeadline implements Command
{
    private VKAdvancedAPI $vkApi;

    public function __construct(VKAdvancedAPI $vkApi)
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
        // TODO: edit DB
        $date = "0-59 * * * *";
        $id = $user_id;
        $name = "TODO";
        $deadline = new Deadline($id, $user_id, $date, $name);
        $command = Utils::getDeadlineNotificationCommand($deadline->getDate(), $deadline->getUserId());
        Utils::addCrontabTask($command);

        $this->vkApi->messages()->send(BOT_TOKEN, [
            "peer_id" => $deadline->getUserId(),
            "random_id" => random_int(0, PHP_INT_MAX),
            "message" => "Deadline has been successfully set!",
        ]);
    }
}
