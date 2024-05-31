<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        for ($i = 0; $i < 5; $i++) {
            \App\Models\User::create([
                'username' => 'firstname' . $i . 'lastname' . $i,
                'firstname' => 'firstname' . $i,
                'lastname' => 'lastname' . $i,
                'email' => 'demo' . $i . '@worldskills.org',
                "password" => Hash::make('demopass' . $i)
            ]);
        }
        // \App\Models\User::create([
        //     'username' => 'firstname lastname',
        //     'firstname' => 'firstname',
        //     'lastname' => 'lastname',
        //     'email' => 'user@test.com',
        //     "password" => Hash::make('password')
        // ]);
    }
}
