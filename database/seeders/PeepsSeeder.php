<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeepsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('peeps')->truncate();

        DB::table('peeps')
            ->insert([
                         ['name' => 'GeeH'],
                         ['name' => 'ModestasV'],
                         ['name' => 'LaylaCodesIt'],
                        ['name' => 'cragsimps'],
                     ]);
    }
}
