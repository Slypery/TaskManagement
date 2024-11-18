<?php

namespace Database\Seeders;

use App\Models\ManagerTaskReturn;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ManagerTaskReturnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ManagerTaskReturn::create([
            'manager_task_id' => 1,
            'description' => 'lorem ipsum dolor sit amet',
            'attachment' => json_encode(['img1.jpg', 'img2.jpg', 'img3.jpg']),
            'return_date' => '2024-11-18'
        ]);
    }
}
