<?php

namespace Bot\Commands\Deadline;

use Bot\Entities\Deadline;
use Bot\Repositories\TimezonesRepository;
use Bot\Utils\VKAdvancedAPI;

class GetDeadlines extends DeadlineCommand
{
    private string $TIME_FORMAT = "H:i d-m-Y";
    private TimezonesRepository $timezonesRepository;

    public function __construct(VKAdvancedAPI $vkApi)
    {
        parent::__construct($vkApi);
        $this->timezonesRepository = new TimezonesRepository();
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
        $timezone = $this->timezonesRepository->getByUserId($user_id);
        $deadlines = $this->deadlinesRepository->getByUserId($user_id);
        usort(
            $deadlines,
            function (Deadline $a, Deadline $b) {
                $a_timestamp = $a->getTimestamp();
                $b_timestamp = $b->getTimestamp();
                if ($a_timestamp == $b_timestamp) {
                    return 0;
                }
                return $a_timestamp < $b_timestamp ? -1 : 1;
            }
        );
        $result = "";
        foreach ($deadlines as $deadline) {
            $id = $deadline->getId();
            $timestamp = date($this->TIME_FORMAT, $deadline->getTimestamp() + 60 * 60 * $timezone);
            $name = $deadline->getName();
            $result .= "name: $name, date: $timestamp, id: $id\n";
        }
        if (strlen($result) == 0) {
            $result = "You don't have active deadlines!";
        }
        $this->sendMessage($user_id, $result);
    }
}
