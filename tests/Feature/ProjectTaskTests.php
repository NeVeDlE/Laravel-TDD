<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTaskTests extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function only_the_owner_of_a_project_may_add_tasks()
    {
        $this->signIn();
        $project = Project::factory()->create();
        $this->post($project->path() . '/tasks', ['body' => 'Test Task'])->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['body' => 'Test Task']);
    }

    /**
     * @test
     */
    public function only_the_owner_of_a_project_may_update_tasks()
    {
        $this->signIn();
        $project = Project::factory()->create();
        $task = $project->addTask('test task');
        $this->patch($task->path(), ['body' => 'changed', 'completed' => 1])->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['body' => 'changed', 'completed' => 1]);
    }

    /**
     * @test
     */
    public function a_project_can_have_tasks()
    {

        $this->signIn();
        $project = Project::factory()->create(['owner_id' => auth()->id()]);
        $this->post($project->path() . '/tasks', ['body' => 'Test Task'])->assertRedirect($project->path());
        $this->get($project->path())->assertSee('Test Task');
    }


    /**
     * @test
     */
    public function a_test_can_be_updated()
    {

        $this->withoutExceptionHandling();
        $this->signIn();
        $project = Project::factory()->create(['owner_id' => auth()->id()]);
        $task = $project->addTask('test task');
        $this->patch($project->path() . '/tasks/' . $task->id, [
            'body' => 'changed',
            'completed' => true,
        ]);
        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true,
        ]);
    }

    /**
     * @test
     */
    public function a_task_require_a_body()
    {

        $this->signIn();
        $project = Project::factory()->create(['owner_id' => auth()->id()]);
        $task = Task::factory()->raw(['body' => '', 'project_id' => $project->id]);
        $this->post($project->path() . '/tasks', $task)->assertSessionHasErrors('body');
    }
}
