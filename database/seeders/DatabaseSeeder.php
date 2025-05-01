<?php

namespace Database\Seeders;

use App\Models\User;
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
        // User::factory(10)->create();

        User::create([
            'nama'      => 'Test User',
            'email'     => 'test@example.com',
            'jabatan'   => 'Admin',
            'password'  => Hash::make('123123123'),
            'is_tugas'  => false,
        ]);
    }
}
