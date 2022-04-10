<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Facades\Tests\Setup\ProjectFactory;
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
        $project = ProjectFactory::withTasks(1)->create();
        $this->patch($project->tasks[0]->path(), ['body' => 'changed', 'completed' => 1])->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['body' => 'changed', 'completed' => 1]);
    }

    /**
     * @test
     */
    public function a_project_can_have_tasks()
    {

        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', ['body' => 'Test Task'])
            ->assertRedirect($project->path());

        $this->get($project->path())
            ->assertSee('Test Task');
    }


    /**
     * @test
     */
    public function a_test_can_be_updated()
    {
        $project = ProjectFactory::ownedBy($this->signIn())
            ->withTasks(1)
            ->create();
        /*  U can remove the owned by above and replace it with
          $this->actingAs($project->owner)*/
        $this->patch($project->tasks->first()->path(), [
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

        $project = ProjectFactory::create();
        $task = Task::factory()
            ->raw(['body' => '', 'project_id' => $project->id]);

        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', $task)
            ->assertSessionHasErrors('body');
    }
}
