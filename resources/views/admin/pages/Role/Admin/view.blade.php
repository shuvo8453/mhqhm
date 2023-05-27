@extends('admin.layout.master')
@section('title')
    Admin Role
@endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">View Role
                @if(auth()->user()->can('index AdminRole'))
                    <a href="{{route('AdminRole.index')}}" class="float-end rounded btn btn-sm btn-success">All Role</a>
                @endif
            </h1>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 >Role Details</h3>
                        </div>
                        <div class="card-body">
                            <h3 class="fw-bold">{{$role->name}}</h3>
                            <p class="fw-bold">Permissions</p>
                            <div class="row">
                                @foreach($role->permissions as $permission)
                                    <div class="col-md-6 col-lg-4 g-2 mb-3 ">
                                        <div class="fw-bold">
                                            <span style="color: green"><i class="fa-solid fa-check-double"></i> </span>{{ucfirst($permission->name)}}
                                        </div>
                                    </div>
                                @endforeach
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
        $(document).ready(function(){});
    </script>
@endsection
