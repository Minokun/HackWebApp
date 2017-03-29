@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; <a href="#">分类管理</a> &raquo;全部分类
    </div>
    <!--面包屑导航 结束-->

	{{--<!--结果页快捷搜索框 开始-->--}}
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
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>分类管理</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/category/create')}}"><i class="fa fa-plus"></i>新增分类</a>
                    {{--<a href="#"><i class="fa fa-recycle"></i>批量删除</a>--}}
                    <a href="javascript:location.href=location.href;"><i class="fa fa-refresh"></i><i class="layui-icon">刷新排序</i>  </a>
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
                        <th>分类名称</th>
                        <th>标题</th>
                        <th>查看次数</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" name="ord[]" value="{{$v->cate_order}}" onchange="changeOrder(this,{{$v->cate_id}})"  >
                        </td>
                        <td class="tc">{{$v->cate_id}}</td>
                        <td>
                            <a href="#">{{$v->_cate_name}}</a>
                        </td>
                        <td>{{$v->cate_title}}</td>
                        <td>{{$v->cate_view}}</td>

                        <td>
                            <a href="{{url('admin/category/'.$v->cate_id.'/edit')}}" class="layui-btn  layui-btn-radius layui-btn-small">修改</a>
                            <a href="javascript:;" onclick="delCate('{{$v->cate_id}}')" class="layui-btn layui-btn-small layui-btn-radius layui-btn-danger">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>


            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->

    <script>
        function changeOrder(obj,cate_id){
            var cate_order=$(obj).val();
            $.post('{{url('admin/cate/changeOrder')}}',{'_token':'{{csrf_token()}}','cate_id':cate_id,'cate_order':cate_order},function(data){
                layui.use('layer', function(){
                    var layer = layui.layer;
                    if(data.status==0){
                        layer.msg(data.msg,{icon:6})
                    }else{
                        layer.msg(data.msg,{icon:5})
                    }

                });

            });
        }
        //删除分类
        function delCate(cate_id){
            layui.use('layer',function(){
                var layer = layui.layer;
                layer.confirm('确认删除分类？', {
                    btn: ['确定', '取消']
                },function(){
                    $.post("{{url('admin/category/')}}/"+cate_id,{'_method':'delete','_token':"{{csrf_token()}}"},function(data){
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


    </script>

@endsection