@extends('layouts.admin')
@section('content')
{{--    {{dd(session('tree'))}}--}}
    <!--头部 开始-->
    <div class="top_box">
        <div class="top_left">
            <div class="logo">后台管理模板</div>
            <ul>
                <li><a href="{{url('/')}}" class="active">首页</a></li>
                <li><a href="#">管理页</a></li>
            </ul>
        </div>
        <div class="top_right">
            <ul>
                <li>用户：{{session('user')->root_name}}</li>
                <li><a href="{{url('admin/pass')}}" target="main">修改密码</a></li>
                <li><a href="{{url('admin/quit')}}">退出</a></li>
            </ul>
        </div>
    </div>
    <!--头部 结束-->

    <!--左侧导航 开始-->


    <div class="menu_box">
        <ul>


            <?php
                foreach($tree as $v){
                 ?>
{{--            @foreach($tree as $v)--}}
            <li>
                <h3><i class="{{$v->icon}}"></i>{{$v->menu_name}}</h3>
                <ul class="sub_menu">
                    @if(!empty($v->_children))
                        @foreach($v->_children as $m)
                            @if($arr!=0)
                                @if(in_array($m->menu_id,$arr))

                    <li><a href="{{url($m->url)}}" target="main"><i class="{{$m->icon}}"></i>{{$m->menu_name}}</a></li>
                                @endif
                            @else
                                <li><a href="{{url($m->url)}}" target="main"><i class="{{$m->icon}}"></i>{{$m->menu_name}}</a></li>
                            @endif
                        @endforeach
                    {{--<li><a href="tab.html" target="main"><i class="fa fa-fw fa-list-alt"></i>tab页</a></li>--}}
                    {{--<li><a href="img.html" target="main"><i class="fa fa-fw fa-image"></i>图片列表</a></li>--}}
                    @endif
                </ul>
            </li>
            {{--@endforeach--}}
            <?php
                }
            ?>



            {{--@endforeach--}}




            {{--<li>--}}
                {{--<h3><i class="fa fa-fw fa-group"></i>用户管理</h3>--}}
                {{--<ul class="sub_menu">--}}
                    {{--<li><a href="{{url('admin/user')}}" target="main"><i class="fa fa-fw fa-user"></i>用户</a></li>--}}
                    {{--<li><a href="{{url('admin/power')}}" target="main"><i class="fa fa-fw fa-th"></i>权限</a></li>--}}
                    {{--<li><a href="{{url('admin/menu')}}" target="main"><i class="fa fa-fw  fa-list-ol"></i>菜单</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<h3><i class="fa fa-fw fa-cog"></i>系统设置</h3>--}}
                {{--<ul class="sub_menu">--}}
                    {{--<li><a href="#" target="main"><i class="fa fa-fw fa-cubes"></i>网站配置</a></li>--}}
                    {{--<li><a href="#" target="main"><i class="fa fa-fw fa-database"></i>备份还原</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<h3><i class="fa fa-fw fa-thumb-tack"></i>工具导航</h3>--}}
                {{--<ul class="sub_menu">--}}
                    {{--<li><a href="http://www.yeahzan.com/fa/facss.html" target="main"><i class="fa fa-fw fa-font"></i>图标调用</a></li>--}}
                    {{--<li><a href="http://hemin.cn/jq/cheatsheet.html" target="main"><i class="fa fa-fw fa-chain"></i>Jquery手册</a></li>--}}
                    {{--<li><a href="http://tool.c7sky.com/webcolor/" target="main"><i class="fa fa-fw fa-tachometer"></i>配色板</a></li>--}}
                    {{--<li><a href="element.html" target="main"><i class="fa fa-fw fa-tags"></i>其他组件</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
        </ul>
    </div>
    <!--左侧导航 结束-->

    <!--主体部分 开始-->
    <div class="main_box">
        <iframe src="{{url('admin/info')}}" frameborder="0" width="100%" height="100%" name="main"></iframe>
    </div>
    <!--主体部分 结束-->

    <!--底部 开始-->
    <div class="bottom_box">
        CopyRight © 2015. Powered By <a href="http://www.houdunwang.com">http://www.houdunwang.com</a>.
    </div>
    <!--底部 结束-->

    <script>
        layui.use('element', function(){
            var element = layui.element();

            //一些事件监听
            element.on('tab(demo)', function(data){
                console.log(data);
            });
        });

    </script>

    @endsection

