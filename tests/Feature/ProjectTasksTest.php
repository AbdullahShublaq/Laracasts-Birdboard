<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guests_cannot_add_tasks_to_projects()
    {
        $project = factory('App\Project')->create();

        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }

    /**
     * @test
     */
    public function only_the_owner_of_a_project_can_add_tasks()
    {
        $this->signIn();

        $project = factory('App\Project')->create();

        $this->post($project->path() . '/tasks', ['body' => 'Test task'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }

    /**
     * @test
     */
    public function only_the_owner_of_a_project_can_update_tasks()
    {
        $this->signIn();

        $project = ProjectFactory::withTasks(1)->create();
//        $project = factory('App\Project')->create();
//        $task = $project->addTask('test task');

        $this->patch($project->tasks->first()->path(), ['body' => 'changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
    }

    /**
     * @test
     */
    public function a_project_can_have_tasks()
    {
        $project = ProjectFactory::ownedBy($this->signIn())
            ->withTasks(1)
            ->create();

//        $this->signIn();
//        $project = auth()->user()->projects()->create(
//            factory(Project::class)->raw()
//        );

        $this->post($project->path() . '/tasks', ['body' => 'Test task']);

        $this->get($project->path())
            ->assertSee('Test task');
    }

    /**
     * @test
     */
    public function a_task_can_be_updated()
    {
        $project = ProjectFactory::ownedBy($this->signIn())
            ->withTasks(1)
            ->create();
//        $project = auth()->user()->projects()->create(
//            factory(Project::class)->raw()
//        );
//        $task = $project->addTask('test task');

        $this->patch($project->tasks->first()->path(), [
            'body' => 'changed',
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
       ]);
    }

    /**
     * @test
     */
    public function a_task_can_be_completed()
    {
        $project = ProjectFactory::ownedBy($this->signIn())
            ->withTasks(1)
            ->create();

        $this->patch($project->tasks->first()->path(), [
            'body' => 'changed',
            'completed' => TRUE
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => TRUE
        ]);
    }

    /**
     * @test
     */
    public function a_task_can_be_marked_as_incomplete()
    {
        $project = ProjectFactory::ownedBy($this->signIn())
            ->withTasks(1)
            ->create();

        $this->patch($project->tasks->first()->path(), [
            'body' => 'changed',
            'completed' => TRUE
        ]);
        $this->patch($project->tasks->first()->path(), [
            'body' => 'changed',
            'completed' => FALSE
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => FALSE
        ]);
    }

    /**
     * @test
     */
    public function a_task_requires_a_body()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->create();
//        $this->signIn();
//        $project = auth()->user()->projects()->create(
//            factory(Project::class)->raw()
//        );

        $attributes = factory('App\Task')->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }

}
