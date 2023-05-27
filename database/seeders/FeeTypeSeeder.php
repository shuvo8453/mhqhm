<?php

namespace Database\Seeders;

use App\Models\FeeType;
use Illuminate\Database\Seeder;

class FeeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
            [
                "name"=> "Monthly fees",
                "bn_name"=> "মাসিক ফি",
                "type"=> "monthly",
            ],
            [
                "name"=> "Admission fees",
                "bn_name"=> "ভর্তি ফি",
                "type"=> "fixed",
            ],
            [
                "name"=> "Other fees",
                "bn_name"=> "অন্যান্য ফি",
                "type"=> "monthly",
            ],
        ];

        if (FeeType::count() < 1){
            FeeType::insert($data);
        }
    }
}
