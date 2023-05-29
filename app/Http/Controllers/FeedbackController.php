<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FeedbackController extends Controller
{
    //

    public function index()
    {
        $feedbacks = Feedback::where('user_id', auth()->user()->id)->get();
        return view('/student/pages/feedback/index', ['feedbacks'=>$feedbacks]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
           'reason'      => 'required|max:255',
           'description' => 'required'
        ]);

        Feedback::create([
            'reason'      => $request->reason,
            'description' => $request->description,
            'user_id' => $request->user()->id
        ]);
        return redirect()->route('feedback');
    }
}
