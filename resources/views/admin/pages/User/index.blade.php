@extends('admin.layout.master')
@section('title')
   Student
@endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <h1 class="h3 fw-bold">Student
                @if(Auth::guard('admin')->user()->can('create User'))
                    <a href="{{route('User.create',["type"=>"create"])}}" class="float-end rounded btn btn-sm btn-primary" ><i class="fa-solid fa-plus"></i></a>
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
                                    <th>Father Name</th>
                                    <th>P.contact number</th>
                                    <th>Group</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $row)
                                    <tr>
                                        <td> {{ $row->username }}</td>
                                        <td> {{ $row->details->first_name ." ".$row->details->last_name }}</td>
                                        <td> {{ $row->details->father_name }}</td>
                                        <td> {{ $row->details->parent_contact_number }}</td>
                                        <td> {{ $row->group->name }}</td>
                                        <td> <span @class(["badge", "bg-success"=>$row->status == "active" , "bg-danger"=>$row->status == "inactive" ]) >{{ ucfirst($row->status) }}</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <span class="btn btn-success rounded btn-sm px-3 " type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </span>
                                                <ul class="dropdown-menu " aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item" href="{{route('User.print',['id'=>$row->id])}}">Print Admission Form</a></li>
                                                    <li><a class="dropdown-item" href="{{route('User.changeStatus',['id'=>$row->id,'status'=>"active"])}}">Mark as Active</a></li>
                                                    <li><a class="dropdown-item" href="{{route('User.changeStatus',['id'=>$row->id,'status'=>"inactive"])}}">Mark as Inactive</a></li>
                                                    <li>
                                                        <form method="post" action="{{ route('User.destroy', $row->id) }}">
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
