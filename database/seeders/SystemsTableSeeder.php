<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SystemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cob_logs')->delete();
        DB::table('systems')->delete();

        $machines = array('MNF', 'MNP', 'MNQ', 'GBMKILNW');
        $systems = array('MA', 'PF', 'CV', 'TC');
        $zones = array('M1', 'F6', 'C9', 'T3');
        $releases = array('MP121', 'FM2.0', 'FM2.1', 'R4.01.03');
        $rundates = array('20020816', '20040506', '20011126', '19970723');
        $current_date_time = Carbon::now()->toDateTimeString();
        for ($x = 0; $x < 4; $x++) {
            DB::table('systems')->insert([
                'id' => $x + 1,
                'machine' => $machines[$x],
                'system' => $systems[$x],
                'zone' => $zones[$x],
                'release' => $releases[$x],
                'rundate' => $rundates[$x],
                'created_at' => $current_date_time,
                'updated_at' => $current_date_time
                ]);
            }
    }
}
