<?php

namespace Database\Seeders;

use App\Models\ManagerTask;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ManagerTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ManagerTask::create([
            'created_by' => 1,
            'assigned_to' => 2,
            'title' => 'task from director',
            'description' => 'lorep ipsum dolor sit amet',
            'attachment' => json_encode(['img1.jpg', 'img2.jpg', 'img3.jpg']),
            'due_date' => '2024-11-18',
            'status' => 'not viewed'
        ]);
    }
}
