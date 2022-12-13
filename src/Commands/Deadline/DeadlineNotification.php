<?php

namespace Bot\Commands\Deadline;

require_once "/home/ubuntu/the-best-vk-bot/vendor/autoload.php";
require_once "/home/ubuntu/the-best-vk-bot/src/config.php";

use Bot\Commands\Utils\Utils;
use Bot\Commands\Utils\VKAdvancedAPI;

$vkApi = new VKAdvancedAPI("5.130");

$id = $argv[1];
$deadline = new Deadline($id, $id, "0-59 \* \* \* \*", "noname");

$command = Utils::getDeadlineNotificationCommand($deadline->getDate(), $deadline->getId());
Utils::removeCrontabTask($command);

$name = $deadline->getName();
$vkApi->messages()->send(BOT_TOKEN, [
    "user_id" => $deadline->getUserId(),
    "random_id" => random_int(0, PHP_INT_MAX),
    "message" => "Deadline \"$name\" is coming!",
]);
