@extends('app')

@section('content')
<script>

    $(function () {
        $("#save").click(function () {
            var oldPwd = $("#oldPwd").val();
            var newPwd = $("#newPwd").val();
            var confirmPwd = $("#confirmPwd").val();

            if ($.trim(newPwd)!=$.trim(confirmPwd)){
                alert("两次输入的密码不一致");
            }else {
                var url ="{{url('updatePwd')}}";
                $.post(url,{oldPwd:oldPwd,newPwd:newPwd},function (data) {
                    var success = data.success;
                    if (success==2){
                        alert("修改成功!");
                        //重新登陆
                        location.reload();
                    }else if (success==1){
                        alert("操作失败！");
                    }else if (success==3){
                        alert("输入的旧密码不正确!");
                    }
                },'json');
            }
        });


    });
//    $(document).ready(function () {
//        var options = {
//            success: showResponse,
//            dataType: 'json'
//        };
//        $('#save').click(function () {
//            $('#form').ajaxForm(options).submit();
//        });
//    });
//
//    function showResponse(data) {
//        alert(data.success);
//    }
</script>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-lg-offset-3" role="main">
        {!! Form::open(['url' => 'updatePwd','id' => 'form']) !!}
        <!--- 旧密码 Field --->
            <div class="form-group">
                {!! Form::label('旧密码', '旧密码:') !!}
                {!! Form::text('旧密码', null, ['class' => 'form-control','id' => "oldPwd"]) !!}
            </div>

            <!--- 新密码 Field --->
            <div class="form-group">
                {!! Form::label('新密码', '新密码:') !!}
                {!! Form::text('新密码', null, ['class' => 'form-control','id' => "newPwd"]) !!}
            </div>

            <!--- 确认密码 Field --->
            <div class="form-group">
                {!! Form::label('确认密码', '确认密码:') !!}
                {!! Form::text('确认密码', null, ['class' => 'form-control','id' => "confirmPwd"]) !!}
            </div>

            <!--- 提交 Field --->
            {!! Form::button('保存',['class' =>'btn btn-primary pull-right','id' => 'save']) !!}

            {!! Form::close() !!}
            {{--<form class="form-horizontal tasi-form" method="post" action="{{url('updatepwd')}}" id="form">--}}
                {{--<div class="form-group">--}}
                    {{--<label class="col-sm-2 col-sm-2 control-label">旧密码</label>--}}
                    {{--<div class="col-sm-3">--}}
                        {{--<input type="text" class="form-control" name="oldPwd" id="oldPwd">--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                    {{--<label class="col-sm-2 col-sm-2 control-label">新密码</label>--}}
                    {{--<div class="col-sm-3">--}}
                        {{--<input type="text" class="form-control" name="newPwd" id="newPwd">--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="form-group">--}}
                    {{--<label class="col-sm-2 col-sm-2 control-label">重复密码</label>--}}
                    {{--<div class="col-sm-3">--}}
                        {{--<input type="text" class="form-control" name="confirmPwd" id="confirmPwd">--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                    {{--<label class="col-sm-2 col-sm-2 control-label"></label>--}}
                    {{--<div class="col-sm-10">--}}

                        {{--<button id="save" class="btn btn-shadow btn-success" type="button">提&nbsp;&nbsp;交</button>--}}

                    {{--</div>--}}
                {{--</div>--}}
            {{--</form>--}}
        </div>
    </div>
</div>


@stop