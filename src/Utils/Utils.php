<?php

namespace Bot\Utils;

class Utils
{
    private static string $crontab = "crontab -u www-data";
    private static string $path = "/home/ubuntu/the-best-vk-bot/src/Commands/Deadline/DeadlineNotification.php";

    public static function addCrontabTask(string $command)
    {
        $crontab = self::$crontab;
        shell_exec("($crontab -l && echo \"$command\") | $crontab -");
    }

    public static function removeCrontabTask(string $command)
    {
        $crontab = self::$crontab;
        shell_exec("$crontab -l | grep -v \"$command\" | $crontab -");
    }

    public static function getDeadlineNotificationCommand(string $date, int $id): string
    {
        $path = self::$path;
        return "$date php $path $id >> /var/tmp/text.txt 2>&1";
    }
}
