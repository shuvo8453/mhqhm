@extends('student.layout.master')
@section('title') Dashboard @endsection
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3"><strong>Welcome to</strong> {{$systemSetting["siteName"]}}</h1>
        </div>
    </main>
@endsection

@section("script")

@endsection
