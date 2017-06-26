@extends('app')

@section('content')
    @include('editor::head')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-offset-2" role="main">
                @if($errors->any())
                    <ul class="list-group">
                        @foreach($errors->all() as $error)
                            <li class="list-group-item list-group-item-danger">{{$error}}</li>
                        @endforeach
                    </ul>

                @endif
                {!! Form::model($discussion,['method' =>'PATCH','url' => 'discussions/'.$discussion->id]) !!}
                    @include('forum.form')
                <!---  Field --->
                {!! Form::submit('更新帖子',['class' =>'btn btn-primary pull-right']) !!}
                {!! Form::close() !!}
            </div>


        </div>
    </div>
@stop