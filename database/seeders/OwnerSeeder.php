<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('owners')->insert([
            [
                'name' => 'owner-test1',
                'email' => 'owner1@test.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/09/01 01:23:45'
            ],
            [
                'name' => 'owner-test2',
                'email' => 'owner2@test.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/09/02 01:23:45'
            ],
            [
                'name' => 'owner-test3',
                'email' => 'owner3@test.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/09/03 01:23:45'
            ],
            [
                'name' => 'owner-test4',
                'email' => 'owner4@test.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/09/04 01:23:45'
            ],
            [
                'name' => 'owner-test5',
                'email' => 'owner5@test.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/09/05 01:23:45'
            ],
            [
                'name' => 'owner-test6',
                'email' => 'owner6@test.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/09/06 01:23:45'
            ],
            [
                'name' => 'owner-test7',
                'email' => 'owner7@test.com',
                'password' => Hash::make('password'),
                'created_at' => '2023/09/07 01:23:45'
            ],
        ]);
    }
}
