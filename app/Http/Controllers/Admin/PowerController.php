<?php

namespace App\Http\Controllers\admin;

use App\Http\Model\Menu;
use App\Http\Model\Power;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

//权限分组控制器
class PowerController extends CommonController
{


    /*
     *      POST                               | admin/power                    | admin.power.store
 |        | GET|HEAD                       | admin/power                    | admin.power.index
 |        | GET|HEAD                       | admin/power/create             | admin.power.create
 |        | DELETE                         | admin/power/{power}            | admin.power.destroy
 |        | PUT|PATCH                      | admin/power/{power}            | admin.power.update
 |        | GET|HEAD                       | admin/power/{power}            | admin.power.show
 |        | GET|HEAD                       | admin/power/{power}/edit       | admin.power.edit

     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Power::all();
        $file = Menu::all();
        return view('admin.power.index',compact('data','file'));
    }
    //权限开关
    public function enable()
    {
        $input = Input::except('_token','_method');
        //更新权限
       $menu = Power::find($input['role_id']);
        $menu->enable = $input['enable'];
       $re = $menu->update();
        if($re){
            $data = [
                'status'=>0,
                'msg' =>'操作成功！'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg' =>'操作失败，请稍后重试!'
            ];
        }
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = (new Menu())->get_menu_tree();
        return view('admin.power.add',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $input = Input::except('_token');

        $rule = [
            'role_name'=>'required',
        ];
        $message = [
            'role_name.required'=>'名称不能为空！',
        ];
        $val = Validator::make($input,$rule,$message);
        if($val->passes()){
            $re = Power::create($input);
            if($re){
                    return redirect('admin/power');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $file = Power::find($id);
        $data = (new Menu)->get_menu_tree();
        $str = $file->role_menu;
        $arr = explode(',',$str);


        return view('admin.power.edit',compact('data','file','arr'));
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
        if(empty($input['enable'])){
            $input['enable']=0;
        }else{
            $input['enable']=1;
        }

        $rule = [
            'role_name'=>'required',
        ];
        $message = [
            'role_name.required'=>'名称不能为空！',
        ];
        $val = Validator::make($input,$rule,$message);

        if($val->passes()){

            $re = Power::where('role_id',$id)->update($input);
            if($re){
                session(['tree'=>(new Menu())->get_menu_tree()]);
                return redirect('admin/power');
            }else{
                return back()->with('errors','更新失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($val);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $re = Power::where('role_id',$id)->delete();
        if($re){
            $data = [
                'status'=>0,
                'msg'=>'删除成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'删除失败，请稍后重试！'
            ];
        };

        return $data;
    }
}
