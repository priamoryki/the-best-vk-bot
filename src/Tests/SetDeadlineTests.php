<?php

namespace Bot\Tests;

use Bot\Commands\CommandException;
use Bot\Commands\Deadline\SetDeadline;
use Bot\Utils\VKAdvancedAPI;
use PHPUnit\Framework\TestCase;

class SetDeadlineTests extends TestCase
{
    public function testWithZeroArgs()
    {
        $command = new SetDeadline(new VKAdvancedAPI("5.130"));
        try {
            $command->execute(0, []);
        } catch (CommandException $e) {
            $this->assertStringContainsString("Not enough arguments!", $e->getMessage());
            return;
        }
        $this->fail();
    }

    public function testWithInvalidArgs()
    {
        $command = new SetDeadline(new VKAdvancedAPI("5.130"));
        try {
            $command->execute(0, ["12:00", "20:12:2020", "TODO"]);
        } catch (CommandException $e) {
            $this->assertStringContainsString("Invalid date param", $e->getMessage());
            return;
        }
        $this->fail();
    }

    public function testWithoutTimezone()
    {
        $command = new SetDeadline(new VKAdvancedAPI("5.130"));
        try {
            $command->execute(0, ["12:00", "20-12-2020", "TODO"]);
        } catch (CommandException $e) {
            $this->assertStringContainsString("Your timezone isn't set! Use set_timezone command!", $e->getMessage());
            return;
        }
        $this->fail();
    }
}