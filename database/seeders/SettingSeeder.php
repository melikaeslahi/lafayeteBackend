<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('settings')->insert([
            'title'=>'عنوان سایت' ,
            'description'=>'توضیحات سایت',
            'keywords'=>'توضیحات سایت',
            'icon'=>'icon.png',
            'logo'=>'logo.png'
        ]);

    }
}
