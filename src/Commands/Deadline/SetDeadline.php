<?php

namespace Bot\Commands\Deadline;

class SetDeadline implements \Bot\Commands\Command
{

    public function getNames(): array
    {
        return ["set_deadline"];
    }

    public function getDescription(): string
    {
        return "Sets deadline";
    }

    public function execute(int $user_id, array $args): void
    {
        // TODO: Implement execute() method.
        $date = $args[0];
        // exec("* * * * * php /usr/local/bin/run.php &> /dev/null");
    }
}
