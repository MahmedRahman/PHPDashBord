<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Hash;
use App\Models\User; // Ensure this uses the correct namespace for your User model

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456'), // Always hash passwords!
            'name' => 'Admin User',
            'is_active' => true,
            'vacation_days' => 100,
            'join_date' => now()->format('Y-m-d'), // Use a specific date or the current date
            'role' => 'admin',
            'remember_token' => Str::random(10),
            'employee_no' => '101',
            //'department' => 'Engineering',
            //'job_title' => 'Front-end Developer',
        ]);

        User::create([
            'email' => 'hr@hr.com',
            'password' => Hash::make('123456'), // Always hash passwords!
            'name' => 'Hr User',
            'is_active' => true,
            'vacation_days' => 100,
            'join_date' => now()->format('Y-m-d'), // Use a specific date or the current date
            'role' => 'hr',
            'remember_token' => Str::random(10), 
            'employee_no' => '102',
            //'department' => 'Human Resources',
            //'job_title' => 'HR Manager',// Use the Str facade
        ]);

        User::create([
            'email' => 'tech@tech.com',
            'password' => Hash::make('123456'), // Always hash passwords!
            'name' => 'tech Lead User',
            'is_active' => true,
            'vacation_days' => 100,
            'join_date' => now()->format('Y-m-d'), // Use a specific date or the current date
            'role' => 'techlead',
            'remember_token' => Str::random(10),
            'employee_no' => '103',
            //'department' => 'Engineering',
            //'job_title' => 'Operations Manager', // Use the Str facade
        ]);

        
    }
}
