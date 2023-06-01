@extends('student.layout.master')
@section('title')
    Feedback
@endsection

@section('content')
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 fw-bold">Feedback
{{--            <a href="#" class="float-end btn btn-sm btn-primary rounded" id="icon" onclick="myFunction()"> <i class="fa-solid fa-plus"></i> </a>--}}
            <button class="float-end btn btn-sm btn-primary rounded" id="icon" onclick="showFunction()">
                <i class="fa-solid fa-plus"></i>
            </button>
        </h1>
        {{--data table--}}
        <form method="post"  action="{{url('/feedback/'.$feedback->id)}}" enctype="multipart/form-data" >
            @csrf
            <div class="form-group row">
                <label for="reason" class="col-sm-2 col-form-label">Reason</label>
                <div class="col-sm-10">
                    <p class="editable">{{ $feedback->reason }}</p>
                    <input type="text" class="form-control edit-input d-none" id="edit_reason" name="reason" value="{{ $feedback->reason }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <p class="editable">{{ $feedback->description }}</p>
                    <textarea class="form-control edit-input d-none" id="edit_description" name="description" rows="8">{{ $feedback->description }}</textarea>
                </div>
            </div>
            <button class="float-end btn btn-sm btn-primary rounded edit-input mt-2 d-none" type="submit" id="save" onclick="storeFunction()">
                Save
            </button>
        </form>
    </div>
</main>
@endsection

@section('script')
    <script>
        function showFunction(){
            if($(".edit-input").hasClass("d-none")){
                $(".edit-input").removeClass("d-none");
                $(".editable").addClass("d-none");
            } else {
                $(".edit-input").addClass("d-none");
                $(".editable").removeClass("d-none");
                $("#save").addClass("d-none");
            }
        }
    </script>
@endsection