<?php

namespace Tests\Feature;

use App\Models\Project;
use Facades\Tests\Setup\ProjectFactory;
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
        $this->get($project->path() . '/edit')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');
    }

    /**
     * @test
     */
    public function a_user_can_create_a_project()
    {

        $this->signIn();
        $this->get('/projects/create')->assertViewIs('projects.create');
        $atr = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General notes here.'
        ];
        $response = $this->post('/projects', $atr);
        $project = Project::where($atr)->first();
        $response->assertRedirect($project->path());
        $this->assertDatabaseHas('projects', $atr);
        $this->get($project->path())
            ->assertSee($atr['title'])
            ->assertSee($atr['description'])
            ->assertSee($atr['notes']);
    }

    /**
     * @test
     */
    public function un_authorized_users_cannot_delete_a_project()
    {

        $project = ProjectFactory::create();
        $this->actingAs($project->owner)
            ->delete($project->path())
            ->assertRedirect('/projects');
        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    /**
     * @test
     */
    public function a_guest_cannot_delete_a_project()
    {
        $project = ProjectFactory::create();
        $this->delete($project->path())
            ->assertRedirect('/login');
        $this->signIn();
        $this->delete($project->path())
            ->assertStatus(403);
    }

    /**
     * @test
     */
    public function a_user_can_update_a_project()
    {

        $project = ProjectFactory::create();
        $this->actingAs($project->owner)
            ->patch($project->path(), $atr = ['notes' => 'Notes Test', 'title' => 'changed', 'description' => 'changed'])
            ->assertRedirect($project->path());
        $this->assertDatabaseHas('projects', $atr);
        $this->get($project->path() . '/edit')->assertOk();
    }

    /**
     * @test
     */
    public function a_user_can_update_a_projects_general_notes()
    {
        $project = ProjectFactory::create();
        $this->actingAs($project->owner)
            ->patch($project->path(), $atr = ['notes' => 'Notes Test']);

        $this->assertDatabaseHas('projects', $atr);

    }

    /**
     * @test
     */
    public function a_user_can_view_their_project()
    {


        $project = ProjectFactory::create();
        $this->actingAs($project->owner)
            ->get($project->path())
            ->assertSee($project->title)
            ->assertSee(Str::limit($project->description, 100));
    }

    /**
     * @test
     */
    public function an_authenticated_user_cannot_view_the_project_of_others()
    {
        $project = ProjectFactory::create();
        $this->actingAs($this->signIn())
            ->get($project->path())
            ->assertStatus(403);
    }

    /**
     * @test
     */
    public function an_authenticated_user_cannot_update_the_project_of_others()
    {
        $project = ProjectFactory::create();
        $this->actingAs($this->signIn())
            ->patch($project->path(), [])
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
