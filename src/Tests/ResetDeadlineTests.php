<?php

namespace Bot\Tests;

use Bot\Commands\CommandException;
use Bot\Commands\Deadline\ResetDeadline;
use Bot\Utils\VKAdvancedAPI;
use PHPUnit\Framework\TestCase;

class ResetDeadlineTests extends TestCase
{
    public function testWithZeroArgs()
    {
        $command = new ResetDeadline(new VKAdvancedAPI("5.130"));
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
        $command = new ResetDeadline(new VKAdvancedAPI("5.130"));
        try {
            $command->execute(0, ["a"]);
        } catch (CommandException $e) {
            $this->assertStringContainsString("Id argument is not int!", $e->getMessage());
            return;
        }
        $this->fail();
    }
}