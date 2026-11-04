<?php

namespace Database\Seeders;

use App\Models\c_user;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        c_user::factory()->count(30)->create();
    }
}