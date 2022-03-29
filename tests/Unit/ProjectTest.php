<?php

namespace Tests\Unit;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class ProjectTest extends TestCase
{
    use withFaker,RefreshDatabase;

    /**
     * @test
     */
    public function it_has_a_path()
    {
        $project = Project::factory()->make();
        $this->assertEquals('/projects/' . $project->id, $project->path());
    }
}
