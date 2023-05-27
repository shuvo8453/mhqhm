@extends('admin.layout.master')
@section('title')
    Teacher
@endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <h1 class="h3 fw-bold">Teacher
                @if(Auth::guard('admin')->user()->can('create Teacher'))
                    <a href="{{route('Teacher.create')}}" class="float-end rounded btn btn-sm btn-primary" ><i class="fa-solid fa-plus"></i></a>
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
                                    <th>Initial</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($teachers as $teacher)
                                    <tr>
                                        <td> {{ $loop->index+1 }}</td>
                                        <td> {{ $teacher->name }}</td>
                                        <td> {{ $teacher->initial }}</td>
                                        <td> {{ $teacher->email  }}</td>
                                        <td> <span @class(["badge", "bg-success"=>$teacher->status == "active" , "bg-danger"=>$teacher->status == "inactive" ]) >{{ ucfirst($teacher->status) }}</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <span class="btn btn-success rounded btn-sm px-3 " type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </span>
                                                <ul class="dropdown-menu " aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item" href="{{route('Teacher.edit',['teacher'=>$teacher->id])}}">Edit</a></li>
                                                   <li>
                                                        <form method="post" action="{{ route('Teacher.destroy', $teacher->id) }}">
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
