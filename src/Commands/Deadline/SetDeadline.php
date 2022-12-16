<?php

namespace Bot\Commands\Deadline;

use Bot\Repositories\Entities\Deadline;
use Bot\Utils\Crontab;
use Bot\Utils\VKAdvancedAPI;

class SetDeadline extends DeadlineCommand
{
    private string $inputFormat = "Input format: min hour day mon year name.";

    public function __construct(VKAdvancedAPI $vkApi)
    {
        parent::__construct($vkApi);
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
        if (count($args) < 6) {
            $this->sendMessage($user_id, "Not enough arguments! $this->inputFormat");
            return;
        }
        for ($i = 0; $i < 5; $i++) {
            if (!is_numeric($args[$i])) {
                $this->sendMessage($user_id, "Invalid param on position $i!");
                return;
            }
        }
        // TODO: check deadline is active

        $date = "$args[0] $args[1] $args[2] $args[3] $args[4]";
        $name = join(" ", array_slice($args, 5));

        $deadline = new Deadline(0, $user_id, $date, $name);
        $deadline = $this->db->add($deadline);
        $command = Crontab::getDeadlineNotificationCommand($deadline->getDate(), $deadline->getId());
        Crontab::addTask($command);

        $id = $deadline->getId();
        $this->sendMessage($user_id, "Deadline \"$name\" with id $id has been successfully set!");
    }
}
