<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => 'ASH',
            'email' => 'ash@app.com',
            'password' => Hash::make('ash123456'),
        ]);

        factory(\App\User::class, 2)->create();
    }
}
