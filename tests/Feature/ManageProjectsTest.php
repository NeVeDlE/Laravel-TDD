<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;


    /**
     * @test
     */
    public function guests_cannot_manage_projects()
    {
        $project = Project::factory()->create();
        $this->get($project->path())->assertRedirect('login');
        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');
    }

    /**
     * @test
     */
    public function a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $this->get('/projects/create')->assertViewIs('projects.create');
        $atr = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];
        $response = $this->post('/projects', $atr);
        $response->assertRedirect(Project::where($atr)->first()->path());
        $this->assertDatabaseHas('projects', $atr);
        $this->get('/projects')->assertSee($atr['title']);
    }

    /**
     * @test
     */
    public function a_user_can_view_their_project()
    {

        $this->signIn();

        $this->withoutExceptionHandling();
        $project = Project::factory()->create(['owner_id' => auth()->id()]);
        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee(Str::limit($project->description, 100));
    }

    /**
     * @test
     */
    public function an_authenticated_user_cannot_view_the_project_of_others()
    {
        $this->signIn();
        $project = Project::factory()->create(['owner_id' => User::factory()->create()->id]);
        $this->get($project->path())
            ->assertStatus(403);
    }


    /**
     * @test
     */
    public function a_project_requires_a_title()
    {
        $this->signIn();
        $atr = Project::factory()->raw(['title' => '']);
        $this->post('/projects', $atr)->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function a_project_requires_a_description()
    {
        $this->signIn();
        $atr = Project::factory()->raw(['description' => '']);
        $this->post('/projects', $atr)->assertSessionHasErrors('description');
    }


}
