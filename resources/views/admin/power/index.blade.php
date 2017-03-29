@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; <a href="#">用户管理</a> &raquo; 权限组
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post" class="layui-form">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/power/create')}}"><i class="fa fa-plus"></i>新增权限</a>
                    {{--<a href="#"><i class="fa fa-recycle"></i>批量删除</a>--}}
                    {{--<a href="javascript: location.href = location.href;"><i class="fa fa-refresh"></i>更新排序</a>--}}
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%">ID</th>
                        <th>组名称</th>
                        <th>组权限</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                        <tr >
                            <td class="tc">{{$v->role_id}}</td>
                            <td>
                                <a href="#">{{$v->role_name}}</a>
                            </td>
                            <td>
                                @if($v->role_menu!=0)
                                    @foreach($file as $m)
                                    {{--{{$v->role_menu}}--}}
                                        <?php
                                            $arr = explode(',',$v->role_menu);
                                            if(in_array($m->menu_id,$arr)){
                                            echo "[<i class='".$m->icon."'></i><span style='color:#01AAED'>".$m->menu_name."</span></li>]";// "[".$m->menu_name."]";
                                            }
                                        ?>

                                    @endforeach

                                @else
                                    <span style='color:#FF5722'>所有权限</span>
                                @endif
                            </td>
                            <td ><input type="checkbox" name="{{$v->role_id}}" @if($v->enable==1) checked @endif value="0" class="layui-btn-small" lay-skin="switch" lay-text="开启|关闭"></td>
                            <td>
                                <a href="{{url('admin/power/'.$v->role_id.'/edit')}}" class="layui-btn  layui-btn-radius layui-btn-small">修改</a>
                                <a href="javascript:;" onclick="delPower('{{$v->role_id}}')" class="layui-btn layui-btn-small layui-btn-radius layui-btn-danger">删除</a>
                            </td>
                        </tr>
                    @endforeach
                </table>


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
                    val =0;
                }
                $.post('{{url('admin/power/enable')}}',{'_token':"{{csrf_token()}}",'_method':'post','role_id':data.elem.name,'enable':val},function(data){
                    if(data.status==1){
                        layer.msg(data.msg,{icon:6});
                    }
                });


            });

        });


        function delPower(role_id){
            layui.use('layer',function(){
                var layer = layui.layer;
                layer.confirm('确定删除角色？', {
                    btn: ['确定', '取消']
                },function(){
                    $.post("{{url('admin/power/')}}/"+role_id,{'_token':"{{csrf_token()}}",'_method':'delete'},function(data){
                        if(data.status==0){
                            location.href = location.href;
                            layer.msg(data.msg,{icon:5});
                        }else{
                            layer.msg(data.msg,{icon:6});
                        }
                    });
                },function(){});
            });
        }


    </script>
@endsection