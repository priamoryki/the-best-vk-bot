<?php

namespace Bot\Commands\Deadline;

use Bot\Commands\VKCommand;
use Bot\Repositories\DeadlinesRepository;
use Bot\Utils\VKAdvancedAPI;

abstract class DeadlineCommand extends VKCommand
{
    protected DeadlinesRepository $deadlinesRepository;

    public function __construct(VKAdvancedAPI $vkApi)
    {
        parent::__construct($vkApi);
        $this->deadlinesRepository = new DeadlinesRepository();
    }
}
