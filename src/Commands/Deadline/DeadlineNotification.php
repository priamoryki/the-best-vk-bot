<?php

namespace Bot\Commands\Deadline;

require_once "/home/ubuntu/the-best-vk-bot/vendor/autoload.php";
require_once "/home/ubuntu/the-best-vk-bot/src/config.php";

use Bot\Commands\Chat\CatCommand;
use Bot\Repositories\DeadlinesRepository;
use Bot\Utils\QuotesAPI;
use Bot\Utils\Utils;
use Bot\Utils\VKAdvancedAPI;

$vkApi = new VKAdvancedAPI("5.130");
$db = new DeadlinesRepository();

$id = $argv[1];
$deadline = $db->getById($id);

$name = $deadline->getName();
$vkApi->messages()->send(BOT_TOKEN, [
    "user_id" => $deadline->getUserId(),
    "random_id" => random_int(0, PHP_INT_MAX),
    "message" => "Deadline \"$name\" is coming! It's time for hard work!",
]);

$catCommand = new CatCommand($vkApi);
$quote = QuotesAPI::getRandomQuote();
$catCommand->execute($deadline->getUserId(), preg_split("/\s+/", $quote));

$db->removeById($deadline->getId());
$command = Utils::getDeadlineNotificationCommand($deadline->getDate(), $deadline->getId());
Utils::removeCrontabTask($command);
