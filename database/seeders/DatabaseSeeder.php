<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'DOCUARCH Administrator', 'email' => 'admin@docuarch.test', 'role' => 'admin', 'office' => 'System Administration'],
            ['name' => 'Office Personnel', 'email' => 'personnel@docuarch.test', 'role' => 'personnel', 'office' => 'Records Office'],
            ['name' => 'Requesting User', 'email' => 'requester@docuarch.test', 'role' => 'requester', 'office' => null],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [...$user, 'password' => Hash::make('password')]
            );
        }
    }
}
