<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FocusAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $focusAreas = [
            ['name' => 'Core'],
            ['name' => 'Upper Body'],
            ['name' => 'Lower Body'],
            ['name' => 'Cardiovascular System'],
            ['name' => 'Respiratory System'],
            ['name' => 'Stability and Balance'],
            ['name' => 'Nervous System'],
            ['name' => 'Postural Alignment'],
        ];

        DB::table('focus_areas')->insert($focusAreas);
    }
}
