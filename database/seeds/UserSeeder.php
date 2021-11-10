<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            "name" => "admin",
            "email" => "admin@zuso.tw",
            "password" => Hash::make("bj6nji"),
        ]);
    }
}
