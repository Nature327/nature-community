@extends('app')
@section('content')
    <div class="jumbotron">

        <div class="container">
            <div class="media">
                <div class="media-left">
                    <a href="#">
                        <img src="{{asset($discussion->user->avatar)}}" alt="64*64" class="media-object img-circle" style="width: 64px ;height: 64px">
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading">{{$discussion->title}}</h4>
                    {{$discussion->user->name}}
                    @if(Auth::check() && Auth::user()->id==$discussion->user_id)
                    <a class="btn btn-primary btn-lg pull-right" href="{{url('discussions/'.$discussion->id.'/edit')}}" role="button">修改帖子</a>
                    @endif
                </div>

            </div>

        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-9" role="main">
                <div class="blog-post">
                    {!! $html !!}
                </div>
            <hr>
            @foreach($discussion->comments as $comment)
                 <div class="media">
                       <div class="media-left">
                          <a href="#">
                             <img src="{{asset($comment->user->avatar)}}" alt="64*64" class="media-object img-circle" style="width: 64px ;height: 64px">
                           </a>
                        </div>
                        <div class="media-body">
                             <h4 class="media-heading">{{$comment->user->name}}</h4>
                            {{$comment->body}}
                        </div>
                 </div>
                    <hr>
            @endforeach

                @if(Auth::check())
                {!! Form::open(['url' => 'comments']) !!}
                {!! Form::hidden('discussion_id',$discussion->id) !!}

            <!--- Body Field --->
                    <div class="form-group">
                        {!! Form::textarea('body', null, ['class' => 'form-control']) !!}
                    </div>
                    <!--- 提交评论 Field --->
                    {!! Form::submit('发表评论',['class' =>'btn btn-success pull-right']) !!}

                {!! Form::close() !!}
                @else
                    <a href="{{url('user/login')}}" class="btn btn-success pull-right">登录参与评论</a>
                @endif
            </div>
        </div>
    </div>
@stop