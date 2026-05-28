<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Gọi Factory tạo ra 50 tasks
        Task::factory(50)->create();
    }
}