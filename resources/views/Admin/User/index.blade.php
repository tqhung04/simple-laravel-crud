@extends('zlayouts.master')

@section('title', 'User')

@section('breadline')
    <li><a href="{{ url('user') }}">List Users</a></li>
@stop

@section('content')
    <div class="row-fluid">

        <div class="span12">

            <div class="head">
                <div class="isw-grid"></div>
                <h1>Users Management</h1>

                <div class="clear"></div>
            </div>

            <div class="block-fluid table-sorting">
                <a href="{{ url('admin/user/create') }}" class="btn btn-add">Add User</a>
                <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable_2">
                    <thead>
                    <tr>
                        <th><input type="checkbox" id="checkAll"/></th>
                        <th width="15%" class="sorting"><a href="#">ID</a></th>
                        <th width="35%" class="sorting"><a href="#">Username</a></th>
                        <th width="20%" class="sorting"><a href="#">Activate</a></th>
                        <th width="10%" class="sorting"><a href="#">Time Created</a></th>
                        <th width="10%" class="sorting"><a href="#">Time Updated</a></th>
                        <th width="10%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $indexKey => $user)
                    <tr>
                        <td><input type="checkbox" name="checkbox"/></td>
                        <td>{{ $indexKey }}</td>
                        <td>{{ $user->username }}</td>
                        <td><span class="text-success">Activated</span></td>
                        <td>15:00 05/10/2014</td>
                        <td>15:00 05/10/2014</td>
                        <td><a href="edit-user.html" class="btn btn-info">Edit</a></td>
                    </tr>
                    @endforeach

                    </tbody>
                </table>

                <div class="bulk-action">
                    <a href="#" class="btn btn-success">Activate</a>
                    <a href="#" class="btn btn-danger">Delete</a>
                </div><!-- /bulk-action-->

                <div class="dataTables_paginate">
                    <a class="first paginate_button paginate_button_disabled" href="#">First</a>
                    <a class="previous paginate_button paginate_button_disabled" href="#">Previous</a>
                    <span>
                        <a class="paginate_active" href="#">1</a>
                        <a class="paginate_button" href="#">2</a>
                    </span>
                    <a class="next paginate_button" href="#">Next</a>
                    <a class="last paginate_button" href="#">Last</a>
                </div>
                
                <div class="clear"></div>
            </div>
        </div>

    </div>
@stop