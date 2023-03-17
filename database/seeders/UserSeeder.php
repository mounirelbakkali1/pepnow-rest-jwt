<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    private $rolesNames = ['user', 'admin','seller'];
    public function run(): void
    {
        User::factory()->count(5)->create()->each(function ($user) {
            $user->assignRole($this->rolesNames[rand(0,2)]);
        });
    }
}
