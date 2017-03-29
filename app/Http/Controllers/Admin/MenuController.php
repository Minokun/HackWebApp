<?php

namespace App\Http\Controllers\admin;

use App\Http\Model\Menu;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\InputOption;

//菜单控制器
class MenuController extends CommonController
{
    /**
     *菜单显示首页
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = (new Menu())->get_menu();
        return view('admin.menu.index',compact('data'));
    }

    public function changeOrder()
    {
        $input = Input::except('_token','_method');
        $filed = Menu::find($input['menu_id']);
        $filed->menu_order = $input['menu_order'];
        $re =  $filed->update();
       if($re){
           $data = [
               'status'=>0,
               'msg'=>'排序更新成功！'
           ];
       }else{
           $data = [
               'status'=>1,
               'msg'=>'排序更新失败，请稍后重试！'
           ];
       };
        return $data;
    }

    /**
     * 增加菜单
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = (new Menu)->get_menu();
        return view('admin.menu.add',compact('data'));
    }

    /**
     * 增加菜单提交
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $input = Input::except('_token');
        $rule=[
            'menu_name' => 'required',
        ];
        $message = [
            'menu_name.required'=>'名称不能为空！',
        ];

        $val = Validator::make($input,$rule,$message);
        if($val->passes()){
            $re = Menu::create($input);
            if($re){
                return redirect('admin/menu');
            }else{
                return back()->with('errors','添加失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($val);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 修改菜单
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = (new Menu())->get_menu();
        $filed = Menu::find($id);
        return view('admin.menu.edit',compact('data','filed'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $input = Input::except('_token','_method');
        $rule=[
            'menu_name' => 'required',
        ];
        $message = [
            'menu_name.required'=>'名称不能为空！',
        ];

        $val = Validator::make($input,$rule,$message);
        if($val->passes()){
           $re = Menu::where('menu_id',$id)->update($input);
            if($re){
                return redirect('admin/menu');
            }else{
                return back()->with('errors','更新失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($val);
        }

    }

    /**
     *删除菜单
     *delete admin/menu/{menu}
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $parent = Menu::find($id);
        Menu::where('pid',$id)->update(['pid'=>$parent->pid]);
        $re = Menu::where('menu_id',$id)->delete();
        if($re){
            $data = [
                'status'=>0,
                'msg'=>'删除成功！'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'删除失败,请稍后重试！'
            ];
        }
       return $data;
    }
}
