<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@crowdgym.com',
            'password' => Hash::make('password'),
            'type' => 'admin',
            'cpf' => '00000000000',
            'birth' => '2001-01-01',
            'gender' => 'outro',
            'gym_id' => null,
        ]);
    }
}