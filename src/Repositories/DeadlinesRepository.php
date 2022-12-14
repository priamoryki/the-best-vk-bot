<?php

namespace Bot\Repositories;

use Bot\Commands\Deadline\Deadline;

// TODO
class DeadlinesRepository
{
    public function __construct()
    {
    }

    public function getAll(): array
    {
        return [];
    }

    public function getById(int $id): Deadline
    {
        return new Deadline($id, $id, "0-59 \* \* \* \*", "noname");
    }

    public function add(Deadline $deadline): void
    {
    }

    public function removeById(int $id): void
    {
    }

    public function getByUserId(int $user_id): array
    {
        return [new Deadline($user_id, $user_id, "0-59 \* \* \* \*", "noname")];
    }
}
