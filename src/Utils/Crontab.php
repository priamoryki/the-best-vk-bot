<?php

namespace Bot\Utils;

class Crontab
{
    private static string $crontab = "crontab -u www-data";
    private static string $path = "/home/ubuntu/the-best-vk-bot/src/Commands/Deadline/DeadlineNotification.php";

    public static function addTask(string $command)
    {
        $crontab = self::$crontab;
        shell_exec("($crontab -l && echo \"$command\") | $crontab -");
    }

    public static function removeTask(string $command)
    {
        $crontab = self::$crontab;
        shell_exec("$crontab -l | grep -v \"$command\" | $crontab -");
    }

    public static function getDeadlineNotificationCommand(int $timestamp, int $id): string
    {
        // TODO: check year in crontab
        $path = self::$path;
        $crontab_date = date('i H d m N', $timestamp);
        return "$crontab_date php $path $id >> /var/tmp/text.txt 2>&1";
    }
}
