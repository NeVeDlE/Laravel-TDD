<?php

namespace Tests\Setup;

use App\Models\Activity;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class ProjectFactory
{
    protected $tasksCount = 0;
    protected $activityCount = 0;
    protected $user;

    public function withTasks($count): ProjectFactory
    {
        $this->tasksCount = $count;
        return $this;
    }

    public function ownedBy($user): ProjectFactory
    {
        $this->user = $user;
        return $this;
    }

    public function withActivity($count): ProjectFactory
    {
        $this->activityCount = $count;
        return $this;
    }

    public function create()
    {
        $project = Project::factory()->create([
            'owner_id' => $this->user->id ?? User::factory()->create()->id
        ]);
        Task::factory($this->tasksCount)->create([
            'project_id' => $project->id
        ]);
        Activity::factory($this->activityCount)->create([
            'project_id' => $project->id,
            'description' => 'Created',
        ]);
        return $project;
    }

}
