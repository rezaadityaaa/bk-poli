<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin123'),
                'role' => 'dokter',
                'alamat' => 'Jl. Kesehatan No. 1',
                'no_ktp' => '1234567890123456',
                'no_hp' => '081234567890',
                'no_rm' => null,
                'poli' => 'Umum',
            ],
            [
                'name' => 'user',
                'email' => 'user@gmail.com',
                'password' => bcrypt('user123'),
                'role' => 'pasien',
                'alamat' => 'Jl. Kesehatan No. 2',
                'no_ktp' => '6543210987654321',
                'no_hp' => '089876543210',
                'no_rm' => 'RM001',
                'poli' => null,
            ],
        ];
        
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
