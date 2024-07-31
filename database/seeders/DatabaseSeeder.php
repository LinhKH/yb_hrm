<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();

        // DB::table('admin')->insert([
        //     'admin_name' => 'Site Admin',
        //     'admin_email' => 'admin@example.com',
        //     'user_name' => 'admin',
        //     'user_pass' => Hash::make('123456')
        // ]);


        // DB::table('general_settings')->insert([
        //     'com_name' => 'YahooBaba HRM',
        //     'com_logo' => 'default.png',
        //     'com_email' => 'company@email.com',
        //     'cur_format' => '$',
        //     'clock_in_time' => '09:00',
        //     'clock_in_time' => '18:00'
        // ]);


    }
}
