<?php

namespace Bot\Repositories;

use Bot\Repositories\Entities\Deadline;
use SQLite3;

class DeadlinesRepository
{
    private SQLite3 $connection;

    public function __construct()
    {
        $this->connection = new SQLite3(DEADLINES_DB_HOST);
    }

    public function getById(int $id): Deadline
    {
        $stmt = $this->connection->prepare("SELECT * FROM deadlines WHERE id = :id");
        $stmt->bindParam(":id", $id, SQLITE3_INTEGER);
        $result = $stmt->execute();
        $row = $result->fetchArray();
        return new Deadline($row["id"], $row["user_id"], $row["date"], $row["name"]);
    }

    public function add(Deadline $deadline): Deadline
    {
        $user_id = $deadline->getUserId();
        $name = $deadline->getName();
        $date = $deadline->getDate();
        $stmt = $this->connection->prepare("INSERT INTO deadlines (user_id, name, date) VALUES (:user_id, :name, :date)");
        $stmt->bindParam(":user_id", $user_id, SQLITE3_INTEGER);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":date", $date);
        $result = $stmt->execute();
        return new Deadline($this->connection->lastInsertRowID(), $user_id, $date, $name);
    }

    public function removeById(int $id): void
    {
        $stmt = $this->connection->prepare("DELETE FROM deadlines WHERE id = :id");
        $stmt->bindParam(":id", $id, SQLITE3_INTEGER);
        $result = $stmt->execute();
    }

    public function getByUserId(int $user_id): array
    {
        $stmt = $this->connection->prepare("SELECT * FROM deadlines WHERE user_id = :user_id");
        $stmt->bindParam(":user_id", $user_id, SQLITE3_INTEGER);
        $result = $stmt->execute();
        $arr = [];
        while ($row = $result->fetchArray()) {
            $arr[] = new Deadline($row["id"], $row["user_id"], $row["date"], $row["name"]);
        }
        return $arr;
    }
}
