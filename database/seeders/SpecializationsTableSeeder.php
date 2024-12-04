<?php

namespace Database\Seeders;

use App\Models\Specialization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecializationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Specialization::create([
            'name' => 'Overall Health & Fitness',
            'goal' => 'Improve Fitness/Overall Health'
        ]);
        Specialization::create([
            'name' => 'Weight Loss',
            'goal' => 'Lose Weight'
        ]);
        Specialization::create([
            'name' => 'Strength Training',
            'goal' => 'Increase Strength'
        ]);
        Specialization::create([
            'name' => 'Endurance Training',
            'goal' => 'Improve Endurance'
        ]);
        Specialization::create([
            'name' => 'Bodybuilding',
            'goal' => 'Build Muscle Mass'
        ]);
        Specialization::create([
            'name' => 'Cardio Training',
            'goal' => 'Boost Cardiovascular Fitness'
        ]);
        Specialization::create([
            'name' => 'Flexibility & Mobility',
            'goal' => 'Enhance Flexibility'
        ]);
    }
}
