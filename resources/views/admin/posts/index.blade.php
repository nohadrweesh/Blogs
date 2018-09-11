@extends('layouts.admin')
@section('content')

    <h1>Posts</h1>


    @if($posts->count()>0)
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Body</th>
                <th>User</th>
                <th>Category</th>
                <th>Photo</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
            </thead>
            <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{$post->id}}</td>
                    <td><a href="{{route('admin.posts.edit',$post->id)}}">{{$post->title}}</a></td>

                    <td>{{$post->body}}</td>
                    <td>{{$post->user->name}}</td>
                    <td>{{$post->categorty_id}}</td>
                    <td>@if($post->photo)<img height='50' src='{{$post->photo->file}}'>
                        @else
                            'no photo'
                        @endif
                    </td>
                    <td>{{$post->created_at->diffForHumans()}}</td>
                    <td>{{$post->updated_at->diffForHumans()}}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
    @else
        <h3>No Posts found</h3>
    @endif

@stop