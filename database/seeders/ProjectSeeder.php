<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Factories\ProjectFactory;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 projects using the ProjectFactory
        Project::factory()
            ->count(10)
            ->create();
    }
}
