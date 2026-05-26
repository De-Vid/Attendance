<?php

namespace Database\Seeders;

use App\Models\AttendanceType;
use Illuminate\Database\Seeder;

class AttendanceTypeSeeder extends Seeder
{
    public function run(): void
    {
        AttendanceType::insert([
            ['name' => 'morning_check_in',    'label' => 'ចូលព្រឹក',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'morning_check_out',   'label' => 'ចេញព្រឹក',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'afternoon_check_in',  'label' => 'ចូលរសៀល', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'afternoon_check_out', 'label' => 'ចេញរសៀល', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}