<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                [
                    'name' => 'Kseniya',
                    'email' => 'kseniya@test.ru',
                    'password' => Hash::make('password'),
                ],
                [
                    'name' => 'Konstantin',
                    'email' => 'konstantin@test.ru',
                    'password' => Hash::make('password'),
                ],
                [
                    'name' => 'Alex',
                    'email' => 'alex@test.ru',
                    'password' => Hash::make('password'),
                ],
                [
                    'name' => 'Sheldon',
                    'email' => 'sheldon@test.ru',
                    'password' => Hash::make('password'),
                ],
            ],
        );
    }
}
