@extends('Admin.zlayouts.index')

@section('title', 'User')

@section('breadline')
<li><a href="{{ url('admin/user') }}">List Users</a> <span class="divider">></span></li>
<li class="active">
    @if(isset($data))
        Update
    @else
        Create
    @endif
</li>
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
                    @if(isset($data->id))
                        {!! Form::open(['action' => ['Admin\UserController@update', $data->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'files'=>true]) !!}
                    @else
                        {!! Form::open(['action' => 'Admin\UserController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'files'=>true]) !!}
                    @endif
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row-form">
                            <div class="span3">Username:</div>
                            <div class="span9">
                                <input type="text" name="username" placeholder="some text value" value="@if(isset($data->username)){{ $data->username }}@else{{ old('username') }}@endif" required="true"/>
                                @if( $errors->first('username') )
                                    <div class = "alert alert-danger">
                                        {!! $errors->first('username') !!}
                                    </div>
                                @endif
                            </div>
                            <div class="clear"></div>
                        </div> 
                        <div class="row-form">
                            <div class="span3">Email:</div>
                            <div class="span9">
                                <input type="text" name="email" placeholder="some text value" value="@if(isset($data->email)){{ $data->email }}@else{{ old('email') }}@endif" required="true"/>
                                @if( $errors->first('email') )
                                    <div class = "alert alert-danger">
                                        {!! $errors->first('email') !!}
                                    </div>
                                @endif
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="row-form">
                            <div class="span3">Password:</div>
                            <div class="span9">
                                <input type="password" name="password" placeholder="some text value"/>
                                @if( $errors->first('password') )
                                    <div class = "alert alert-danger">
                                        {!! $errors->first('password') !!}
                                    </div>
                                @endif
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="row-form">
                            <div class="span3">Upload Avatar:</div>
                            <div class="span9">
                                <div id="file">
                                    <input type="file" name="image" id="upload_file" onchange="preview_image('one')" multiple="false"/>
                                    @if( $errors->first('image') )
                                        <div class = "alert alert-danger">
                                            {!! $errors->first('image') !!}
                                        </div>
                                    @endif
                                </div>
                                <div id="image_preview">
                                    @if(isset($data->image))
                                        <img src="{{ asset("upload/user/$data->image") }}" alt="{{ $data->image }}" width="50px" height="50px">
                                    @else
                                        <img src="{{ asset("upload/user/default.jpg") }}" alt="default" width="50px" height="50px">
                                    @endif
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                        @if( $isAdmin == 1 )
                            <div class="row-form">
                                <div class="span3">Role:</div>
                                <div class="span9">
                                    <select name="role" required="true">
                                        @if (isset($current_role))
                                            @foreach($current_role as $key => $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        @endif
                                        @foreach($roleList as $key => $role)
                                            <option value="{{ $key }}">{{ $role }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="clear"></div>
                            </div>
                        @endif
                        <div class="row-form">
                            <div class="span3">Activate:</div>
                            <div class="span9">
                                @if ( isset($data->status) && $data->status == 0 ) 
                                   <select name="status" required="true">
                                        <option value="0">Active</option>
                                        <option value="1">Deactivate</option>
                                    </select>
                                @else
                                    <select name="status" required="true">
                                        <option value="1">Deactive</option>
                                        <option value="0">Active</option>
                                    </select>
                                @endif
                                {{-- Error --}}
                                @if(Session::has('flash_message'))
                                    <div class="alert alert-{!! @Session::get('flash_level') !!}">
                                        {!! @Session::get('flash_message') !!}
                                    </div>
                                @endif
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="row-form">
                            <div class="span3">{!! Form::submit('Update', array('class'=>'btn btn-success')) !!}</div>
                            <div class="span9">
                            </div>
                            <div class="clear"></div>
                        </div>
                    {!! Form::close() !!}
                    <div class="clear"></div>
                </div>
            </div>
</div>

@stop