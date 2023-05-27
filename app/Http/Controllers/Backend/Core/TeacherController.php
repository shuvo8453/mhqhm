<?php

namespace App\Http\Controllers\Backend\Core;


use App\Http\Controllers\Base\BaseController;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $teachers = Teacher::all();
        return view('admin.pages.Teacher.index',[  'teachers'=> $teachers ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.pages.Teacher.create');
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
            'name'      => 'required|max:191',
            'email'     => 'required|email',
            'initial'   => 'nullable',
            'avatar'    => 'nullable',
        ]);

        try {
            DB::beginTransaction();
            $data = $request->except('avatar');
            $file = $request->avatar;
            if(!empty($file)){
                $data['avatar'] = $this->upload($file , "teacher/avatar");
            }

            Teacher::create($data);

            DB::commit();
            $notification = [
                'messege' => 'Teacher Create Successfully!',
                'alert-type' => 'success'
            ];
            return Redirect()->route('Teacher.index')->with($notification);
        }catch (\Exception $ex){
            DB::rollBack();
            $notification = array(
                'messege' => $ex->getMessage(),
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Teacher $teacher)
    {
        return view('admin.pages.Teacher.edit',["teacher" => $teacher]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name'      => 'required|max:191',
            'email'     => 'required|email|unique:teachers,email,'.$teacher->id,
            'initial'   => 'nullable',
            'avatar'    => 'nullable',
        ]);
        try {
            DB::beginTransaction();
            $data = $request->except('avatar');
            $file = $request->avatar;
            if(!empty($file)){
                $data['avatar'] = $this->upload($file , "teacher/avatar" , $teacher->avatar);
            }

            $teacher->update($data);

            DB::commit();
            $notification = [
                'messege' => 'Teacher Update Successfully!',
                'alert-type' => 'success'
            ];
            return Redirect()->route('Teacher.index')->with($notification);
        }catch (\Exception $ex){
            DB::rollBack();
            $notification = array(
                'messege' => $ex->getMessage(),
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Teacher::destroy($id);
        $notification = array(
            'messege' => 'Teacher delete Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
