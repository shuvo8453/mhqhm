<?php

namespace Database\Seeders;

use App\Models\FeeType;
use App\Models\Group;
use Illuminate\Database\Seeder;

class FeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = Group::all();
        $monthly = FeeType::where('name' , 'Monthly fees')->first();
        $admission = FeeType::where('name' , 'Admission fees')->first();
        $other = FeeType::where('name' , 'Other fees')->first();
        //dd($monthly->id);
        foreach ($groups as $group){
            $data = [
                [
                     'fee_type_id' => $admission->id,
                     'amount' => 320,
                ],
                [
                    'fee_type_id' => $other->id,
                    'amount' => 200,
                ],
            ];
            if($group->name == "Hefzu"){
                $data[]=[
                    'fee_type_id' => $monthly->id,
                    'amount' => 500,
                ];
            }elseif($group->name == "Nazera"){
                $data[]=[
                    'fee_type_id' => $monthly->id,
                    'amount' => 400,
                ];
            }else{
                $data[]=[
                    'fee_type_id' => $monthly->id,
                    'amount' => 300,
                ];
            }
            $group->fee()->createMany($data);
        }
    }
}
