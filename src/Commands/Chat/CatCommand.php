<?php

namespace Bot\Commands\Chat;

use Bot\Commands\Command;
use CataasApiPhp\CataasApiPhp;
use CURLFile;
use VK\Client\VKApiClient;

class CatCommand implements Command
{
    private VKApiClient $vkApi;
    private CataasApiPhp $cataas;

    public function __construct(VKApiClient $vkApi)
    {
        $this->vkApi = $vkApi;
        $this->cataas = CataasApiPhp::factory();
    }

    public function getName(): string
    {
        return "cat";
    }

    public function getDescription(): string
    {
        return "Sends you random cat image with your text";
    }

    public function execute(int $user_id, array $args): void
    {
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

        $curl = curl_init($uploadLink["upload_url"]);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, array("file" => new CURLfile($filename)));
        $json = curl_exec($curl);
        curl_close($curl);
        $upload_response = json_decode($json, true);

        $save_response = $this->vkApi->photos()->saveMessagesPhoto(BOT_TOKEN, [
            "photo" => $upload_response["photo"],
            "server" => $upload_response["server"],
            "hash" => $upload_response["hash"],
        ]);
        return array_pop($save_response);
    }
}