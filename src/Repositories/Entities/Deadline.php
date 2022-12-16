<?php

namespace Bot\Repositories\Entities;

class Deadline
{
    private int $id;
    private int $user_id;
    private string $name;
    private string $date;

    public function __construct(int $id, int $user_id, string $date, string $name)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->date = $date;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }
}
