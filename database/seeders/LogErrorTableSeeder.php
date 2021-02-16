<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class LogErrorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $current_date_time = Carbon::now()->toDateTimeString();
        for ($x = 0; $x < 4; $x++) {
            for ($y = 0; $y < 8; $y++) {
                DB::table('logs_contains_errors')->insert([
                    'log_id' => $x + 1,
                    'error_id' => ($x * 5) + $y + 1,
                    'created_at' => $current_date_time,
                    'updated_at' => $current_date_time
                ]);
            }
        }
    }
}
