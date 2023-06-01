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
        return view('/student/pages/feedback/show', ['feedbacks'=>$feedbacks]);
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

    public function update(Request $request, Feedback $feedback) {

        $request->validate([
            'reason'      => 'required|max:255',
            'description' => 'required'
        ]);

       // $feedback = Feedback::findOrFail($id);
            /*->update([
            'reason'      => $request->reason,
            'description' => $request->description
        ]);*/

        $feedback->reason = $request->reason;
        $feedback->description = $request->description;
        $feedback->save();

        return back();
    }

    public function show(Feedback $feedback){

        return view('student.pages.feedback.show', compact('feedback'));
    }

    public function destroy(Feedback $feedback){

        $feedback->delete();

        return redirect()->route('feedback')
            ->with('success','Feedback deleted successfully');
    }
}
