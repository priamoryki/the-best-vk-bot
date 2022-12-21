<?php

namespace Bot\Utils;

class Crontab
{
    private static string $crontab = "crontab -u www-data";

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
}
