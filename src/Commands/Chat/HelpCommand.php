<?php

namespace Bot\Commands\Chat;

use Bot\Commands\CommandsStorage;
use Bot\Commands\VKCommand;
use Bot\Utils\VKAdvancedAPI;

class HelpCommand extends VKCommand
{
    private CommandsStorage $storage;

    public function __construct(VKAdvancedAPI $vkApi, CommandsStorage &$storage)
    {
        parent::__construct($vkApi);
        $this->storage = &$storage;
    }

    public function getNames(): array
    {
        return ["help"];
    }

    public function getDescription(): string
    {
        return "Returns all commands with their descriptions";
    }

    public function execute(int $user_id, array $args): void
    {
        $result = "Command name: description\n\n";
        foreach ($this->storage->getCommands() as $command) {
            $names = join(", ", $command->getNames());
            $description = $command->getDescription();
            $result .= "$names: $description\n";
        }
        $this->sendMessage($user_id, $result);
    }
}