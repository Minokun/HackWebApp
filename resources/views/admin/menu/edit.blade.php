@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; <a href="#">商品管理</a> &raquo; 添加商品
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
                <a href="#"><i class="fa fa-plus"></i>菜单列表</a>
                {{--<a href="#"><i class="fa fa-recycle"></i>批量删除</a>--}}
                {{--<a href="#"><i class="fa fa-refresh"></i>更新排序</a>--}}
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/menu/'.$filed->menu_id)}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="PUT" />
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>父级菜单：</th>
                        <td>
                            <select name="pid">
                                <option value="0" >==顶级菜单==</option>
                                @foreach($data as $v)
                                    <option value="{{$v->menu_id}}" @if($filed->pid == $v->menu_id) selected @endif>{{$v->_menu_name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>名称：</th>
                        <td>
                            <input type="text" class="sm" name="menu_name" value="{{$filed->menu_name}}">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>图标：</th>
                        <td>
                            <input type="text" name="icon" class="lg" value="{{$filed->icon}}">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>URL：</th>
                        <td>
                            <input type="text" class="lg" name="url" value="{{$filed->url}}">
                        </td>
                    </tr>
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" name="menu_order" class="sm" value="0" {{$filed->menu_order}}>
                        </td>
                    </tr>

                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection