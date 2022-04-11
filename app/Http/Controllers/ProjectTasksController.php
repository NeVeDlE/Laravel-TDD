<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Auth\Access\AuthorizationException;

class ProjectTasksController extends Controller
{
    //

    public function store(Project $project)
    {
        $this->authorize('update', $project);
        request()->validate(['body' => 'required']);
        $project->addTask(request('body'));
        return redirect($project->path());
    }

    /**
     * @throws AuthorizationException
     */
    public function update(Project $project, Task $task)
    {
        $this->authorize('update', $project);
        $task->update(request()->validate(['body' => 'sometimes|required']));

        request('completed') ? $task->complete() : $task->incomplete();

        return redirect($project->path());
    }
}
