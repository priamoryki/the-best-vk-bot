<?php

namespace Bot\Repositories;

use SQLite3;

class TimezonesRepository
{
    private SQLite3 $connection;

    public function __construct()
    {
        $this->connection = new SQLite3(MAIN_DB_HOST);
    }

    public function add(int $user_id, int $timezone): void
    {
        $stmt = $this->connection->prepare("INSERT INTO timezones (user_id, timezone) VALUES (:user_id, :timezone)");
        $stmt->bindParam(":user_id", $user_id, SQLITE3_INTEGER);
        $stmt->bindParam(":timezone", $timezone, SQLITE3_INTEGER);
        $result = $stmt->execute();
    }

    public function getByUserId(int $user_id): ?int
    {
        $stmt = $this->connection->prepare("SELECT * FROM timezones WHERE user_id = :user_id");
        $stmt->bindParam(":user_id", $user_id, SQLITE3_INTEGER);
        $result = $stmt->execute();
        $row = $result->fetchArray();
        if ($row == null) {
            return null;
        }
        return $row["timezone"];
    }
}
