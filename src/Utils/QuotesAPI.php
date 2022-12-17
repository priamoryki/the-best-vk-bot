<?php

namespace Bot\Utils;

class QuotesAPI
{
    private const BASE_URL = "https://zenquotes.io/api/";

    public static function getRandomQuote(): string
    {
        $content = file_get_contents(self::BASE_URL . "random");
        $quote = json_decode($content);
        return $quote[0]->q;
    }
}
