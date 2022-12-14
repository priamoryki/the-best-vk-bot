<?php

namespace Bot\Utils;

use CURLFile;
use VK\Client\VKApiClient;

// For some reason VKApiClient has all fields private, so I can't simply change $photos instance...
class VKAdvancedAPI extends VKApiClient
{
    public function __construct(string $api_version = self::API_VERSION, ?string $language = null)
    {
        parent::__construct($api_version, $language);
    }

    /**
     * @param array $uploadLink
     * @param string $filename
     * @return array with keys: photo, server, hash
     */
    public function uploadPhoto(array $uploadLink, string $filename): array
    {
        $curl = curl_init($uploadLink["upload_url"]);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, array("file" => new CURLfile($filename)));
        $json = curl_exec($curl);
        curl_close($curl);
        return json_decode($json, true);
    }
}
