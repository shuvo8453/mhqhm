@extends('admin.layout.master')
@section('title')
    Recycle Bin
@endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            @foreach($dates as $key => $data)
            <h1 class="h3 fw-bold">{{$key}}</h1>

            <div class="row mb-5">
                <div class="col-12">
                    <table class="table table-border text-center" id="" >
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Delete By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $value)
                                <tr>
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{$value->id}}</td>
                                    <td>{{$value->deletedBy->name}}</td>
                                    <td>
                                        <div class="dropdown">
                                                <span class="btn btn-success rounded btn-sm px-3 " type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </span>
                                            <ul class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton1">
                                                <li>
                                                    <a class="m-2 edit_button  btn  " href="{{route('RecycleBin.recover',[ 'model' =>$row->name , 'id' => $value->id ])}}" id="delete">Recover</a>
                                                </li>
                                                <li><a class="m-2  btn " href="{{route('RecycleBin.delete',[ 'model' =>$row->name , 'id' => $value->id ])}}"  id="delete">Permanently Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </div>
    </main>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $('.table').DataTable({
                "order":false
            });
        });
    </script>
@endsection
