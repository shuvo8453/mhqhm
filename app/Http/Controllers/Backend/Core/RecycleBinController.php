<?php

namespace App\Http\Controllers\Backend\Core;

use App\Http\Controllers\Base\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecycleBinController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $modules = [];
        $controllers  = scandir(app_path("Http/Controllers/Backend"));

        foreach ($controllers as $row){
            if(str_contains($row , "Controller.php")) $modules[] = str_replace("Controller.php","",$row);
        }

        $data = [];

        foreach($modules as $module){
           $data[$module] = App::make( 'App\\Models\\'. $module )->where('is_deleted','yes')->with('deletedBy')->get();
        }

        return view('admin.pages.Recycle.index',["dates" => $data ]);
    }

    public function delete($model , $id){
        App::make( 'App\\Models\\'. ucfirst( $model) )->destroy($id);
        $notification = array(
            'messege' => 'Recode Delete Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }

    public function recover($model , $id){
        App::make( 'App\\Models\\'. ucfirst( $model) )->where('id',$id)->update([
            'status' => "Active",
            'is_deleted' => "no",
        ]);
        $notification = array(
            'messege' => 'Recode recover Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }

}
