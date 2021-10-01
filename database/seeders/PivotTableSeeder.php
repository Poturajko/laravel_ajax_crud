<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PivotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $cnt = 1;
        for ($i = 1; $i <= 60; $i++) {
            $data = [
                [
                    'book_id' => $i,
                    'author_id' => $i > 30 ? $cnt++ : $i,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            ];

            DB::table('author_book')->insert($data);
        }
    }
}
