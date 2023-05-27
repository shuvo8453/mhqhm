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
                            <form method="post" enctype="multipart/form-data" action="{{route('Routine.update',['routine' => $routine->id])}}">
                                @csrf
                                @method("PUT")
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{$routine->name}}" required>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="academic_year" class="form-label ">Academic year</label>
                                    <select class="form-select" id="academic_year" name="academic_year" required>
                                        <option selected>Choose...</option>
                                        @foreach($years as $year)
                                            <option value="{{$year}}" @if($year == $routine->academic_year) selected @endif>{{$year}} </option>
                                        @endforeach
                                    </select>
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
