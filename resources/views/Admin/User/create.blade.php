@extends('zlayouts.master')

@section('title', 'User')

@section('breadline')
<li><a href="{{ url('admin/user') }}">List Users</a> <span class="divider">></span></li>
<li class="active">Add</li>
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
                    {!! Form::open(['action' => 'UserController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'files'=>true]) !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row-form">
                            <div class="span3">Username:</div>
                            <div class="span9">
                                {{ Form::text('username', null, array('placeholder'=>'some text value...')) }}
                            </div>
                            <div class="clear"></div>
                        </div> 
                        <div class="row-form">
                            <div class="span3">Email:</div>
                            <div class="span9">{{ Form::text('email', null, array('placeholder'=>'some text value...')) }}</div>
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
                                <input type="file" name="image" onchange="showImageWhileUploading(this)">
                                <img id="blah" src="#" alt="your image" width="50px" height="50px"/>
                            </div>
                            <div class="clear"></div>
                        </div> 
                        <div class="row-form">
                            <div class="span3">Activate:</div>
                            <div class="span9">
                                {{ Form::select('status', ['0' => 'Active', '1' => 'Deactivate']) }}
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="row-form">
                            <div class="span3">{!! Form::submit('Create', array('class'=>'btn btn-success')) !!}</div>
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

<script type="text/javascript">

        $('#blah').attr('src', '/upload/userImages/user_default.jpg');

        function showImageWhileUploading(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah').attr('style', 'display:block');
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

@stop