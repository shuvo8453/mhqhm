<!-- @abdullah zahid joy-->
@extends('admin.layout.master')
@section('title')
    Invoice
@endsection

@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">Invoice</h1>
            <div class="row">
                <div class="col-12">
                    <div class=" row ">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table caption-top" id="data">
                                        <thead>
                                        <tr>
                                            <th scope="col">Id</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Group</th>
                                            <th scope="col">Actual amount</th>
                                            <th scope="col">Due</th>
                                            <th scope="col">Paid</th>
                                            <th scope="col">Month</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($payments as $payment )
                                            <tr>
                                                <td> {{$payment->user->username ?? "" }}</td>
                                                <td> {{$payment->user->details->first_name . " " .$payment->user->details->last_name }}</td>
                                                <td> {{$payment->user->group->name  }}  {{$payment->user->group->bn_name ? "/ ".$payment->user->group->bn_name : "" }}</td>
                                                 <td> {{$payment->total_actual_amount}} </td>
                                                <td> {{$payment->total_due_amount}} </td>
                                                <td> {{$payment->total_paid_amount}} </td>
                                                <td> {{$payment->date}}</td>
                                                <td>
                                                    @if($payment->status == "success")
                                                        <span class="badge text-bg-success text-white">{{$payment->status }}</span>
                                                    @else
                                                        <span class="badge text-bg-danger text-white">{{$payment->status }}</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <div class="dropdown">
                                                    <span class="btn btn-success rounded btn-sm px-3 " type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </span>
                                                        <ul class="dropdown-menu " aria-labelledby="dropdownMenuButton1">
                                                            <li><a class="dropdown-item" href="{{route('Payment.pdf',$payment->id)}}">Print</a></li>
                                                            <li><a class="dropdown-item" href="{{route('Payment.view',['id'=>$payment->id])}}">View</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
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
        document.addEventListener("DOMContentLoaded", function() {
            $('#data').DataTable({
                "order":false
            });
        });
    </script>
@endsection
