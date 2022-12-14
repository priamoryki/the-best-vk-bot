<?php

namespace Bot;

use Bot\Commands\Chat\CatCommand;
use Bot\Commands\Chat\HelloCommand;
use Bot\Commands\Chat\HelpCommand;
use Bot\Commands\CommandException;
use Bot\Commands\CommandsStorage;
use Bot\Commands\Config\SetTimezone;
use Bot\Commands\Deadline\GetDeadlines;
use Bot\Commands\Deadline\ResetDeadline;
use Bot\Commands\Deadline\SetDeadline;
use Bot\Utils\Keyboard;
use Bot\Utils\VKAdvancedAPI;
use VK\CallbackApi\Server\VKCallbackApiServerHandler;

class ServerHandler extends VKCallbackApiServerHandler
{
    private VKAdvancedAPI $vkApi;
    private CommandsStorage $storage;

    public function __construct()
    {
        $this->vkApi = new VKAdvancedAPI("5.130");
        $this->storage = new CommandsStorage(
            new HelloCommand($this->vkApi),
            new CatCommand($this->vkApi),
            new SetTimezone($this->vkApi),
            new SetDeadline($this->vkApi),
            new ResetDeadline($this->vkApi),
            new GetDeadlines($this->vkApi),
        );
        $this->storage->addCommands(
            new HelpCommand($this->vkApi, $this->storage),
        );
    }

    function confirmation(int $group_id, ?string $secret)
    {
        if ($secret == GROUP_SECRET && $group_id == GROUP_ID) {
            echo API_CONFIRMATION_TOKEN;
        }
    }

    public function messageNew(int $group_id, ?string $secret, array $object)
    {
        if ($secret != GROUP_SECRET) {
            echo "nok";
            return;
        }
        $message = $object["message"];
        $text = $message->text;
        $args = preg_split("/\s+/", $text);
        $user_id = $message->from_id;

        $command = $this->storage->getCommand(array_shift($args));
        $error = "";
        if ($command != null) {
            try {
                $command->execute($user_id, $args);
            } catch (CommandException $e) {
                $error = $e->getMessage();
            }
        } else {
            $error = "Command not found!";
        }
        if (!empty($error)) {
            $this->vkApi->messages()->send(BOT_TOKEN, [
                "user_id" => $user_id,
                "random_id" => random_int(0, PHP_INT_MAX),
                "message" => $error,
                "keyboard" => Keyboard::getButtons(),
            ]);
        }

        echo "ok";
    }
}
