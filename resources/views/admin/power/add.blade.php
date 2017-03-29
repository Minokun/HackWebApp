@extends('layouts.admin')
@section('content')
    <style>
        #sp span{margin-left: 0px}
    </style>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; <a href="#">用户管理</a> &raquo; 权限添加
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
            @if(count($errors))
            <div class="mark" >
                @if(is_object($errors))
                     @foreach($errors->all() as $error)
                        <p style="color:red;">{{$error}}</p>
                     @endforeach
                @else
                    {{$errors}}
                @endif
            </div>
            @endif

        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="#"><i class="fa fa-plus"></i>权限列表</a>
                {{--<a href="#"><i class="fa fa-recycle"></i>批量删除</a>--}}
                {{--<a href="#"><i class="fa fa-refresh"></i>更新排序</a>--}}
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/power')}}" method="post"  class="layui-form">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>权限组名称：</th>
                        <td>
                            <input type="text" class="sm" name="role_name">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>菜单权限：</th>
                        <td id="sp">

                            {{--<ul id="demo">--}}
                            {{--</ul>--}}
                            <ul id="tt" class="easyui-tree">
                            </ul>
                            <input type="hidden" name="role_menu" id="menu"/>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>是否启用：</th>
                        <td  >
                            <input type="checkbox" name="enable" checked value="1" lay-skin="switch" lay-text="开启|关闭">
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交" onclick="onc();">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <script>
        //Demo
        layui.use('form', function(){
            var form = layui.form();
        });


        $('#tt').tree({
            checkbox:true,
//            onlyLeafCheck:true,
//            lines:true,
            data: [
                @foreach($data as $k=>$v)
                {
                text: '{{$v->menu_name}}',
                id:'{{$v->menu_id}}',
                state: 'open',


                    @if(is_array($data[$k]['_children']))
                children: [
                @foreach($data[$k]['_children'] as $v)
                    {
                    id:'{{$v->menu_id}}',
                    text: '{{$v->menu_name}}'

                },
                @endforeach
                ]
                    @endif
            },
                @endforeach
            ]
        });
        function onc(){
            var nodes = $('#tt').tree('getChecked');
            var s = '';
            for(var i=0; i<nodes.length; i++){
                if (s != '') s += ',';
                s += nodes[i].id;
            }
            $("#menu").val(s);
        }



    </script>
@endsection