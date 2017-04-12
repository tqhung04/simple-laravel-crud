@extends('zlayouts.master')

@section('title', 'User')

@section('breadline')
<li><a href="{{ url('admin/user') }}">List Users</a> <span class="divider">></span></li>
<li class="active">Update</li>
@stop

@section('content')

<div class="row-fluid">
            <div class="span12">
                <div class="head">
                    <div class="isw-grid"></div>
                    <h1>Users Management</h1>

                    <div class="clear"></div>
                </div>
                <div class="block-fluid">
                    {{-- {{ Form::model($user, array('route' => array('user.update', $user->id), 'method' => 'PUT')) }} --}}
                    {!! Form::open(['action' => ['UserController@update', $user->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'files'=>true]) !!}
                    {{-- {!! Form::open(['action' => 'UserController@update', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'files'=>true]) !!} --}}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row-form">
                            <div class="span3">Username:</div>
                            <div class="span9">
                                {{ Form::text('username', $user->username, array()) }}
                            </div>
                            <div class="clear"></div>
                        </div> 
                        <div class="row-form">
                            <div class="span3">Email:</div>
                            <div class="span9">{{ Form::text('email', $user->email, array('placeholder'=>'some text value...')) }}</div>
                            <div class="clear"></div>
                        </div> 
                        <div class="row-form">
                            <div class="span3">Password:</div>
                            <div class="span9">{{ Form::password('password', null, array('placeholder'=>'some text value...')) }}</div>
                            <div class="clear"></div>
                        </div> 
                        <div class="row-form">
                            <div class="span3">Upload Avatar:</div>
                            <div class="span9">
                                <img src="{{ asset("upload/$user->avatar") }}" alt="{{ $user->avatar }}" width="50px" height="50px">
                                {{ Form::file('avatar', null) }}
                            </div>
                            <div class="clear"></div>
                        </div> 
                        <div class="row-form">
                            <div class="span3">Activate:</div>
                            <div class="span9">
                                @if ( $user->status == 0 ) 
                                    {{ Form::select('status', ['0' => 'Active', '1' => 'Deactivate']) }}
                                @else
                                    {{ Form::select('status', ['1' => 'Deactive', '0' => 'Activate']) }}
                                @endif
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="row-form">
                            <div class="span3">{!! Form::submit('Update', array('class'=>'btn btn-success')) !!}</div>
                            <div class="span9">
                                @if (count($errors) > 0)
                                    <div class = "alert alert-danger">
                                    <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                    </ul>
                                    </div>
                                @endif
                            </div>
                            <div class="clear"></div>
                        </div>
                    {!! Form::close() !!}
                    <div class="clear"></div>
                </div>
            </div>
</div>

@stop