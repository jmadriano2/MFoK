<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = [
            ['username' => 'LinkSparrow', 'password' => 'P@ssw0rd'],
            ['username' => 'bossbuwi', 'password' => 'P@ssw0rd']
        ];

        DB::table('admins')->insert($admins);
    }
}
