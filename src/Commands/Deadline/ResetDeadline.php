<?php

namespace Bot\Commands\Deadline;

use Bot\Utils\Crontab;
use Bot\Utils\VKAdvancedAPI;

class ResetDeadline extends DeadlineCommand
{
    public function __construct(VKAdvancedAPI $vkApi)
    {
        parent::__construct($vkApi);
    }

    public function getNames(): array
    {
        return ["reset_deadline"];
    }

    public function getDescription(): string
    {
        return "Resets deadline by it's id";
    }

    public function execute(int $user_id, array $args): void
    {
        if (count($args) < 1) {
            $this->sendMessage($user_id, "Not enough arguments!");
        }

        $id = intval($args[0]);
        $deadline = $this->db->getById($id);

        $this->db->removeById($deadline->getId());
        $command = Crontab::getDeadlineNotificationCommand($deadline->getDate(), $deadline->getId());
        Crontab::removeTask($command);

        $id = $deadline->getId();
        $name = $deadline->getName();
        $this->sendMessage($user_id, "Your deadline \"$name (id: $id)\" has been deleted!");
    }
}
