<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Kirill',
            'email' => 'kushnarev.k25@mail.com',
            'password' => Hash::make('123456'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        // $this->call(UsersTableSeeder::class);
    }
}
