<?php
declare(strict_types=1);

namespace Bot\Commands\Deadline;

require_once "/home/ubuntu/the-best-vk-bot/vendor/autoload.php";
require_once "/home/ubuntu/the-best-vk-bot/src/config.php";

use Bot\Commands\Chat\CatCommand;
use Bot\Repositories\DeadlinesRepository;
use Bot\Utils\Crontab;
use Bot\Utils\Keyboard;
use Bot\Utils\QuotesAPI;
use Bot\Utils\VKAdvancedAPI;

$vkApi = new VKAdvancedAPI("5.130");
$db = new DeadlinesRepository();

$id = intval($argv[1]);
$deadline = $db->getById($id);

if (time() < $deadline->getTimestamp()) {
    return;
}

$name = $deadline->getName();
$vkApi->messages()->send(BOT_TOKEN, [
    "user_id" => $deadline->getUserId(),
    "random_id" => random_int(0, PHP_INT_MAX),
    "message" => "Deadline \"$name\" is coming! It's time for hard work!",
    "keyboard" => Keyboard::getButtons(),
]);

$catCommand = new CatCommand($vkApi);
$quote = wordwrap(QuotesAPI::getRandomQuote(), 35, "%0A");
$catCommand->execute($deadline->getUserId(), preg_split("/\s+/", $quote));

$db->removeById($deadline->getId());
Crontab::removeTask($deadline->getCrontabCommand());
