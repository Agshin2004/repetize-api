<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Desk;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Card::factory()
            ->count(50)
            ->create();
    }
}
