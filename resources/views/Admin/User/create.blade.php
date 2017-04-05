@extends('zlayouts.master')

@section('title', 'User')

@section('breadline')
<li><a href="{{ url('user') }}">List Users</a> <span class="divider">></span></li>
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
                    <form>
                        <div class="row-form">
                            <div class="span3">Username:</div>
                            <div class="span9"><input type="text" placeholder="some text value..." name="username" /></div>
                            <div class="clear"></div>
                        </div> 
                        <div class="row-form">
                            <div class="span3">Email:</div>
                            <div class="span9"><input type="text" placeholder="some text value..." name="email" /></div>
                            <div class="clear"></div>
                        </div> 
                        <div class="row-form">
                            <div class="span3">Password:</div>
                            <div class="span9"><input type="text" placeholder="some text value..." name="password" /></div>
                            <div class="clear"></div>
                        </div> 
                        <div class="row-form">
                            <div class="span3">Upload Avatar:</div>
                            <div class="span9"><input type="file" name="avatar" size="19"></div>
                            <div class="clear"></div>
                        </div> 
                        <div class="row-form">
                            <div class="span3">Activate:</div>
                            <div class="span9">
                                <select name="selectStatus">
                                    <option value="0">choose a option...</option>
                                    <option value="1">Activate</option>
                                    <option value="2">Deactivate</option>
                                </select>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="row-form">
                            <button class="btn btn-success" type="submit" name="createUser">Create</button>
                            <div class="clear"></div>
                        </div>
                    </form>
                    <div class="clear"></div>
                </div>
            </div>

        </div>
@stop