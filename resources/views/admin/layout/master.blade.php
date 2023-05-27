<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')

    <link rel="shortcut icon" href="{{$systemSetting['favicon']}}" />

    <title>@yield("title") | {{$systemSetting['shortName'] ?? config("app.name")}}</title>
    <link href="{{ asset('asset/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('asset/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/toastr.min.css') }}" rel="stylesheet">
    <script src="{{asset('asset/js/fontawesome.min.js')}}"></script>
    @vite('resources/css/app.css')

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    @yield('style')
</head>

<body>
    <div class="wrapper">
         <!-- sidebar start -->
        @include('admin.layout.partials.sidebar')
        <!-- sidebar end -->
        <div class="main">
            <!-- top navbar start -->
            @include('admin.layout.partials.navbar')
            <!-- top navbar end -->
            <!-- main content start-0 -->
            @yield('content')
            <!-- main content end -->
            <!-- footer start -->
            @include('admin.layout.partials.footer')
            <!-- footer end- -->
        </div>
    </div>

    @include('admin.layout.partials.script')
    @yield('script')
    
</body>
</html>