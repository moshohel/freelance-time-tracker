<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TimeLog;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TimeLog>
 */
class TimeLogFactory extends Factory
{

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'project_id' => Project::factory(),
            'start_time' => Carbon::now()->subHours(rand(1, 10)),
            'end_time' => Carbon::now()->subHours(rand(0, 9)),
            'hours' => fake()->randomFloat(2, 0, 10),
            'tag' => fake()->randomElement(['billable', 'non-billable']),
        ];
    }
}
