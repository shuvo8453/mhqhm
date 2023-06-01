@extends('student.layout.master')
@section('title')
    Feedback
@endsection

@section('content')
{{--    <form>--}}
{{--        <div class="form-group">--}}
{{--            <label for="exampleFormControlInput1"> Email address</label>--}}
{{--            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">--}}
{{--        </div>--}}
{{--        <div class="form-group">--}}
{{--            <label for="exampleFormControlTextarea1">Example textarea</label>--}}
{{--            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>--}}
{{--        </div>--}}
{{--    </form>--}}
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 fw-bold">Feedback
            <a href="#" class="float-end btn btn-sm btn-primary rounded" id="icon" onclick="myFunction()"> <i class="fa-solid fa-plus"></i> </a>
        </h1>
{{--        data table--}}
        <form>
            <div class="form-group row">
                <label for="reason" class="col-sm-2 col-form-label">Reason</label>
                <div class="col-sm-10">
                    <p class="editable">{{ $feedback->reason }}</p>
                    <input type="text" readonly class="form-control d-none" id="reason" value="{{ $feedback->reason }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <p class="editable">{{ $feedback->description }}</p>
                    <textarea class="form-control d-none" readonly id="description" rows="8">{{ $feedback->description }}</textarea>
                </div>
            </div>
        </form>
    </div>
</main>
@endsection

@section('script')
    <script>
        function myFunction(){
            if
        }
    </script>
@endsection