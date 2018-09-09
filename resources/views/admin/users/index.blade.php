@extends('layouts.admin')
@section('content')

    <h1>Users</h1>

    @if(Session::has('deleted_user'))
        <div class="alert alert-danger">
            {{session('deleted_user')}}
        </div>
    @endif
    @if($users->count()>0)
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Id</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Active</th>
            <th>Created At</th>
            <th>Updated At</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>@if($user->photo)<img height='50' src='{{$user->photo->file}}'>
                    @else
                        'no photo'
                @endif
                </td>

                <td><a href="{{route('admin.users.edit',$user->id)}}">{{$user->name}}</a></td>
                <td>{{$user->email}}</td>
                <td>{{$user->role->name}}</td>
                <td>{{($user->is_active ==1)?'Active':'Not Active'}}</td>
                <td>{{$user->created_at->diffForHumans()}}</td>
                <td>{{$user->updated_at->diffForHumans()}}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
    @else
        <h3>No users found</h3>
    @endif

@stop