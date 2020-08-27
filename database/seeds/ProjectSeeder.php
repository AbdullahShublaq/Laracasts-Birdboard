<?php

use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = \App\User::where('name', 'ASH')->first();

        factory(\App\Project::class, 5)->create(['owner_id' => $user->id]);
    }
}
