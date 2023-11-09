<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('primary_categories')->insert([
            [
                'name' => 'キッズファッション',
                'sort_order' => 1,
            ],
            [
                'name' => '出産祝い・ギフト',
                'sort_order' => 2,
            ],
            [
                'name' => 'ベビーカー',
                'sort_order' => 3,
            ],
        ]);

        DB::table('secondary_categories')->insert([
            [
                'name' => '靴',
                'primary_category_id' => 1,
                'sort_order' => 1,
            ],
            [
                'name' => 'トップス',
                'primary_category_id' => 1,
                'sort_order' => 2,
            ],
            [
                'name' => 'バッグ・ランドセル',
                'primary_category_id' => 1,
                'sort_order' => 3,
            ],
            [
                'name' => 'ギフトセット',
                'primary_category_id' => 2,
                'sort_order' => 4,
            ],
            [
                'name' => 'メモリアル・記念品',
                'primary_category_id' => 2,
                'sort_order' => 5,
            ],
            [
                'name' => 'おむつケーキ',
                'primary_category_id' => 2,
                'sort_order' => 6,
            ],
        ]);
    }
}
