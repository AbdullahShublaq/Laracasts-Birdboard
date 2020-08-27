<?php

namespace Tests\Feature;

use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function non_owners_cannot_invite_users()
    {
        $user = $this->signIn();
        $project = ProjectFactory::create();

        $this->post($project->path() . '/invitations')
            ->assertStatus(403);

        $project->invite($user);

        $this->post($project->path() . '/invitations')
            ->assertStatus(403);
    }

    /**
     * @test
     */
    public function a_project_owner_can_invite_a_user()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->create();
        $userToInvite = factory(User::class)->create();

        $this->post($project->path() . '/invitations', [
            'email' => $userToInvite->email,
        ])->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($userToInvite));
    }

    /**
     * @test
     */
    public function the_email_address_must_be_assocciated_with_a_valid_birdboard_account()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->create();

        $this->post($project->path() . '/invitations', [
            'email' => 'not_user@app.com',
        ])->assertSessionHasErrors(['email' => 'The user you want to inviting must have a birdboard account.']);
    }

    /**
     * @test
     */
    public function invited_users_can_update_project_details()
    {
        $project = ProjectFactory::create();

        $project->invite($newUser = factory(User::class)->create());

        $this->signIn($newUser);
        $this->post(action('ProjectTasksController@store', $project), $task = ['body' => 'Foo Task']);

        $this->assertDatabaseHas('tasks', $task);
    }
}
