<?php

namespace Database\Seeders;

use App\Models\System\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $setting =  Setting::all()->count();
       if($setting == 0){
           Setting::updateOrCreate([
               'name' => 'siteName',
           ],[
               'value' => 'Markazul Uloom Qoumi Hafizia Boy & Girls Madrasa',
               'type' => 'text',
               'deleteAble' => 'no',
           ]);

           Setting::updateOrCreate([
               'name' => 'shortName',
           ],[
               'value' => 'MUQHBGM',
               'type' => 'text',
               'deleteAble' => 'no',
           ]);

           Setting::updateOrCreate([
               'name' => 'email',
           ],[
               'value' => 'abdullahzahidjoy@gmail.com',
               'type' => 'email',
               'deleteAble' => 'no',
           ]);

           Setting::updateOrCreate([
               'name' => 'phone',
           ],[
               'value' => '01780134797',
               'type' => 'text',
               'deleteAble' => 'no',
           ]);

           Setting::updateOrCreate([
               'name' => 'address',
           ],[
               'value' => '145/3-1 matikhata dhaka cantonment dhaka-1206',
               'type' => 'textarea',
               'deleteAble' => 'no',
           ]);

           Setting::updateOrCreate([
               'name' => 'logo',
           ],[
               'value' => 'upload/setting/221218064451-9920.png',
               'type' => 'image',
               'deleteAble' => 'no',
           ]);

           Setting::updateOrCreate([
               'name' => 'favicon',
           ],[
               'value' => 'upload/setting/221218064502-3708.png',
               'type' => 'image',
               'deleteAble' => 'no',
           ]);

           Setting::updateOrCreate([
               'name' => 'currency',
           ],[
               'value' => 'BDT',
               'type' => 'text',
               'deleteAble' => 'no',
           ]);
           Setting::updateOrCreate([
               'name' => 'currencySymbol',
           ],[
               'value' => '৳',
               'type' => 'text',
               'deleteAble' => 'no',
           ]);

           //Logo

       }
    }
}
