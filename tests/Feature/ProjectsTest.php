<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;


    /** @test
     */
    public function a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();
        $atr = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];
        $this->post('/projects', $atr)->assertRedirect('/projects');
        $this->assertDatabaseHas('projects', $atr);

        $this->get('/projects')->assertSee($atr['title']);
    }

    /**
     * @test
     */
    public function a_user_can_view_a_project()
    {
        $this->withoutExceptionHandling();
        $project = Project::factory()->create();
        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);

    }


    /**
     * @test
     */
    public function a_project_requires_a_title()
    {
        $atr = Project::factory()->raw(['title' => '']);
        $this->post('/projects', $atr)->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function a_project_requires_a_description()
    {
        $atr = Project::factory()->raw(['description' => '']);
        $this->post('/projects', $atr)->assertSessionHasErrors('description');
    }
}
