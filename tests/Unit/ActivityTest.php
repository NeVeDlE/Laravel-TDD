<?php

namespace Tests\Unit;

use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_has_a_user()
    {
        $this->withoutExceptionHandling();
        $user = $this->signIn();
        $project = ProjectFactory::ownedBy($user)->create();
        $this->assertEquals($user->id, $project->activity->first()->user->id);
    }
}
