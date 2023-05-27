<?php

namespace App\Http\Controllers\Backend\Core;

use App\Http\Controllers\Base\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminRoleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $roles = Role::where('guard_name','admin')->get();
        return view('admin.pages.Role.Admin.index',['roles'=>$roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $permissions = Permission::where('guard_name','admin')->get()->groupBy('group_name');

        return view('admin.pages.Role.Admin.create',[ 'permissions' => $permissions ]);
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
            'name' => 'required|max:255|unique:roles',
        ]);

        $data = $request->only('name');
        $data['guard_name']= "admin";
        $role = Role::create($data);

        $role->syncPermissions($request->permissions);

        $notification = array(
            'messege' => 'Role added Successfully!',
            'alert-type' => 'success'
        );
        return Redirect()->route('AdminRole.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $role = Role::with('permissions')->find($id);
        return view('admin.pages.Role.Admin.view',['role'=> $role]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::where('guard_name','admin')->get()->groupBy('group_name');
        return view('admin.pages.Role.Admin.edit',['permissions' => $permissions,'role'=> $role]);
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
            'name' => 'required|max:255|unique:roles,name,'.$id,
        ]);
        $data = $request->only('name');
        Role::find($id)->update($data);
        Role::find($id)->syncPermissions($request->permissions);

        $notification = array(
            'messege' => 'Role updated Successfully!',
            'alert-type' => 'success'
        );
        return Redirect()->route('AdminRole.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Role::destroy($id);
        $notification = array(
            'messege' => 'Role removed Successfully!',
            'alert-type' => 'success'
        );
        return Redirect()->route('AdminRole.index')->with($notification);
    }
}
