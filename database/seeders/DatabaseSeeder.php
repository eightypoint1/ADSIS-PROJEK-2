<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'     => 'Andi Mahasiswa',
            'nim'      => '2251504001',
            'email'    => 'andi@student.ac.id',
            'major'    => 'Teknik Informatika',
            'angkatan' => '2022',
            'password' => Hash::make('password123'),
        ]);
    }
}
