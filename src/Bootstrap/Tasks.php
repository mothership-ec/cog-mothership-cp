<?php

namespace Message\Mothership\ControlPanel\Bootstrap;

use Message\Mothership\ControlPanel;
use Message\Cog\Bootstrap\TasksInterface;

class Tasks implements TasksInterface
{
    public function registerTasks($tasks)
    {
        $tasks->add(new ControlPanel\Statistic\Task\Rebuild('statistic:rebuild'), 'Clean and rebuild all statistics');
    }
}