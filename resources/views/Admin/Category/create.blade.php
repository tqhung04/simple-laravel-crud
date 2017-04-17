@extends('zlayouts.master')

@section('title', 'Category')

@section('breadline')
<li><a href="{{ url('admin/category') }}">List Categories</a> <span class="divider">></span></li>
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
                    {!! Form::open(['action' => 'CategoryController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'files'=>true]) !!}
                        {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
                        <div class="row-form">
                            <div class="span3">Category name:</div>
                            <div class="span9">
                                {{ Form::text('name', null, array('placeholder'=>'some text value...')) }}
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

@stop