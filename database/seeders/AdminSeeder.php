<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => "rober",
            'email' => 'rober@gmail.com',
            'role_id' => 1,
            'password' => Hash::make('123456789'),
            'fcm_token' => ' '
        ]);
    }
}
