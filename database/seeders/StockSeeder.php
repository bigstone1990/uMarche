<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_stocks')->insert([
            [
                'product_id' => 1,
                'type' => 1,
                'quantity' => 5
            ],
            [
                'product_id' => 1,
                'type' => 1,
                'quantity' => -2
            ],
        ]);
    }
}
