<?php

namespace Database\Seeders;

use App\Models\EmployeeTask;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmployeeTask::create([
            'manager_task_id' => 1,
            'created_by' => 2,
            'assigned_to' => 3,
            'title' => 'task from manager',
            'description' => 'lorem ipsum dolor sit amet',
            'attachment' => json_encode(['img1.jpg', 'img2.jpg', 'img3.jpg']),
            'due_date' => '2024-11-18',
            'status' => 'not viewed'
        ]);
    }
}
