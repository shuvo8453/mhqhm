@extends('admin.layout.master')
@section('title')
    Teacher
@endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">Teacher
                @if(auth()->user()->can('index Teacher'))
                    <a href="{{route('Teacher.index')}}" class="float-end rounded btn btn-sm btn-success">Teacher</a>
                @endif
            </h1>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('Teacher.update',['teacher'=>$teacher->id])}}">
                                @csrf
                                @method("PUT")
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{$teacher->name}}" required>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="initial" class="form-label">Teacher Initial</label>
                                    <input type="text" class="form-control @error('initial') is-invalid @enderror" id="initial" name="initial" value="{{$teacher->initial}}" required>

                                    @error('initial')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{$teacher->email}}" required>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group g-2 mb-3">
                                    <img src="{{$teacher->avatar}}" height="125" width="125">
                                </div>

                                <div class="form-group g-2 mb-3">

                                    <label for="avatar">Avatar</label>
                                    <input class="form-control @error('avatar') is-invalid @enderror" type="file" id="avatar" accept="image/*" name="avatar">

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
