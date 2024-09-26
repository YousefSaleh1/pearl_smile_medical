<?php

namespace Database\Seeders;

use App\Models\WorkingTime;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WorkingTime::create([
            'days'        => 'SAT to THU',
            'of_time'    => '9:00:00',
            'until_time' => '9:00:00',
        ]);
    }
}
