<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
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
                "name"=>"Group",
                "controller"=>"GroupController",
                "route"=>"group.index",
                "migration"=>"2022_11_20_144619_create_groups_table",
            ],
            [
                "name"=>"FeeType",
                "controller"=>"FeeTypeController",
                "route"=>"feeType.index",
                "migration"=>"2022_11_20_151509_create_fee_types_table",
            ],
            [
                "name"=>"Fee",
                "controller"=>"FeeController",
                "route"=>"fee.index",
                "migration"=>"2022_11_23_174547_create_fees_table",
            ],
            [
                "name"=>"Subject",
                "controller"=>"SubjectController",
                "route"=>"subject.index",
                "migration"=>"2022_11_23_185123_create_subjects_table",
            ],
            [
                "name"=>"GroupSubject",
                "controller"=>"GroupSubjectController",
                "route"=>"groupSubject.index",
                "migration"=>"2022_11_23_191220_create_group_subjects_table",
            ],
            [
                "name"=>"Donation",
                "controller"=>"DonationController",
                "route"=>"donation.index",
                "migration"=>"2022_11_23_194338_create_donations_table",
            ],
            [
                "name"=>"ClassTime",
                "controller"=>"ClassTimeController",
                "route"=>"classTime.index",
                "migration"=>"2022_12_11_060323_create_class_times_table",
            ],
        ];
        if(DB::table('modules')->count() == 0){
            DB::table('modules')->insert($data);
        }
    }
}
