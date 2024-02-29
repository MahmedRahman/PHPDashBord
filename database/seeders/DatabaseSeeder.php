<?php



// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

namespace Database\Seeders;
use Illuminate\Support\Str;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Ensure this uses the correct namespace for your User model

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        $this->call([
            UsersTableSeeder::class,
            DepartmentSeeder::class,
            JobTitleSeeder::class
        ]);


    }
}
