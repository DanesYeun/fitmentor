<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin ',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'profile_photo_path' => null,
            'remember_token' => Str::random(10),
        ]);


        User::create([
            'name' => 'Instructor',
            'email' => 'instructor@instructor.com',
            'password' => Hash::make('instructor123'),
            'role' => 'instructor',
            'expertise' => 'Full Body',
            'profile_photo_path' => null,
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Staff',
            'email' => 'staff@staff.com',
            'password' => Hash::make('staff123'),
            'role' => 'staff',
            'profile_photo_path' => null,
            'remember_token' => Str::random(10),
        ]);


        User::create([
            'name' => 'Student ',
            'email' => 'student@student.com',
            'password' => Hash::make('student123'),
            'role' => 'student',
            'profile_photo_path' => null,
            'remember_token' => Str::random(10),
        ]);
    }
}
