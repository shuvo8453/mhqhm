@extends('admin.layout.master')
@section('title')
    Admin Role
@endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">Admin Role
                @if(Auth::guard('admin')->user()->can('create AdminRole'))
                    <a href="{{route('AdminRole.create')}}" class="float-end rounded btn btn-sm btn-primary" > <i class="fa-solid fa-plus"></i> </a>
                @endif
            </h1>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-border text-center" id="data">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>User Group</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($roles as $row)
                                    <tr>
                                        <td> {{ $loop->index + 1 }}</td>
                                        <td>{{$row->name}}</td>
                                        <td>{{ucfirst($row->guard_name)}}</td>
                                        <td>
                                           <div class="dropdown">

                                                <span class="btn btn-success rounded btn-sm px-3 " type="button" id="action" data-bs-toggle="dropdown" aria-expanded="false" >
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </span>
                                                <ul class="dropdown-menu text-center" aria-labelledby="action">
                                                    <li>
                                                        <a class="dropdown-item" href="{{route('AdminRole.edit',$row->id)}}" aria-disabled="true">Edit</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" role="link" href="{{route('AdminRole.show',$row->id)}}">View</a>
                                                    </li>
                                                    <li>
                                                        @if($row->name != "Super Admin")
                                                        <form method="post" action="{{ route('AdminRole.destroy', $row->id) }}" >
                                                            @csrf
                                                            @method('DELETE')
                                                            <span type="submit" id="destroy" class="dropdown-item">Delete</span>
                                                        </form>

                                                        @endif
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
