<?php

namespace Bot\Utils;

use VK\Client\VKApiClient;

class VKAdvancedAPI extends VKApiClient
{
    public function __construct(string $api_version = self::API_VERSION, ?string $language = null)
    {
        parent::__construct($api_version, $language);
    }
}
