@extends('admin.layout.master')
@section('title')
    Routine
@endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <h1 class="h3 fw-bold">Routine
                @if(Auth::guard('admin')->user()->can('create Routine'))
                    <a href="{{route('Routine.create')}}" class="float-end rounded btn btn-sm btn-primary" ><i class="fa-solid fa-plus"></i></a>
                @endif
            </h1>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-border text-center" id="data">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Academic Year</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($routines as $routine)
                                    <tr>
                                        <td> {{ $loop->index+1 }}</td>
                                        <td> {{ $routine->name }}</td>
                                        <td> {{ $routine->academic_year }}</td>
                                        <td> <span @class(["badge", "bg-success"   =>  $routine->status == "active" , "bg-danger"  =>   $routine->status == "inactive" ]) >{{ ucfirst($routine->status) }}</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <span class="btn btn-success rounded btn-sm px-3 " type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </span>
                                                <ul class="dropdown-menu " aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item" href="{{route('Routine.show',['routine' => $routine->id])}}">View</a></li>
                                                    <li><a class="dropdown-item" href="{{route('Routine.edit',['routine' => $routine->id])}}">Edit</a></li>
                                                    <li>
                                                        <form method="post" action="{{ route('Routine.destroy', $routine->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <span type="submit" class="destroy dropdown-item">Delete</span>
                                                        </form>
                                                    </li>
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
