<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
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
                "name"=> "Nursery",
                "bn_name"=> "নার্সারি",
            ],
            [
              "name"=> "Class One",
              "bn_name"=> "ক্লাস ওয়ান",
            ],
            [
                "name"=> "Class Two",
                "bn_name"=> "ক্লাস টু",
            ],
            [
                "name"=> "Class Three",
                "bn_name"=> "ক্লাস থ্রি",
            ],
            [
                "name"=> "Class Four",
                "bn_name"=> "ক্লাস ফোর",
            ],
            [
                "name"=> "Class Five",
                "bn_name"=> "ক্লাস ফাইভ",
            ],

            [
                "name"=> "Nazera",
                "bn_name"=> "নাজেরা",
            ],
            [
                "name"=> "Hefzu",
                "bn_name"=> "হেফজু",
            ],
        ];

        if (Group::count() < 1){
            Group::insert($data);
        }
    }
}
