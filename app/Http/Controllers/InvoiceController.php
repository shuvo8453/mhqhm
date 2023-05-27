<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    //
    public function invoice()
    {
        $user = auth()->user()->load('invoice');
        $invoices = $user->invoice;
        return view('/student/pages/invoice/index', ['user'=>$user, 'invoices'=>$invoices]);
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
}
