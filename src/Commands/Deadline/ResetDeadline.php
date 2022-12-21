<?php

namespace Bot\Commands\Deadline;

use Bot\Commands\CommandException;
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
            throw new CommandException("Not enough arguments!");
        }
        if (!is_numeric($args[0])) {
            throw new CommandException("Id argument is not int!");
        }

        $id = intval($args[0]);
        $deadline = $this->deadlinesRepository->getById($id);

        if ($deadline->getUserId() != $user_id) {
            $this->sendMessage($user_id, "You don't have deadline with given id!");
        }

        $this->deadlinesRepository->removeById($deadline->getId());
        Crontab::removeTask($deadline->getCrontabCommand());

        $id = $deadline->getId();
        $name = $deadline->getName();
        $this->sendMessage($user_id, "Your deadline \"$name\" with id $id has been deleted!");
    }
}
