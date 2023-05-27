@extends('admin.layout.master')
@section('title')
    Application Setting
@endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="mb-3">
                <h1 class="h3 d-inline align-middle">Application Setting
                    <button class="float-end btn btn-sm btn-primary rounded"  data-bs-toggle="modal" data-bs-target="#add" > <i class="fa-solid fa-plus"></i> </button>
                </h1>
            </div>

            <!-- Modal for add  -->
            <div class="modal fade" id="add" tabindex="-1" aria-labelledby="add_Label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="add_Label">Add New Setting</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" enctype="multipart/form-data" action="{{route('Setting.store')}}">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label ">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"  required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="value" class="form-label ">Value</label>
                                    <input type="text" class="form-control" id="value" name="value"  required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="type" class="form-label ">Type</label>
                                    <select class="form-select" aria-label="Type"  id="type" name="type">
                                        <option selected value="text">Text</option>
                                        <option  value="textarea">Text Area</option>
                                        <option  value="number">Number</option>
                                        <option  value="email">Email</option>
                                        <option  value="image">Image</option>
                                    </select>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end Modal for add-->
            <div class="row">
                    <div class="col-md-4 col-xl-3">
                        @foreach($settings as $setting)
                            @if($setting->type == "image")
                                <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">{{ucfirst($setting->name)}}</h5>
                            </div>
                            <div class="card-body text-center">
                                <div style="position: relative; width: 150px; height: 150px">
                                    <img  src="{{ $setting->value }}" alt="{{$setting->name}}" class="img-fluid rounded-circle mb-2" style="width:100%; height:100%;  overflow: hidden;" />
                                    <button style="bottom: 0;right:0; position: absolute;border-radius: 50%;width: 35px;height: 35px" data-bs-toggle="modal" data-bs-target="#change{{ucfirst($setting->name)}}" class="btn btn-primary btn-sm"> <i class="align-middle" data-feather="camera"></i></button>
                                </div>
                            </div>
                            <hr class="my-0" />
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="change{{ucfirst($setting->name)}}" tabindex="-1" aria-labelledby="change{{ucfirst($setting->name)}}Label" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form method="post" action="{{route('Setting.update',$setting->id)}}"  enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="change{{ucfirst($setting->name)}}Label">Change {{ucfirst($setting->name)}}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-floating">
                                                <input type="file" class="form-control" id="image" name="value" placeholder="Image" accept="image/*">
                                                <label for="image">{{ucfirst($setting->name)}}</label>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                            @endif
                        @endforeach
                    </div>

                <div class="col-md-8 col-xl-9">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Update Application Setting</h5>
                        </div>
                        <div class="card-body h-100">
                            <div class="d-flex align-items-start">
                                <div class="flex-grow-1">
                                @foreach($settings as $setting)
                                    @if($setting->type != "image")
                                        <form method="POST" action="{{route('Setting.update', $setting->id)}}">
                                            @csrf
                                            @method('put')
                                            <div class="form-group g-2 mb-3">
                                                <label for="{{$setting->name}}">{{ucfirst($setting->name)}}</label>
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        @if($setting->type == "text")
                                                            <input type="text" class="form-control"  id="{{$setting->name}}" name="value" required value="{{$setting->value}}">
                                                        @endif
                                                        @if($setting->type == "email")
                                                            <input type="email" class="form-control"  id="{{$setting->name}}" name="value" required value="{{$setting->value}}">
                                                        @endif
                                                        @if($setting->type == "number")
                                                            <input type="number" class="form-control"  id="{{$setting->name}}" name="value" required value="{{$setting->value}}">
                                                        @endif
                                                        @if($setting->type == "textarea")
                                                                <textarea class="form-control" id="{{$setting->name}}" name="value" required rows="3">{{$setting->value}}</textarea>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="submit" class="btn btn-success btn-sm"><i class="fa-sharp fa-solid fa-check"></i></button>
                                                        @if($setting->deleteAble == "yes")
                                                            <a href="{{route('Setting.destroy',$setting->id)}}" id="delete" class=" btn btn-danger btn-sm m-2"><i class="fa-solid fa-x"></i></a>
                                                        @endif
                                                    </div>
                                                </div>
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </form>
                                    @endif
                                @endforeach
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

        });
    </script>
@endsection
