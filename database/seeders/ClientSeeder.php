<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Factories\ClientFactory;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 clients using the ClientFactory
        Client::factory()
            ->count(10)
            ->create();
    }
}
