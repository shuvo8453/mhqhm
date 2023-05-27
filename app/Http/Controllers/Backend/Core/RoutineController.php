<?php

namespace App\Http\Controllers\Backend\Core;

use App\Http\Controllers\Base\BaseController;
use App\Models\ClassTime;
use App\Models\Group;
use App\Models\GroupSubject;
use App\Models\Routine;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoutineController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $routines = Routine::all();
        return view('admin.pages.Routine.index', ['routines' => $routines]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $years = $this->getYear();
        $teachers = Teacher::all();
        $times = ClassTime::all();
        $groups = Group::all();
        return view('admin.pages.Routine.create', ["years" => $years, "teachers" => $teachers, "times" => $times, "groups" => $groups]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:191',
            'academic_year' => 'required',
        ]);


        try {
            DB::beginTransaction();
            $data = $request->all();
            $routine = Routine::create($data);
            $details = [];
            for($i = 0 ; $i<count($request->class_time_id);$i++){

                $details[$i]['class_time_id']  = $request->class_time_id[$i] != 0 ? (int)$request->class_time_id[$i] : null;
                $details[$i]['teacher_id']  = $request->teacher_id[$i] != 0 ? (int)$request->teacher_id[$i] : null;
                $details[$i]['group_id']  = $request->group_id[$i] != 0 ? (int)$request->group_id[$i] : null;
                $details[$i]['subject_id']  = $request->subject_id[$i] != 0 ? (int)$request->subject_id[$i] : null;
                $details[$i]['is_break']  = $request->is_break[$i] == 0 ? 0 : 1;
                $details[$i]['note']  = $request->note[$i];

            }
            $routine->details()->createMany($details);

            DB::commit();
            $notification = [
                'messege' => 'Routine Create Successfully!',
                'alert-type' => 'success'
            ];
            return Redirect()->route('Routine.index')->with($notification);
        } catch (\Exception $ex) {
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
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $routine = Routine::find($id);
        return view('admin.pages.Routine.show', ['routine' => $routine]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $routine = Routine::find($id);
        $years = $this->getYear();
        return view('admin.pages.Routine.edit', ["years" => $years, 'routine' => $routine]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Routine $routine)
    {
        $request->validate([
            'name' => 'required|max:191',
            'academic_year' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $data = $request->all();
            $routine->update($data);
            DB::commit();
            $notification = [
                'messege' => 'Routine Update Successfully!',
                'alert-type' => 'success'
            ];
            return Redirect()->route('Routine.index')->with($notification);
        } catch (\Exception $ex) {
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
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Routine $routine)
    {
        $routine->delete();
        $notification = array(
            'messege' => 'Routine delete Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    private function getYear()
    {
        $years = [];
        for ($i = 2010; $i <= Carbon::now()->addYears(5)->format("Y"); $i++) {
            $years[] = $i;
        }
        return $years;
    }

    public function getSubject($id)
    {
        return response()->json([
            'subject' => GroupSubject::with('subject')->where('group_id', $id)->get() ?? [],
            'success' => 200
        ]);
    }
}
