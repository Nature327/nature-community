@extends('app')
@section('content')
    <div class="jumbotron">
        <div class="container">
            <h2>欢迎来到Nature app社区
                <a class="btn btn-primary btn-lg pull-right" href="{{url('discussions/create')}}" role="button">发布新的帖子</a>
            </h2>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-9" role="main">
                @foreach($discussions as $discussion)
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img src="{{asset($discussion->user->avatar)}}" alt="" class="media-object img-circle" width="64">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">
                                <a href="{{url('discussions/'.$discussion->id)}}">{{$discussion->title}}</a>
                                <div class="media-conversation-meta">
                                    <span class="media-conversation-replies pull-right">
                                    <a href="/discussions/154#reply">{{ count($discussion->comments) }}</a>
                                        回复
                                    </span>
                                </div>
                            </h4>
                            {{$discussion->user->name}}
                        </div>
                    </div>
                    <hr>
                @endforeach
                    <div class="pull-right">
                        {!! $discussions->render() !!}
                    </div>
            </div>

        </div>

    </div>
@stop