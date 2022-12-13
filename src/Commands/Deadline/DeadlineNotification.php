<?php

namespace Bot\Commands\Deadline;

require_once "/home/ubuntu/the-best-vk-bot/vendor/autoload.php";
require_once "/home/ubuntu/the-best-vk-bot/src/config.php";

use Bot\Commands\Utils\Utils;
use VK\Client\VKApiClient;

$vkApi = new VKApiClient("5.130");
$user_id = $argv[1];
$date = "0-59 \* \* \* \*";
$command = Utils::getDeadlineNotificationCommand($date, $user_id);
echo $command;
Utils::removeCrontabTask($command);
$vkApi->messages()->send(BOT_TOKEN, [
    "user_id" => $user_id,
    "random_id" => random_int(0, PHP_INT_MAX),
    "message" => "Here it is!",
]);
