<?php

namespace Bot\Commands\Chat;

use Bot\Commands\Command;
use Bot\Commands\Utils\QuotesAPI;
use Bot\Commands\Utils\VKAdvancedAPI;
use CataasApiPhp\CataasApiPhp;

class CatCommand implements Command
{
    private VKAdvancedAPI $vkApi;
    private CataasApiPhp $cataas;

    public function __construct(VKAdvancedAPI $vkApi)
    {
        $this->vkApi = $vkApi;
        $this->cataas = CataasApiPhp::factory();
    }

    public function getNames(): array
    {
        return ["cat"];
    }

    public function getDescription(): string
    {
        return "Sends you random cat image with your text";
    }

    public function execute(int $user_id, array $args): void
    {
        // TODO
        $quote = QuotesAPI::getRandomQuote();
        $text = join(" ", $args);
        $filename = "/var/tmp/the-best-vk-bot.png";
        $this->cataas->says($text)->get($filename);

        $photo = $this->uploadPhoto($user_id, $filename);

        $this->vkApi->messages()->send(BOT_TOKEN, [
            "peer_id" => $user_id,
            "random_id" => random_int(0, PHP_INT_MAX),
            "attachment" => "photo" . $photo["owner_id"] . "_" . $photo["id"],
        ]);
    }

    private function uploadPhoto(int $user_id, string $filename)
    {
        $uploadLink = $this->vkApi->photos()->getMessagesUploadServer(BOT_TOKEN, [
            "peer_id" => $user_id,
        ]);
        $upload_response = $this->vkApi->uploadPhoto($uploadLink, $filename);
        $save_response = $this->vkApi->photos()->saveMessagesPhoto(BOT_TOKEN, [
            "photo" => $upload_response["photo"],
            "server" => $upload_response["server"],
            "hash" => $upload_response["hash"],
        ]);
        return array_pop($save_response);
    }
}
