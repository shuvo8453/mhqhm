<?php

namespace App\Http\Controllers\Backend\Core;

use App\Http\Controllers\Base\BaseController;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\Promise\all;

class PaymentController extends BaseController
{
    public function index(){
        return view('admin.pages.Payment.index');
    }

    public function due(Request $request){
            $student = User::with(['invoice' => function($q){
                $q->with('feeType')->whereNot('status',"paid");
            },'group:id,name,bn_name'
            ])->where('username',$request->username)->first();

            return $student ? view('admin.pages.Payment.index',['student'=>$student]) : redirect()->route("Payment.index");
    }

    public function pay(Request $request){

        try {
            DB::beginTransaction();
            $data = $request->except("amount","invoice");
            $data["date"] = now();
            $payment = Payment::create($data);

            foreach ($request->invoice as $key=>$value){
                if(!empty($request->amount[$key])){
                    $data = $this->calculateDue($payment,$value ,$request->amount[$key]);
                    Invoice::find($value)->update($data);

                }
            }
            DB::commit();
            $notification = array(
                'messege' => "payment Successful.",
                'alert-type' => 'success'
            );
            return Redirect()->route('Payment.invoice')->with($notification);

        }catch (Exception $ex){
            DB::rollBack();
            $notification = array(
                'messege' => $ex->getMessage(),
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }

    }

    private function calculateDue($payment,$id , $amount){
        $invoice = Invoice::find($id);
        $data["due"] = $invoice->due - $amount;
        $data["paid"] = $invoice->paid + $amount;

        $paymentDetails["fee_type_id"] = $invoice->fee_type_id;
        $paymentDetails["paid_amount"] = $amount;
        $paymentDetails["due_amount"] = $data["due"];
        $paymentDetails["actual_amount"] = $invoice->actual_amount;

        if($data["due"] == 0) $data["status"] = "paid";
        $payment->details()->create($paymentDetails);
        return $data;
    }

    public function invoice(){
        $payments = Payment::with(['user' => function($q){
            $q->with(['details','group:id,name,bn_name']);
        },'details'])->orderByDesc("id")->get();
        return view('admin.pages.Payment.invoice' , ['payments' => $payments]);
    }

    public function pdf($id){
        $payment = Payment::with(['user' => function($q){
            $q->with(['details','group:id,name,bn_name']);
        },'details'=>function($q){
            $q->with('feeType');
        }])->orderByDesc("id")->find($id);

        $pdf = PDF::loadView('pdf.invoice' , ["payment"=>$payment]);

        $name = "invoice-{$payment->id}.pdf";
        return $pdf->stream($name);
    }


    public function view( $id ){
        $payment = Payment::with(['user' => function($q){
            $q->with(['details','group:id,name,bn_name']);
        },'details'=>function($q){
            $q->with('feeType');
        }])->orderByDesc("id")->find($id);

        return view('admin.pages.Payment.view',['payment'=>$payment]);
    }

}
