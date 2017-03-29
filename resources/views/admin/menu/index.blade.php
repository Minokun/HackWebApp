@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; <a href="#">用户管理</a> &raquo; 菜单
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/menu/create')}}"><i class="fa fa-plus"></i>新增菜单</a>
                    {{--<a href="#"><i class="fa fa-recycle"></i>批量删除</a>--}}
                    <a href="javascript: location.href = location.href;"><i class="fa fa-refresh"></i>更新排序</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%">排序</th>
                        <th class="tc" width="5%">ID</th>
                        <th>菜单名称</th>
                        <th>图标</th>
                        <th>url</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                        <tr>
                            <td class="tc">
                                <input type="text" name="ord[]" value="{{$v->menu_order}}" onchange="changeOrder(this,{{$v->menu_id}})"  >
                            </td>
                            <td class="tc">{{$v->menu_id}}</td>
                            <td>
                                <a href="#">{{$v->_menu_name}}</a>
                            </td>
                            <td>{{$v->icon}}</td>
                            <td>{{$v->url}}</td>

                            <td>
                                <a href="{{url('admin/menu/'.$v->menu_id.'/edit')}}" class="layui-btn  layui-btn-radius layui-btn-small">修改</a>
                                <a href="javascript:;" onclick="delMenu('{{$v->menu_id}}')" class="layui-btn layui-btn-small layui-btn-radius layui-btn-danger">删除</a>
                            </td>
                        </tr>
                    @endforeach
                </table>


            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
        function changeOrder(obj,menu_id){
            var cate_order = $(obj).val();
            $.post('{{url('admin/menu/changeOrder')}}',{'_token':'{{csrf_token()}}','_method':'post','menu_order':cate_order,'menu_id':menu_id},function(data){
                 layui.use('layer',function(){
                    var layer = layui.layer;
                    if(data.status==0){
                        layer.msg(data.msg,{icon:6});
                    }else{
                        layer.msg(data.msg,{icon:5});
                    }
                 });

            });

        }

        function delMenu(menu_id){
            layui.use('layer',function(){
                var layer = layui.layer;
                layer.confirm('确定删除菜单？', {
                    btn: ['确定', '取消']
                },function(){
                    $.post("{{url('admin/menu/')}}/"+menu_id,{'_token':"{{csrf_token()}}",'_method':'delete'},function(data){
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