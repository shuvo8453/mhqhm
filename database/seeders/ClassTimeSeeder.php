<?php

namespace Database\Seeders;

use App\Models\ClassTime;
use Illuminate\Database\Seeder;

class ClassTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'First Hour',
                'bn_name' => 'প্রথম ঘন্টা',
                'start_time' => '09:00:00',
                'end_time' => '09:45:00',
            ],
            [
                'name' => 'Second Hour',
                'bn_name' => 'দ্বিতীয় ঘন্টা',
                'start_time' => '09:45:00',
                'end_time' => '10:30:00',
            ],
            [
                'name' => 'Snack break',
                'bn_name' => 'জলখাবার বিরতি',
                'start_time' => '10:30:00',
                'end_time' => '10:45:00',
            ],
            [
                'name' => 'Third Hour',
                'bn_name' => 'তৃতীয় ঘন্টা',
                'start_time' => '10:45:00',
                'end_time' => '11:30:00',
            ],

            [
                'name' => 'Fourth Hour',
                'bn_name' => 'চতুর্থ ঘন্টা',
                'start_time' => '11:30:00',
                'end_time' => '12:15:00',
            ],

            [
                'name' => 'Lunch break',
                'bn_name' => 'দুপুরের খাবার বিরতি',
                'start_time' => '12:15:00',
                'end_time' => '14:15:00',
            ],
            [
                'name' => 'Fifth Hour',
                'bn_name' => 'পঞ্চম ঘন্টা',
                'start_time' => '14:15:00',
                'end_time' => '15:00:00',
            ],

            [
                'name' => 'Sixth Hour',
                'bn_name' => 'ষষ্ঠ ঘন্টা',
                'start_time' => '15:00:00',
                'end_time' => '15:45:00',
            ],

        ];

        if (ClassTime::count() < 1){
            ClassTime::insert($data);
        }
    }
}
