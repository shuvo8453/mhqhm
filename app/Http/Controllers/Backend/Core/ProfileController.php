<?php

namespace App\Http\Controllers\Backend\Core;

use App\Http\Controllers\Base\BaseController;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function privacy(){
        return view('admin.pages.Profile.privacy');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function profile(){
        return view('admin.pages.Profile.index');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function recovery(){
        return view('admin.pages.Profile.recovery');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeProfile(Request $request){
        $request->validate([
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:10000',
        ]);

        $admin = Admin::find(Auth::guard('admin')->id());

        $image = $request->file('image');
        $url = $this->upload($image , "admin/avatar",$admin->avatar);

        $admin->avatar = $url;
        $admin->save();

        $notification = array(
            'messege' => 'Profile image Change Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function confirmPassword(){
        return view('auth.admin.password.confirm');
    }

    public function twoFactorChallenge(){
        return view('auth.admin.twoFactorChallenge');
    }
}
