<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Power;
use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

//用户控制器
class UserController extends CommonController
{

    /*
     *  POST                           | admin/user                     | admin.user.store       | App\Http\Controllers\Admin\UserController@store           | web,admin.login |
|        | GET|HEAD                       | admin/user                     | admin.user.index       | App\Http\Controllers\Admin\UserController@index           | web,admin.login |
|        | GET|HEAD                       | admin/user/create              | admin.user.create      | App\Http\Controllers\Admin\UserController@create          | web,admin.login |
|        | POST                           | admin/user/enable              |                        | App\Http\Controllers\Admin\UserController@enable          | web,admin.login |
|        | GET|HEAD                       | admin/user/{user}              | admin.user.show        | App\Http\Controllers\Admin\UserController@show            | web,admin.login |
|        | PUT|PATCH                      | admin/user/{user}              | admin.user.update      | App\Http\Controllers\Admin\UserController@update          | web,admin.login |
|        | DELETE                         | admin/user/{user}              | admin.user.destroy     | App\Http\Controllers\Admin\UserController@destroy         | web,admin.login |
|        | GET|HEAD                       | admin/user/{user}/edit         | admin.user.edit        | App\Http\Controllers\Admin\UserController@edit            | web,admin.login
     */



    /**
     * 用户列表显示
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arr = array();
        $power = Power::all();
        foreach($power as $k=>$v){
            $arr[$k+1]=$v->role_name;
        }
        $data = User::orderby('role','asc')->get();
        return view('admin.user.index',compact('data','arr'));
    }

    //权限开关
    public function enable()
    {
        $input = Input::except('_token','_method');
        //更新权限
        $user = User::find($input['user_id']);
        $user->status = $input['status'];
        $re = $user->update();
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


        $role = Power::all();
        return view('admin.user.add',compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = Input::except('_token');

        $rule = [
            'user_name'=>'required',
        ];
        $message = [
            'user_name.required'=>'用户名不能为空！',
        ];

        $val = Validator::make($input,$rule,$message);
        if($val->passes()){
            //插入数据库
            if(empty($input['status'])){
                $input['status'] = 9;
            }
            $input['user_pass'] = Crypt::encrypt($input['user_pass']);
            $re = User::create($input);
            if($re){
                return redirect('admin/user');
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
        $role = Power::all();
        $file = User::find($id);
        return view('admin.user.edit',compact('role','file'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input  = Input::except('_token','_method');
        $rule = [
            'user_name'=>'required',
        ];
        $message = [
            'user_name.required'=>'用户名不能为空！',
        ];

        $val = Validator::make($input,$rule,$message);
        if($val->passes()){
            //插入数据库
            if(empty($input['status'])){
                $input['status'] = 9;
            }
            $input['user_pass'] = Crypt::encrypt($input['user_pass']);
            $re = User::where('user_id',$id)->update($input);
            if($re){
                return redirect('admin/user');
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
        $re = User::where('user_id',$id)->delete();
        if($re){
            $data = [
                'status'=>0,
                'msg'=>'删除成功！'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'删除失败，请稍后重试！'
            ];
        };
        return $data;
    }


    public function showPass()
    {
      $input = Input::except('_token');
      $file = User::find($input['id']);
        return Crypt::decrypt($file->user_pass);
    }
}
