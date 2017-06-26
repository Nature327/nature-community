<!DOCTYPE html>

<html lang="en">
<head>

    <meta charset="utf-8">
    <title>Nature App</title>
    <script src="{{asset('/js/jquery-2.1.4.min.js')}}"></script>
    {{--<script src="{{asset('/js/jquery-1.10.2.js')}}"></script>--}}
    <script src="{{asset('/js/jquery.form.js')}}"></script>
    <script src="{{asset('/js/bootstrap.js')}}"></script>
    <script src="{{asset('/js/jquery.Jcrop.min.js')}}"></script>
    <link href="{{asset('/css/bootstrap.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/bootstrap-theme.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/font-awesome.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/style.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/jquery.Jcrop.css')}}" rel="stylesheet" type="text/css">

</head>

<body>
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{url('/')}}">Nature app</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="{{url('/')}}">首页</a></li>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if(Auth::check())
                    <li class="dropdown">
                        <a class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            {{Auth::user()->name}}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                        <li><a href="{{asset('user/avatar')}}"> <i class="fa fa-user"></i> 更换头像</a></li>
                        <li><a href="{{asset('user/modify')}}"> <i class="fa fa-cog"></i> 修改密码</a></li>
                        <li role="separator" class="divider"></li>
                        <li> <a href="{{url('logout')}}">  <i class="fa fa-sign-out"></i> 退出登录</a></li>
                        </ul>
                    </li>
                    <li><img src="{{asset(Auth::user()->avatar)}}" class="img-circle" width="50"></li>

                @else
                    <li><a href="{{url('user/login')}}">登录</a></li>
                <li><a href="{{url('user/register')}}">注册</a></li>
                @endif
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
@yield('content')
</body>
{{--<script src="//cdn.bootcss.com/jquery/3.0.0-alpha1/jquery.min.js"></script>--}}
{{--<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>--}}
</html>