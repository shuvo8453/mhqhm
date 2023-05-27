<?php

namespace App\Http\Controllers\Backend\Core;

use App\Http\Controllers\Base\BaseController;
use App\Models\Fee;
use App\Models\Group;
use App\Models\User;
use App\Models\UserGroup;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $users = User::with("group","details")->get();
        return view('admin.pages.User.index',['users'=>$users ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        $years = [];
        for($i=2010;$i<=now()->format("Y");$i++){
            $years[]=$i;
        }
        $groups = Group::all();
        $type = $request->type ?? "admission";
        return view('admin.pages.User.create',[ "groups"=>$groups,"type" => $type , 'years'=>$years]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->storeValidation($request);

        try {
            DB::beginTransaction();

            $userName = $this->generateUserName($request->group_id , $request->year);
            $password = $this->generatePassword($userName);

            $user = $request->only('email','group_id');
            $user['username'] = $userName;
            $user['password'] = Hash::make($password);
            $file = $request->avatar;
            if(!empty($file)){
                $user['avatar'] = $this->upload($file , "user/avatar");
            }

            $details = $request->except("avatar","email","group_id","year");

            $student = User::create($user);
            $student->details()->create($details);

            $group = $request->only("group_id");
            $group["user_id"] = $student->id;

            UserGroup::create($group);

            $fees = Fee::where("group_id",$request->group_id)->get();
            foreach ($fees as $fee ){
                $feeDetails["fee_type_id"] = $fee->fee_type_id;
                $feeDetails["actual_amount"] = $fee->amount;
                $feeDetails["due"] = $fee->amount;
                $feeDetails["date"] = now()->format("m-Y");
                $student->invoice()->create($feeDetails);
            }

            DB::commit();
            $notification = [
                'messege' => 'Student Create Successfully!',
                'alert-type' => 'success'
            ];
            return Redirect()->route('User.index')->with($notification);
        }catch (\Exception $ex){
            DB::rollBack();
            $notification = array(
                'messege' => "something went wrong!!!",
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
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|email|unique:users,email,'.$id,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id

     */
    public function destroy($id)
    {
        User::destroy($id);
        $notification = array(
            'messege' => 'Student delete Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function changeStatus($id , $status){
        $user = User::find($id);
        $user->status = $status;
        $user->save();

        $notification = array(
            'messege' => 'User Status Changed!',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function print($id ){
        $user = User::with(['group','details'])->find($id);

        $pdf = PDF::loadView('pdf.admission' , ["user" => $user]);

        return $pdf->stream("admission-{$user->username}.pdf");
    }

    public function storeValidation (Request $request){
        $request->validate([
            'first_name' => 'required|max:55',
            'last_name' => 'required|max:55',
            'dob' => 'required',
            'gender' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'parent_contact_number' => 'required|regex:/(01)[0-9]{9}/',
            'contact_number' => 'nullable|regex:/(01)[0-9]{9}/',
            'father_occupation' => 'required',
            'present_address' => 'required',
            'permanent_address' => 'required',
            'group_id' => 'required|numeric',
        ]);
    }

    public function generateUserName($id, $year = ""){
        $newId = $year ?? now()->format('Y');
        $newId .= str_pad($id, 3, '0', STR_PAD_LEFT);

        $group = group::with('student')->find($id);
        $users = User::where("username",'like','%' .$newId . "%")->orderBy('id', 'DESC')->get();

        if(count($group->student) == 0 || count($users) == 0){
            $newId .= str_pad(1, 3, '0', STR_PAD_LEFT);
        }else{
            $newId = $users[0]->username +=1;
        }
        return $newId;
    }

    public function generatePassword($userName){
        return $userName . Str::random(3);
    }
}
