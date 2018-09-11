@extends('layouts.admin')
@section('content')
    <h1>Categories</h1>
    <div class="col-sm-6">
        {!! Form::open(['method'=>'POST','action'=>'AdminCategoriesController@store']) !!}
            <div class="form-group">
                {!! Form::label('name','Category:')!!}
                {!! Form::text('name',null,['class'=>'form-control'])!!}
            </div>
            <div class="form-group">

                {!! Form::submit('Create Category',['class'=>'btn btn-primary'])!!}
            </div>
        {!! Form::close() !!}

    </div>
    <div class="col-sm-6">
    @if($categories->count()>0)
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{$category->id}}</td>

                    <td><a href="{{route('admin.categories.edit',$category->id)}}">{{$category->name}}</a></td>

                    <td>{{$category->created_at->diffForHumans()}}</td>
                    <td>{{$category->updated_at->diffForHumans()}}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
    @else
        <h3>No categories found</h3>
    @endif
    </div>


@stop