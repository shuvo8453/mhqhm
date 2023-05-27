<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use Illuminate\Http\Request;

class StudentController extends BaseController
{
    //
    public function dashboard(Request $request)
    {
        $invoice = ($request->user()->load('invoice'));
        return view('student.pages.dashboard.index',['invoice'=>$invoice]);
    }

}
