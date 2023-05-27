@extends('admin.layout.master')
@section('title')
   Recovery Code
@endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">

            <div class="mb-3">
                <h1 class="h3 d-inline align-middle">Two Step Verification Recovery Codes</h1>
            </div>
            <div class="row">

                <div class="card-body ">
                    <h5 class="card-title mb-3">Please do not Share Those Recovery code with anyone</h5>

                    @foreach(json_decode(decrypt(auth()->user()->two_factor_recovery_codes)) as $code)
                        <li class="mb-3 fw-bold">{{$code}}</li>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
@endsection
