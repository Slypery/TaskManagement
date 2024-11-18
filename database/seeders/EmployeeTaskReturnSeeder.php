<?php

namespace Database\Seeders;

use App\Models\EmployeeTaskReturn;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeTaskReturnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmployeeTaskReturn::create([
            'employee_task_id' => 1,
            'description' => 'lorem ipsum dolor sit amet',
            'attachment' => json_encode(['img1.jpg', 'img2.jpg', 'img3.jpg']),
            'return_date' => '2024-11-18'
        ]);
    }
}
