<?php

namespace Bot\Commands\Deadline;

use Bot\Commands\Command;

class GetDeadlines implements Command
{
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
        // TODO: Implement execute() method.
    }
}