<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/registerView.css')}}">
    <title>Document</title>
</head>

<body>

<x-navbar></x-navbar>


<div class="container" style="background-image: url('{{'img/bg-01.jpg'}}');">

    <div class="form-wrapper">
        <div class="form-container">
            <form action="/auth/register" method="Post">
                @csrf
                <h1 align="center">Register</h1>
                <div class="input-container">

                    <div class="input">
                        <label for="email">Email
                            <input id="email" name="email" type="email" required="required" value="{{old('email')}}">
                        </label>
                        @error('email')
                        <h3 class="registerError">{{$message}}</h3>
                        @enderror
                    </div>

                    <div class="input">
                        <label for="password">Password
                            <input id="password" type="password" name="password" required="required">
                        </label>
                        @error('password')
                        <h3 class="registerError">{{$message}}</h3>
                        @enderror
                    </div>

                    <div class="input">
                        <label for="confirm_password">Confirm password
                            <input id="confirm_password" type="password" name="password_confirmation" required="required">
                        </label>
                    </div>

                    <div>
                        <button class="loginButton">Login</button>
                    </div>
                </div>
            </form>
        </div>

    </div>

</div>


</body>

</html>
