<?php

namespace Bot\Commands\Config;

use Bot\Commands\CommandException;
use Bot\Commands\VKCommand;
use Bot\Repositories\TimezonesRepository;
use Bot\Utils\VKAdvancedAPI;

class SetTimezone extends VKCommand
{
    private TimezonesRepository $timezonesRepository;

    public function __construct(VKAdvancedAPI $vkApi)
    {
        parent::__construct($vkApi);
        $this->timezonesRepository = new TimezonesRepository();
    }

    public function getNames(): array
    {
        return ["set_timezone"];
    }

    public function getDescription(): string
    {
        return "Sets your timezone";
    }

    public function execute(int $user_id, array $args): void
    {
        if (count($args) < 1) {
            throw new CommandException("Not enough arguments!");
        }
        if (!is_numeric($args[0])) {
            throw new CommandException("Timezone argument is not int!");
        }
        $timezone = intval($args[0]);
        if (12 < $timezone || $timezone < -12) {
            throw new CommandException("Timezone is not in range [-12, 12]!");
        }

        $this->timezonesRepository->add($user_id, $timezone);

        $this->sendMessage($user_id, "Timezone $timezone has been successfully set!");
    }
}
