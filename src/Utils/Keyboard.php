<?php

namespace Bot\Utils;

class Keyboard
{
    private static array $keyboard = [
        "one_time" => false,
        "buttons" => [
            [
                [
                    "action" => [
                        "type" => "text",
                        "label" => "help",
                    ],
                    "color" => "primary",
                ],
            ],
            [
                [
                    "action" => [
                        "type" => "text",
                        "label" => "hello",
                    ],
                    "color" => "primary",
                ],
            ],
            [
                [
                    "action" => [
                        "type" => "text",
                        "label" => "get_deadlines",
                    ],
                    "color" => "primary",
                ],
            ],
        ]
    ];

    public static function getButtons(): string
    {
        return json_encode(self::$keyboard, JSON_UNESCAPED_UNICODE);
    }
}
