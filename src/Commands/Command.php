<?php

namespace Bot\Commands;

interface Command
{
    public function getNames(): array;

    public function getDescription(): string;

    /**
     * @throws CommandException
     */
    public function execute(int $user_id, array $args): void;
}
