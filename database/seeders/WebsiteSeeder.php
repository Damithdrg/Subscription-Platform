<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('websites')->insert([
            'name' => 'Ideahub (Pvt) Ltd',
            'url' => 'https://www.ideahub.lk/'
        ]);

        DB::table('websites')->insert([
            'name' => 'Laravel',
            'url' => 'https://laravel.com/'
        ]);

        DB::table('websites')->insert([
            'name' => 'Laravel Daily',
            'url' => 'https://laraveldaily.teachable.com/'
        ]);

    }
}
