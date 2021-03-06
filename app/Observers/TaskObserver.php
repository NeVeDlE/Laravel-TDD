<?php

namespace App\Observers;

use App\Models\Task;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     *
     * @param \App\Models\Task $task
     * @return void
     */
    public function created(Task $task)
    {
        $task->recordActivity('created_task');
    }


    /**
     * Handle the Task "updated" event.
     *
     * @param \App\Models\Task $task
     * @return void
     */
    public function updated(Task $task)
    {
        if ($task->completed != true) $task->recordActivity('incompleted_task');
        else $task->recordActivity('completed_task');
    }

    /**
     * Handle the Task "deleted" event.
     *
     * @param \App\Models\Task $task
     * @return void
     */
    public function deleted(Task $task)
    {
        $task->recordActivity('deleted_task');
    }




}
