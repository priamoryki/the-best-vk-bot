<?php

namespace Bot\Commands\Deadline;

use Bot\Entities\Deadline;
use Bot\Repositories\TimezonesRepository;
use Bot\Utils\Crontab;
use Bot\Utils\VKAdvancedAPI;
use DateTime;

class SetDeadline extends DeadlineCommand
{
    private int $TIME_ARGS_NUMBER = 2;
    private string $TIME_FORMAT = "H:i d-m-Y";
    private string $inputFormat = "Input format: hour:min day-mon-year name.";
    private TimezonesRepository $timezonesRepository;

    public function __construct(VKAdvancedAPI $vkApi)
    {
        parent::__construct($vkApi);
        $this->timezonesRepository = new TimezonesRepository();
    }

    public function getNames(): array
    {
        return ["set_deadline"];
    }

    public function getDescription(): string
    {
        return "Sets deadline. $this->inputFormat";
    }

    public function execute(int $user_id, array $args): void
    {
        if (count($args) < $this->TIME_ARGS_NUMBER + 1) {
            $this->sendMessage($user_id, "Not enough arguments! $this->inputFormat");
            return;
        }
        $date = DateTime::createFromFormat($this->TIME_FORMAT, "$args[0] $args[1]");
        if ($date === false) {
            $this->sendMessage($user_id, "Invalid date param");
            return;
        }
        $timezone = $this->timezonesRepository->getByUserId($user_id);
        if ($timezone == null) {
            $this->sendMessage($user_id, "Your timezone isn't set! Use set_timezone command!");
            return;
        }
        $date = $date->setTimestamp($date->getTimestamp() - 60 * 60 * $timezone);
        $timestamp = $date->getTimestamp();
        if (time() >= $timestamp) {
            $this->sendMessage($user_id, "This deadline has already expired!");
            return;
        }

        $deadline = new Deadline(0, $user_id, $timestamp, join(" ", array_slice($args, $this->TIME_ARGS_NUMBER)));
        $deadline = $this->deadlinesRepository->add($deadline);
        $command = Crontab::getDeadlineNotificationCommand($deadline->getTimestamp(), $deadline->getId());
        Crontab::addTask($command);

        $id = $deadline->getId();
        $name = $deadline->getName();
        $this->sendMessage($user_id, "Deadline \"$name\" with id $id has been successfully set!");
    }
}
