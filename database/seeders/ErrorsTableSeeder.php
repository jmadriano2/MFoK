<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ErrorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('errors')->delete();

        $components = array('FT', 'MS', 'DL', 'SE', 'RE', 'ME');
        $problems = array(
            'FOOB in PRICS',
            'No member. RESPODPD',
            'MSGW Locking on MUSER',
            'Delay Wait',
            'Error in clearing LEAGFMPD'
        );
        $resolutions = array(
            'Solved with style',
            'Solved with amazing resources',
            'I asked Jhen and she solved it',
            'I asked Anna and she solved it',
            'I asked Kalai and she solved it',
            'I asked Ms. Cher and she did the rest of the CoB',
            'Great Balancing act between funds'
        );
        $current_date_time = Carbon::now()->toDateTimeString();
        for ($x = 0; $x < 40; $x++) {
            DB::table('errors')->insert([
                'id' => $x + 1,
                'component' => $components[rand(0,5)] . 'C' . strval(rand(1000,9999)),
                'sequence' => strval(rand(0,99999)),
                'problem' => $problems[rand(0,4)],
                'resolution' => $resolutions[rand(0,5)],
                'og_resolver' => 'Administrator',
                'created_at' => $current_date_time,
                'updated_at' => $current_date_time
            ]);
        }
    }
}
