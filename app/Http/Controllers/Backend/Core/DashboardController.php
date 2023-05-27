<?php
//@abdullah zahid joy
namespace App\Http\Controllers\Backend\Core;

use App\Http\Controllers\Base\BaseController;
use App\Models\Admin;
use App\Models\Donation;
use App\Models\Payment;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\never
     */
    public function index()
    {

        $collectByMonth = Payment::select(DB::raw("sum(total_paid_amount) as total_amount"),DB::raw("DATE_FORMAT(created_at,'%b-%Y') as month"))
            ->groupBy(DB::raw("DATE_FORMAT(created_at,'%b-%Y')"))->get();
        $donations = Donation::orderByDesc('id')->with("donor")->take(5)->get();
        $totalStudent = User::count() ?? 0;
        $totalAdmin = Admin::count() ?? 0;
        $totalDonation = Donation::whereMonth("created_at" ,"=" , now()->format('m') )->sum("amount") ?? 0;
        $totalFee = Payment::where("status" , "success")->whereMonth("date" ,"=" , now()->format('m') )->sum("total_paid_amount") ?? 0;
        $studentByGender = userDetails::select('gender',DB::raw("count(*) as total"))->groupBy('gender')->get();
        return view('admin.pages.Dashboard.index',[
            'studentByGender'   =>$studentByGender ,
            'totalStudent'      => $totalStudent,
            'totalAdmin'        => $totalAdmin,
            'totalDonation'     => $totalDonation,
            'totalFee'          => $totalFee,
            'donations'         => $donations,
            'collectByMonth'    => $collectByMonth,
        ]);
    }
}
