<?php

namespace App\Http\Controllers\Backend\Core;

use App\Http\Controllers\Base\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $admins = Admin::all();
        return view('admin.pages.Admin.index',['admins'=>$admins]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $roles = Role::where('guard_name','admin')->get();
        return view('admin.pages.Admin.create',['roles'=>$roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|email|unique:admins,email',
            'password' => 'required|max:255|min:6',
            'role' => 'required',
        ]);
        $data = $request->except('avatar','password','role');
        $data['password'] = Hash::make($request->password);
        $file = $request->avatar;

        if(!empty($file)){
            $data['avatar'] = $this->upload($file , "admin/avatar");
        }
        try {
            DB::beginTransaction();
            $admin = Admin::create($data);
            $admin->assignRole($request->role);
            DB::commit();
            $notification = array(
                'messege' => "admin created successfully!!",
                'alert-type' => 'success'
            );
            return Redirect()->route('Admin.index')->with($notification);
        }catch (\Exception $ex){
            DB::rollback();
            $notification = array(
                'messege' => $ex->getMessage(),
                'alert-type' => 'error'
            );
            return Redirect()->route('Admin.create')->with($notification);
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Admin::destroy($id);
        $notification = array(
            'messege' => "Admin Delete Successful!!!",
            'alert-type' => 'success'
        );
        return Redirect()->back()->with($notification);
    }
}
