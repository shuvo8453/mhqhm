<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<p>login<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="shortcut icon" href="{{$systemSetting['favicon']}}"/>
        <title>Admin Login | {{$systemSetting['shortName'] ?? config("app.name")}}</title>

        <link href="{{ asset('asset/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('asset/css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('asset/css/toastr.min.css') }}" rel="stylesheet">
        <script src="{{asset('asset/js/fontawesome.min.js')}}"></script>
        <link href="{{ asset('asset/css/custom.css') }}" rel="stylesheet">
        @vite('resources/css/app.css')

        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

        <style>
            .password-container {
                width    : 495px;
                position : relative;
            }

            .password-container input[type="password"],
            .password-container input[type="text"] {
                width   : 100%;
                padding : 12px 36px 12px 12px;

            }

            .fa-eye, .fa-eye-slash {
                position : absolute;
                top      : 32%;
                right    : 4%;
                cursor   : pointer;
                color    : lightgray;
            }

            .custom-overflow::-webkit-scrollbar{
                display: none;
            }
        </style>
    </head>

    <body class="auth custom-overflow">
        <main class="d-flex w-100">
            <div class="container d-flex flex-column">
                <div class="row vh-100">
                    <div class="col-sm-6 mx-auto d-table h-100">
                        <div class="d-table-cell align-middle">
                            <div class="text-center text-white mt-4">
                                <div>
                                    <img src="{{$systemSetting['logo']}}" alt="{{$systemSetting['siteName']}}"
                                         class="img-fluid rounded-circle" width="132" height="132"/>
                                </div>
                                <p class="lead">
                                    {{$systemSetting['siteName']}}
                                </p>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="m-sm-4">
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input class="form-control form-control-lg @error('email') is-invalid @enderror "
                                                       id="email" type="email" name="email" placeholder="Enter your email"
                                                       required autocomplete="email" autofocus/>
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="mb-3 password-container">
                                                <label for="password" class="form-label">Password</label>
                                                <input class="form-control form-control-lg @error('password') is-invalid @enderror"
                                                       required id="password" type="password" name="password"
                                                       placeholder="Enter your password"/>
                                                <i class="fa-solid fa-eye" onclick="myFunction()" id="eye"></i>
                                                {{--                                        <br>--}}
                                                {{--                                        <input type="checkbox" onclick="myFunction()"> Show Password--}}
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <br>
                                                <br>
                                                <span>
                                                    <a href="{{ route('password.request') }}">Forgot password?</a>
                                                </span>
                                            </div>
                                            <div class="text-end mt-3">
                                                <button type="submit" class="btn rounded btn-success ">Sign in</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
<script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>
<script src="{{asset('asset/js/app.js')}}"></script>
@vite('resources/js/app.js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if ($errors->any())
        @foreach ($errors->all() as $error)
        toastr.error("{{ $error }}");
        @endforeach
        @endif
    });

    // function myFunction(){
    //     var x = document.getElementById("password");
    //     if(x.type === "password"){
    //         x.type = "text"
    //     }else{
    //         x.type = "password";
    //     }
    // }

    function myFunction() {
        let x = document.getElementById("password");
        console.log(123);
        let eye = document.getElementById("eye");
        console.log(456);
        if (x.type === "password") {
            eye.classList.remove("fa-eye")
            eye.classList.add("fa-eye-slash")
            x.type = "text"
        } else {
            eye.classList.remove("fa-eye-slash")
            eye.classList.add("fa-eye")
            x.type = "password"
        }
    }

    // eye.addEventListener("click", function(){
    //     console.log(789);
    //     this.classList.toggle("fa-eye-slash")
    //     const type = passwordInput.getAttribute("type") === "password" ? "text" : "password"
    //     passwordInput.setAttribute("type", type)
    // })

</script>
    </body>
</html>
</p>
</body>
</html>