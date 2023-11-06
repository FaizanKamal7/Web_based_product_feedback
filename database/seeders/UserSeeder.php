<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@ikonic.com',
            'email_verified_at' => null,
            'password' => Hash::make('password'),
            'is_admin' => '1',
            'remember_token' => null,
            'created_at' => '2023-11-06 05:01:42',
            'updated_at' => '2023-11-06 05:01:42',
        ]);

        User::create([
            'name' => 'Test User',
            'email' => 'test@ikonic.com',
            'email_verified_at' => null,
            'password' => Hash::make('password'),
            'is_admin' => '0',
            'remember_token' => null,
            'created_at' => '2023-11-06 05:01:42',
            'updated_at' => '2023-11-06 05:01:42',
        ]);
    }
}
