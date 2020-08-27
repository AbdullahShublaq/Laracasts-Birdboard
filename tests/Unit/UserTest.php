<?php

namespace Tests\Unit;

use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_has_projects()
    {
        $user = factory('App\User')->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    /** @test */
    public function a_user_has_accessible_projects()
    {
        $user = $this->signIn();
        ProjectFactory::ownedBy($user)->create();

        $this->assertCount(1, $user->accessibleProjects());

        $user2 = factory(User::class)->create();
        ProjectFactory::ownedBy($user2)->create()->invite($user);

        $this->assertCount(2, $user->accessibleProjects());
        $this->assertCount(1, $user2->accessibleProjects());
    }
}
