<?php

namespace Database\Seeders;

use App\Models\department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        department::create([
           'title' => 'Engineering',
        ]);

        department::create([
            'title' => 'Sales and Marketing',
         ]);

         department::create([
            'title' => 'Human Resources',
         ]);

     
    }
}
