<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('attendance')->insert([
            ['description' => 'Pending'],
            ['description' => 'Present'],
            ['description' => 'Absent'],
        ]);
    }
}
