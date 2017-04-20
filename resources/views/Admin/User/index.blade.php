@extends('Admin.zlayouts.index')

@section('title', 'User')

@section('breadline')
    <li><a href="{{ url('admin/user') }}">List Users</a></li>
@stop

@section('search')
    {{ Form::open(array('url' => 'admin/user/search', 'method' => 'get')) }}

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        {!! Form::text('search', null, array('required', 'class'=>'span11', 'placeholder'=>'Search for a user...')) !!}
        {!! Form::submit('Search', array('class'=>'btn btn-default')) !!}

    {{ Form::close() }}
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
                {{ Form::open(array('url' => 'admin/user/action', 'method' => 'POST' )) }}

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable_2">
                        <thead>
                        <tr>
                            <th><input type="checkbox" id="select_all"/></th>
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
                            <td><input type="checkbox" name="cb[{{ $user->id }}]"/></td>
                            <td>{{ $indexKey }}</td>
                            <td>{{ $user->username }}</td>
                            @if( $user->status == 0 )
                                <td><span class="text-success">Activated</span></td>
                            @else
                                <td><span class="text-error">Not actived</span></td>
                            @endif
                            <td>{{ $user->created_at }}</td>
                            <td>{{ $user->updated_at }}</td>
                            <td><a href="{{ url('admin/user/' . $user->id . '/edit') }}" class="btn btn-info">Edit</a></td>
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <div class="bulk-action">
                        <input class="btn btn-success" type="submit" name="active" value="Active">
                        <input class="btn btn-danger" type="submit" name="deactive" value="Deactive">
                    </div><!-- /bulk-action-->
                {{ Form::close() }}
                </form>
                    {{ $users->render() }}
                </div>
                
                <div class="clear"></div>
            </div>
        </div>

    </div>
@stop