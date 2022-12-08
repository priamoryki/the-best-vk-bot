<?php

namespace Bot\Commands;

use Exception;

class CommandsStorage
{
    private array $commands;

    public function __construct(Command ...$commands)
    {
        $this->commands = array();
        $this->addCommands(...$commands);
    }

    public function addCommand(Command $command): void
    {
        foreach ($command->getNames() as &$name) {
            $this->commands[$name] = $command;
        }
    }

    public function addCommands(Command ...$commands): void
    {
        foreach ($commands as $command) {
            $this->addCommand($command);
        }
    }

    /**
     * @return array
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * @param string $name
     * @return Command|null
     */
    public function getCommand(string $name): ?Command
    {
        if (!key_exists($name, $this->commands)) {
            return null;
        }
        return $this->commands[$name];
    }

    public function executeCommand(string $name, int $user_id, array $args = array()): void
    {
        $this->getCommand($name)->execute($user_id, $args);
    }
}
