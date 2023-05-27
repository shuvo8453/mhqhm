<!-- @abdullah zahid joy-->
@extends('admin.layout.master')
@section('title')
    Invoice Details
@endsection

@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">Invoice Details
                <a href="{{route("Payment.invoice")}}" class="float-end btn btn-sm btn-primary rounded"> <i class="fa-solid fa-arrow-left"></i> </a>
            </h1>
            <div class="row">
                <div class="col-12">
                        <div class="d-flex justify-content-center ">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <img src="{{$payment->user->avatar}}" alt="student" class="rounded-circle" width="70" height="70">
                                        <div class="mt-3">
                                            <p class="text-secondary mb-1">{{$payment->user->group->name }}  {{$payment->user->group->bn_name ? "/ ".$payment->user->group->bn_name : "" }}</p>
                                            <h4>{{ucfirst($payment->user->details->first_name)}} {{$payment->user->details->last_name}} ({{$payment->user->username}})</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" row ">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                            <table class="table caption-top">
                                                <caption class="text-center fw-bold h4">Invoice #{{ str_pad( $payment->id, 5, '0', STR_PAD_LEFT) }}</caption>
                                                <thead>
                                                <tr>
                                                    <th scope="col">Fee Type</th>
                                                    <th scope="col">Actual Amount</th>
                                                    <th scope="col">Due</th>
                                                    <th scope="col">Amount</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($payment->details as $invoice)
                                                    <tr>
                                                        <td>{{$invoice->feeType->name}} {{$invoice->feeType->bn_name ? "/".$invoice->feeType->bn_name : ""}}</td>
                                                        <td>{{$invoice->actual_amount}}</td>
                                                        <td>{{$invoice->due_amount}}</td>
                                                        <td>{{$invoice->paid_amount}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <td colspan="2" class="text-center" >
                                                        <span class="badge text-bg-success text-white fw-bold  fs-18">Success</span>
                                                    </td>
                                                    <td colspan="2">
                                                        <table class="table ">
                                                            <tr>
                                                                <td>
                                                                    <span class="fw-bold"> Total actual amount</span>
                                                                </td>
                                                                <td>
                                                                    {{$payment->total_actual_amount}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <span class="fw-bold"> Total due</span>
                                                                </td>
                                                                <td>  {{$payment->total_due_amount}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td >
                                                                    <span class="fw-bold"> Total paid</span>
                                                                </td>
                                                                <td class="">  {{$payment->total_paid_amount}}
                                                                </td>
                                                            </tr>
                                                        </table>

                                                    </td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>
        const calculateTotalPaid = (total) => {
            let totalAmount = 0;
            for(let i = 0 ; i < total ; i++){
                let amount = parseInt($(`#invoice_${i}`).val());
                if(amount > 0){
                    totalAmount += amount;
                }

            }
            $("#totalPaid").val(totalAmount);
        }

        document.addEventListener("DOMContentLoaded", function() {


        });
    </script>
@endsection
