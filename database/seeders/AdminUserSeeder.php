<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo tài khoản admin mặc định
        User::updateOrCreate(
            ['email' => 'admin@camerastore.com'],
            [
                'full_name' => 'Administrator',
                'email' => 'admin@camerastore.com',
                'password' => Hash::make('admin12345'),
                'phone' => '0123456789',
                'address' => 'Hà Nội, Việt Nam',
                'role' => 'admin',
            ]
        );
    }
}