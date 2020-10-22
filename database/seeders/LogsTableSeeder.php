<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class LogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('logs')->delete();
        DB::table('logs_contains_errors')->delete();
        
        $current_date_time = Carbon::now()->toDateTimeString();
        for ($x = 0; $x < 4; $x++) {
            DB::table('logs')->insert([
                'id' => $x + 1,
                'system_id' => $x + 1,
                'runday' => '201018',
                'next_working_day' => '201019',
                'status' => 'Z',
                'runtime' => 3600,
                'conclusion' => 'Z',
                'creator' => 'Administrator',
                'created_at' => $current_date_time,
                'updated_at' => $current_date_time
            ]);
        }
    }
}
