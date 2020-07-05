<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        // Create an admin user
        $user = User::create([
            'name' => 'Admin',
            'email' => 'test@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('1234567890'), // password
            'remember_token' => Str::random(10),
        ]);

        $user->save();
    }
}
