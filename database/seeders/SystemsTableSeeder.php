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

        $machines = array('MNF', 'MNP', 'MNQ', 'GBMKILNW', 'PHMKIMNA', 'MNO');
        $systems = array('MA', 'PF', 'CV', 'TC', 'GB', 'LH');
        $releases = array('Midas Plus 1.2.1 Service Pack 19', 'Fusion Midas 2.0', 'Fusion Midas 2.1', 'Midas R4.01.03', 'Fusion Midas 1.4.11.06 IR01', 'Fusion Midas 1.4.11.06 IR02');
        $current_date_time = Carbon::now()->toDateTimeString();
        $counter = 0;
        for ($x = 0; $x < 6; $x++) {
            $zone2 = rand(1, 8);
            for ($y = 0; $y < 2; $y++) {
                $zone1 = substr($systems[$x], 0, 1);
                $year = rand(1990, 2015);
                $month = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
                $day = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);;
                $rundate = $year . $month . $day;
                DB::table('systems')->insert([
                    'machine' => $machines[$x],
                    'system' => $systems[$x],
                    'zone' => $zone1 . $zone2 + $y,
                    'release' => $releases[$x],
                    'rundate' => $rundate,
                    'created_at' => $current_date_time,
                    'updated_at' => $current_date_time,
                    'creator_id' => 1
                ]);
            }
        }
    }
}
