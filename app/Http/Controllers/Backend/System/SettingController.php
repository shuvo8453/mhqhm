<?php

namespace App\Http\Controllers\Backend\System;

use App\Http\Controllers\Base\BaseController;
 use App\Models\System\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SettingController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $settings = Setting::get();
        return view('admin.pages.Setting.index',['settings'=>$settings]);
    }

    public function store(Request $request){
        $data = $request->all();
        try {
            DB::beginTransaction();
            Cache::forget("setting");
            Setting::create($data);
            DB::commit();
            $notification = array(
                'messege' => "Setting Create Successful!!!",
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }catch (\Exception $ex){
            DB::rollBack();
            $notification = array(
                'messege' => $ex->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'value' => 'required'
        ]);
        if($request->hasFile("value")){
            $file = $request->file('value');
            $oldImg = Setting::select('value')->find($id);
            if(!empty($oldImg->value)){
                $this->deleteFile($oldImg);
            }
            $data['value'] = $this->upload($file, 'setting');
        }else{
            $data = $request->all();
        }
        Cache::forget("setting");
        Setting::find($id)->update($data);
        $notification = array(
            'messege' => 'Setting updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function destroy($id){
        Cache::forget("setting");
        Setting::destroy($id);
        $notification = array(
            'messege' => 'Setting Remove Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
