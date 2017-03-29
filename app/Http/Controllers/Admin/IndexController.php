<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Menu;
use App\Http\Model\Power;
use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
//首页控制器
class IndexController extends CommonController
{
    public function index()
    {

        $tree = (new Menu())->get_menu_tree();
        $role = session('user')->role;
        $str = Power::find($role);
        if($str->role_menu==0){
            $arr = 0;
        }else{
            $arr = explode(',',$str);
        }

        //登录信息写入session
        return view('admin.index',compact('tree','arr'));
    }


    public function info()
    {
        return view('admin.info');
    }

    //修改超级管理员密码
    public function pass()
    {

        if($input  = Input::all()){
            $rules = [
                'password' => 'required|between:6,20|confirmed',
            ];
            $massage = [
                'password.required'=>'新密码不能为空！',
                'password.between'=>'新密码必须在6-20位之间！',
                'password.confirmed'=>'新密码和确认密码不一致！'
            ];
           $validator = Validator::make($input,$rules,$massage);//验证数据 、验证规则
            if($validator->passes()){
                $user = User::first();
                $_password = Crypt::decrypt($user->user_pass);
                if($input['password_o'] == $_password){
                    $user->user_pass = Crypt::encrypt($input['password']);
                    $user->update();
                    return back()->with('errors','密码修改成功！');
                }else{
                    return back()->with('errors','原密码错误！');
                }

            } else {

               return back()->withErrors($validator);

            }
            {
            }

        }else{
            return view('admin.pass');
        }



    }

}
