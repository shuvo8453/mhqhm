@extends('admin.layout.master')
@section('title')
    Routine
@endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">Routine
                @if(auth()->user()->can('index Routine'))
                    <a href="{{route('Routine.index')}}" class="float-end rounded btn btn-sm btn-success">Routine</a>
                @endif
            </h1>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-center ">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column align-items-center text-center">
                                            <div class="mt-3">
                                                <p class="text-secondary mb-1">{{$routine->name }} </p>
                                                <h4>{{ucfirst($routine->academic_year)}}</h4>
                                            </div>
                                        </div>
                                    </div>
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
        $(document).ready(function(){
            $('#data').DataTable({
                "order":false
            });
        });

    </script>
@endsection
