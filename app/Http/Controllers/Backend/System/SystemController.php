<?php
//@abdullah zahid joy
namespace App\Http\Controllers\Backend\System;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Database\Seeders\PermissionSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class SystemController extends Controller
{
    /**
     * @return string
     */
    public function update(): string
    {
        Cache::flush();
        //get all available module
        $controller = [];
        $controllers  = scandir(app_path("Http/Controllers/Backend"));
        foreach ($controllers as $row){
            if(str_contains($row , "Controller.php"))
                $controller[] = [
                    "model" => str_replace("Controller.php","",$row),
                    "controller" => $row,
                ];
        }

        $modules = collect($controller);
        $sorting = DB::table('backend_menus')->max('sorting') + 1;

        //create menu for all module if not available yet
        foreach ($modules as $module){
           $menu = DB::table('backend_menus')->where('route',$module["model"] . ".index")->first();
            if(empty($menu)){
                DB::table('backend_menus')->insert([
                    'route' => $module["model"] . ".index",
                    'title' => $module["model"],
                    'sorting'=>$sorting,
                ]);
            }
            $sorting++;
        }

        //regenerate permission
        $permissions  = new PermissionSeeder();
        $permissions->run();
        //migrate database
        Artisan::call('migrate');
        return "System update successfully";
    }

    public function password_check(Request $request){
        if(!empty($request->password)){
            $admin =Admin::find(Auth::guard('admin')->user()->id) ;
            if(!Hash::check($request->password , $admin->password)){
                return response(['error' => true, 'errors' => 'Password not match'], 422);
            }else{
                return response(['message'=>"confirmed"],200);
            }
        }else{
            return response(['error' => true, 'errors' => 'Please enter password'], 400);
        }
    }
}
