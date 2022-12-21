<?php

namespace Bot\Tests;

use Bot\Commands\CommandException;
use Bot\Commands\Config\SetTimezone;
use Bot\Utils\VKAdvancedAPI;
use PHPUnit\Framework\TestCase;

class SetTimezoneTests extends TestCase
{
    public function testWithZeroArgs(): void
    {
        $command = new SetTimezone(new VKAdvancedAPI("5.130"));
        try {
            $command->execute(0, []);
        } catch (CommandException $e) {
            $this->assertStringContainsString("Not enough arguments!", $e->getMessage());
            return;
        }
        $this->fail();
    }

    public function testWithInvalidArgs(): void
    {
        $command = new SetTimezone(new VKAdvancedAPI("5.130"));
        try {
            $command->execute(0, ["a"]);
        } catch (CommandException $e) {
            $this->assertStringContainsString("Timezone argument is not int!", $e->getMessage());
            return;
        }
        $this->fail();
    }

    public function testWithNotInRangeArgs(): void
    {
        $command = new SetTimezone(new VKAdvancedAPI("5.130"));
        try {
            $command->execute(0, ["-20"]);
        } catch (CommandException $e) {
            $this->assertStringContainsString("Timezone is not in range [-12, 12]!", $e->getMessage());
            return;
        }
        $this->fail();
    }
}
