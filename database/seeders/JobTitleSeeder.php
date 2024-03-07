<?php

namespace Database\Seeders;

use App\Models\job_title;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       job_title::created([
        'departments_id' => '1',
        'title' => 'Flutter',
       ]
       );
    }
}
