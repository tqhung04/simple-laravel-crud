<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>

    <title>Login</title>

    <link rel="icon" type="image/ico" href="favicon.ico"/>

    {{-- <link href="css/stylesheets.css" rel="stylesheet" type="text/css"/> --}}
    <link href="{{ asset('css/stylesheets.css') }}" rel="stylesheet" type="text/css"/>
</head>
<body>
    
    <div class="loginBox">
        <div class="loginHead">
            <img src="{{ asset('img/logo.png') }}" alt="NTQ Solution Admin Control Panel" title="NTQ Solution Admin Control Panel"/>
        </div>
        <form class="form-horizontal" method="POST" action="/authenticate">
            {{-- {{ csrf_field() }} --}}
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="control-group">
                <label for="inputUsername">Username</label>
                <input type="text" id="inputUsername" name="username" required />
            </div>
            <div class="control-group">
                <label for="inputPassword">Password</label>
                <input type="password" id="inputPassword" name="password" required />
            </div>
            <div class="control-group" style="margin-bottom: 5px;">
                <label class="checkbox">
                    <input type="checkbox" name="cbRemember" id="cbRemember"> Remember me
                </label>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-block" name="btnLogin">Sign in</button>
            </div> 
        </form>
        @if (session('message'))
            <div class="alert alert-error" style="text-align: center">
                {{ session('message') }}
            </div>
        @endif
    </div>
</body>
</html>
