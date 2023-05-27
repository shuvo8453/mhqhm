<?php
//@abdullah zahid joy
namespace App\Http\Controllers\Backend\System;

use App\Helpers\Module;
use App\Http\Controllers\Base\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ModuleController extends BaseController
{

    public function index(Request $request)
    {
        $models = Module::getAllModel();
        $dataType = Module::getAllDatatype();
        $inputType = Module::getAllInputType();
        return view('admin.pages.Module.index',['dataType'=> $dataType ,'availableModels' => $models ,'inputType'=> $inputType ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            "name" => 'required|max:191|regex:/^\S*$/u|unique:modules',
        ]);
        if( !empty($request->field) ){
            foreach ($request->field["name"] as $name){
                if(is_null($name)){
                    $validator->errors()->add('field_name','Please fill all field name');
                    return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
                }
            }
            foreach ($request->field["type"] as $type){
                if(is_null($type)){
                    $validator->errors()->add('field_type','Please select all field type');
                    return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
                }
            }
            foreach ($request->field["inputType"] as $type){
                if(is_null($type)){
                    $validator->errors()->add('field_type','Please select all field type');
                    return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
                }
            }
        }else{
            $validator->errors()->add('field','Please fill at least one field');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

       $module = Module::create(trim($request->name) , $request->field );
       if(!$module){
           $notification = array(
               'messege' => 'Something went wrong.check manually!',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
        $notification = array(
            'messege' => 'Module Create Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('Module.instruction',['name'=>$request->name])->with($notification);
    }

    public function instruction($name): Factory|View|Application
    {
        return view('admin.pages.Module.instruction',['name'=>$name]);
    }
}
