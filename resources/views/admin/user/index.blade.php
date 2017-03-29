@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; <a href="#">用户管理</a>
    </div>
    <!--面包屑导航 结束-->

	<!--结果页快捷搜索框 开始-->
	{{--<div class="search_wrap">--}}
        {{--<form action="" method="post">--}}
            {{--<table class="search_tab">--}}
                {{--<tr>--}}
                    {{--<th width="120">选择分类:</th>--}}
                    {{--<td>--}}
                        {{--<select onchange="javascript:location.href=this.value;">--}}
                            {{--<option value="">全部</option>--}}
                            {{--<option value="http://www.baidu.com">百度</option>--}}
                            {{--<option value="http://www.sina.com">新浪</option>--}}
                        {{--</select>--}}
                    {{--</td>--}}
                    {{--<th width="70">关键字:</th>--}}
                    {{--<td><input type="text" name="keywords" placeholder="关键字"></td>--}}
                    {{--<td><input type="submit" name="sub" value="查询"></td>--}}
                {{--</tr>--}}
            {{--</table>--}}
        {{--</form>--}}
    {{--</div>--}}
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post" class="layui-form">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/user/create')}}"><i class="fa fa-plus"></i>添加用户</a>
                    {{--<a href="#"><i class="fa fa-recycle"></i>批量删除</a>--}}
                    {{--<a href="#"><i class="fa fa-refresh"></i>更新排序</a>--}}
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">ID</th>
                        <th class="tc">角色组</th>
                        <th>用户名</th>
                        <th>密码</th>
                        <th>姓名</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">{{$v->user_id}}</td>
                        <td class="tc">
                            {{$arr[$v->role]}}
                        </td>
                        <td class="tc">{{$v->user_name}}</td>
                        <td style="background-color:#e2e2e2"><a href="javascript:;" onclick="showPass({{$v->user_id}});" style="color:#009688">点击显示密码</a></td>
                        <td class="tc">{{$v->root_name}}</td>
                        <td>
                            <input type="checkbox" name="{{$v->user_id}}" @if($v->status==1) checked @endif value="9" class="layui-btn-small" lay-skin="switch" lay-text="开启|关闭">
                        </td>
                        <td>
                            <a href="{{url('admin/user/'.$v->user_id.'/edit')}}" class="layui-btn  layui-btn-radius layui-btn-small">修改</a>
                            <a href="javascript:;" onclick="delUser('{{$v->user_id}}')" class="layui-btn layui-btn-small layui-btn-radius layui-btn-danger">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>


{{--<div class="page_nav">--}}
{{--<div>--}}
{{--<a class="first" href="/wysls/index.php/Admin/Tag/index/p/1.html">第一页</a> --}}
{{--<a class="prev" href="/wysls/index.php/Admin/Tag/index/p/7.html">上一页</a> --}}
{{--<a class="num" href="/wysls/index.php/Admin/Tag/index/p/6.html">6</a>--}}
{{--<a class="num" href="/wysls/index.php/Admin/Tag/index/p/7.html">7</a>--}}
{{--<span class="current">8</span>--}}
{{--<a class="num" href="/wysls/index.php/Admin/Tag/index/p/9.html">9</a>--}}
{{--<a class="num" href="/wysls/index.php/Admin/Tag/index/p/10.html">10</a> --}}
{{--<a class="next" href="/wysls/index.php/Admin/Tag/index/p/9.html">下一页</a> --}}
{{--<a class="end" href="/wysls/index.php/Admin/Tag/index/p/11.html">最后一页</a> --}}
{{--<span class="rows">11 条记录</span>--}}
{{--</div>--}}
{{--</div>--}}

                {{--<div class="page_list">--}}
                    {{--<ul>--}}
                        {{--<li class="disabled"><a href="#">&laquo;</a></li>--}}
                        {{--<li class="active"><a href="#">1</a></li>--}}
                        {{--<li><a href="#">2</a></li>--}}
                        {{--<li><a href="#">3</a></li>--}}
                        {{--<li><a href="#">4</a></li>--}}
                        {{--<li><a href="#">5</a></li>--}}
                        {{--<li><a href="#">&raquo;</a></li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
        layui.use('form', function(){
            var form = layui.form();
            form.on('switch', function(data){
                var val;
                if(data.elem.checked){
                    val =1;
                }else{
                    val =9;
                }
                $.post('{{url('admin/user/enable')}}',{'_token':"{{csrf_token()}}",'_method':'post','user_id':data.elem.name,'status':val},function(data){
                    if(data.status==1){
                        layer.msg(data.msg,{icon:6});
                    }
                });


            });

        });

        //删除用户
        function delUser(user_id){
            layui.use('layer',function(){
                var layer = layui.layer;
                layer.confirm('确定删除用户？', {
                    btn: ['确定', '取消']
                },function(){
                    $.post("{{url('admin/user/')}}/"+user_id,{'_method':'delete','_token':"{{csrf_token()}}"},function(data){
                        if(data.status==0){
                            location.href=location.href;
                            layer.msg(data.msg,{icon:6});
                        }else{
                            layer.msg(data.msg,{icon:5});
                        }
                    });
                },function(){

                });
            });
        }

        function showPass(user_id){
            $.post('{{url('admin/user/showPass')}}',{"_token":"{{csrf_token()}}","id":user_id},function(data){
                layer.alert(data, {
                    skin: 'layui-layer-lan' //样式类名
                    ,closeBtn: 2
                    ,anim: 5 //动画类型
                });
            });

        }

    </script>
@endsection