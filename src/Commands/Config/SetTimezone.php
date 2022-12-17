<?php

namespace Bot\Commands\Config;

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
            $this->sendMessage($user_id, "Not enough arguments!");
            return;
        }
        if (!is_numeric($args[0])) {
            $this->sendMessage($user_id, "Timezone argument is not int!");
            return;
        }

        $timezone = intval($args[0]);
        $this->timezonesRepository->add($user_id, $timezone);

        $this->sendMessage($user_id, "Timezone $timezone has been successfully set!");
    }
}
