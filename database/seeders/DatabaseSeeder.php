<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Task;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo User Admin mẫu trước với id = 1 và role = admin
        User::factory()->create([
            'id' => 1,
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        // Tạo thêm một số User thường
        User::factory(5)->create([
            'role' => 'user',
        ]);

        // Gọi Factory tạo ra 50 tasks
        Task::factory(50)->create();
    }
}