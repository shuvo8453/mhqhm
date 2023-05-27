<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 | {{ config("app.name")}}</title>
    <link href="{{ asset('asset/css/bootstrap.min.css') }}" rel="stylesheet"></head>
<body>
<div class="d-flex align-items-center justify-content-center vh-100">
    <div class="text-center">
        <h1 class="display-1 fw-bold">404</h1>
        <p class="fs-3"> <span class="text-danger">Ops!</span> Page not found.</p>
        <p class="lead">
            The page you’re looking for doesn’t exist.
        </p>
        <a href="{{url("/")}}" class="btn btn-primary">Go Home</a>
    </div>
</div>
</body>
</html>