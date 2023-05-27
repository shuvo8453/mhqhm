@extends('admin.layout.master')
@section('title')
   Admin Role
@endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">Edit Admin Role
                @if(auth()->user()->can('index AdminRole'))
                    <a href="{{route('AdminRole.index')}}" class="float-end rounded btn btn-sm btn-success">All Role</a>
                @endif
            </h1>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="{{route('AdminRole.update',$role->id)}}">
                                @csrf
                                @method('put')
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required value="{{$role->name}}">

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="row mb-3">
                                    @foreach($permissions as $group => $values)
                                        <div class="mb-3 fw-bold ">
                                            <span>{{ucfirst($group)}}</span>
                                        </div>
                                        @foreach( $values as $row)
                                            <div class="col-md-6 col-lg-4 g-2 mb-3 ">
                                                <div class="form-check ">
                                                    <input class="form-check-input " type="checkbox" id="permissions_{{$row->id}}" @if( $role->permissions->contains($row->id) ) {{'checked'}}  @endif name="permissions[]" value="{{$row->id}}" >
                                                    <label class="form-check-label" for="permissions_{{$row->id}}">
                                                        {{ucfirst($row->name)}}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endforeach
                                </div>

                                <button type="submit" class="btn btn-primary float-end">Update</button>
                            </form>
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
