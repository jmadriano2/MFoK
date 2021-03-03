<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CobLogsTableSeeder extends Seeder
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
        DB::table('cob_logs')->insert([
            'id' => 1,
            'system_id' => 1,
            'runday' => '20210216',
            'next_working_day' => '20210217',
            'status' => 'Ongoing',
            'runtime' => 3600,
            'conclusion' => '',
            'creator' => 'Administrator',
            'created_at' => $current_date_time,
            'updated_at' => $current_date_time
        ]);
        $conclusions = ["","Full CoB", "Reopened", "Reopened"];
        for ($x = 1; $x < 4; $x++) {
            DB::table('cob_logs')->insert([
                'id' => $x + 1,
                'system_id' => $x + 1,
                'runday' => '20210216',
                'next_working_day' => '20210217',
                'status' => 'Completed',
                'runtime' => 3600,
                'conclusion' => $conclusions[$x],
                'creator' => 'Administrator',
                'created_at' => $current_date_time,
                'updated_at' => $current_date_time
            ]);
        }
    }
}
