<?php

namespace Bot\Commands\Deadline;

class Deadline
{
    private int $user_id;
    private int $timestamp;
    private string $message_text;

    public function __construct(int $user_id, int $timestamp, string $message_text)
    {
        $this->user_id = $user_id;
        $this->timestamp = $timestamp;
        $this->message_text = $message_text;
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
    public function getMessageText(): string
    {
        return $this->message_text;
    }
}
