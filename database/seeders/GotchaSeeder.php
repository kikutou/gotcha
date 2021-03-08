<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GotchaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('gotchas')->insert([
        //     'name' => 'test',
        //     'cost_name' => 'チャット',
        //     'cost_value' => 50,
        //     'gotcha_picture_id' => 1,
        //     'gotcha_result_picture_id' => 1
        // ]);
        DB::table('gotchas')
            ->where('id', 1)
            ->update(['created_at' => "2021-03-07 10:42:00"]);
    }
}
