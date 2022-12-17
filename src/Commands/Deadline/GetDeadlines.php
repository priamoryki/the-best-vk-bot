<?php

namespace Bot\Commands\Deadline;

use Bot\Utils\VKAdvancedAPI;

class GetDeadlines extends DeadlineCommand
{
    public function __construct(VKAdvancedAPI $vkApi)
    {
        parent::__construct($vkApi);
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
        $deadlines = $this->deadlinesRepository->getByUserId($user_id);
        $result = "";
        foreach ($deadlines as $deadline) {
            $id = $deadline->getId();
            $timestamp = $deadline->getTimestamp();
            $name = $deadline->getName();
            $result .= "name: $name, timestamp: $timestamp, id: $id\n";
        }
        if (strlen($result) == 0) {
            $result = "You don't have active deadlines!";
        }
        $this->sendMessage($user_id, $result);
    }
}
