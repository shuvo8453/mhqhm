<!-- @abdullah zahid joy-->
@extends('admin.layout.master')
@section('title')
    Payment
@endsection

@section('content')
    <main class="content">
        <div class="container-fluid p-0">
{{--            <h1 class="h3 mb-3">Payment</h1>--}}
            <div class="row">
                <div class="col-12">
                    @if(empty($student))
                        <div class="card">
                            <div class="card-body">
                                <form class="row g-3" method="get" action="{{route('Payment.due')}}">

                                    <div class="col-auto">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="username" name="username" placeholder="Student Id">
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary mb-3">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="d-flex justify-content-center ">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <img src="{{$student->avatar}}" alt="student" class="rounded-circle" width="70" height="70">
                                        <div class="mt-3">
                                            <p class="text-secondary mb-1">{{$student->group->name }}  {{$student->group->bn_name ? "/ ".$student->group->bn_name : "" }}</p>
                                            <h4>{{ucfirst($student->details->first_name)}} {{$student->details->last_name}} ({{$student->username}})</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" row ">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="Post" action="{{route('Payment.pay')}}">
                                            @csrf
                                            <table class="table caption-top">
                                                <caption class="text-center fw-bold h4">Due List</caption>
                                                <thead>
                                                <tr>
                                                    <th scope="col">Month</th>
                                                    <th scope="col">Fee Type</th>
                                                    <th scope="col">Actual Amount</th>
                                                    <th scope="col">Due</th>
                                                    <th scope="col">Paid</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Amount</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php
                                                    $totalActualAmount = 0;
                                                    $totalDue = 0;
                                                @endphp
                                                @foreach($student->invoice as $invoice )
                                                    @php
                                                    $totalActualAmount +=  $invoice->actual_amount;
                                                    $totalDue +=  $invoice->due;
                                                    @endphp
                                                    <tr>
                                                        <td>{{$invoice->date}}</td>
                                                        <td>{{$invoice->feeType->name}}</td>
                                                        <td>{{$invoice->actual_amount}}</td>
                                                        <td>{{$invoice->due}}</td>
                                                        <td>{{$invoice->paid}}</td>
                                                        <td>{{ucfirst($invoice->status)}}</td>
                                                        <td> <input id="invoice_{{$loop->index}}" class="form-control" type="number" name="amount[{{$loop->index}}]" min="1" max="{{$invoice->total_due}}" value="0" onchange="calculateTotalPaid({{count($student->invoice)}})"> </td>
                                                        <input type="hidden" name="invoice[{{$loop->index}}]" value="{{$invoice->id}}">
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="6"></td>
                                                        <td >
                                                            <table class="table ">
                                                                <tr>
                                                                    <td>
                                                                        <span class="fw-bold"> Total actual amount</span>
                                                                    </td>
                                                                    <td>
                                                                        <input id="total_actual_amount" class="form-control" type="number" name="total_actual_amount" value="{{$totalActualAmount}}" readonly>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <span class="fw-bold"> Total due</span>
                                                                    </td>
                                                                    <td>
                                                                        <input id="total_due" class="form-control" type="number" name="total_due_amount" value="{{$totalDue}}" readonly>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td >
                                                                        <span class="fw-bold"> Total paid</span>
                                                                    </td>
                                                                    <td class="">
                                                                        <input id="totalPaid" class="form-control" type="number" name="total_paid_amount" value="0" readonly>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <input type="hidden" name="user_id" value="{{$student->id}}">
                                            <button type="submit" class="btn btn-success float-end">Save</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
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
