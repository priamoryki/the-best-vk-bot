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
        $min = date('i', $timestamp);
        $hour = date('H', $timestamp);
        $day = date('d', $timestamp);
        $month = date('m', $timestamp);
        $weekday = date('N', $timestamp) - 1;
        $path = self::$path;
        return "$min $hour $day $month $weekday php $path $id >> /var/tmp/text.txt 2>&1";
    }
}
