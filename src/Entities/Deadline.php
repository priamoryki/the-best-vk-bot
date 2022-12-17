<?php

namespace Bot\Entities;

class Deadline
{
    private int $id;
    private int $user_id;
    private int $timestamp;
    private string $name;

    public function __construct(int $id, int $user_id, int $timestamp, string $name)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->timestamp = $timestamp;
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
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
