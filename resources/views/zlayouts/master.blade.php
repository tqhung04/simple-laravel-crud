<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>

    <title>@yield('title')</title>

    <link rel="icon" type="image/ico" href="favicon.ico"/>

    {{-- <link href="css/stylesheets.css" rel="stylesheet" type="text/css"/> --}}
    <link href="{{ asset('css/stylesheets.css') }}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/script.js') }}"></script>

</head>
<body>

<div class="header">
    <a class="logo" href="list-categories.html">
        <img src="{{ asset("img/logo.png") }}" alt="NTQ Solution - Admin Control Panel" title="NTQ Solution - Admin Control Panel"/>
    </a>
</div>

<div class="menu">

    <div class="breadLine">
        <div class="arrow"></div>
        <div class="adminControl active">
            Hello, {{ Auth::user()->username }}
        </div>
    </div>

    <div class="admin">
        <div class="image">
            <img src="{{ asset('upload/' . Auth::user()->image) }}" class="img-polaroid" width="50px" height="50px"/>
        </div>
        <ul class="control">
            <li><span class="icon-cog"></span> <a href="{{ url('admin/user/'. Auth::user()->id .'/edit') }}">Update Profile</a></li>
            {{-- <li><span class="icon-share-alt"></span> <a href="{{ action("LoginController@logout") }}">Logout</a></li> --}}
            <li><span class="icon-share-alt"></span> <a href="{{ route('logout') }}">Logout</a></li>
        </ul>
    </div>

    <ul class="navigation">
        <li>
            <a href="{{ url('admin/category') }}">
                <span class="isw-grid"></span><span class="text">Categories</span>
            </a>
        </li>
        <li>
            <a href="{{ url('admin/product') }}">
                <span class="isw-list"></span><span class="text">Products</span>
            </a>
        </li>
        <li>
            <a href="{{ url('admin/user') }}">
                <span class="isw-user"></span><span class="text">Users</span>
            </a>
        </li>
    </ul>
</div>

<div class="content">
    <div class="breadLine">
        <ul class="breadcrumb">
            @yield('breadline')
        </ul>
    </div>

    <div class="workplace">
        <div class="row-fluid">
            <div class="span12 search">
                @yield('search')
            </div>
        </div>

        @yield('content')

        <div class="dr"><span></span></div>

    </div>
</div>

</body>
</html>