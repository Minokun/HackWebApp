<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Menu;
use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

//引入验证码第三方类库
require('resources/org/code/Code.class.php') ;
//后台登录控制器
class LoginController extends CommonController
{
    public function login()
    {
        if($input = Input::all()){//判断有没有数据提交过来
            $code = new \Code;
            $_code = $code->get();
            if(strtoupper($input['code'])!=$_code){
                return back()->with('msg','验证码错误!');
            }
            $user = User::where('user_name',$input['user_name'])->first();//取到一个数据
            if($user->user_name != $input['user_name'] || Crypt::decrypt($user->user_pass)!=$input['user_pass']){
                return back()->with('msg','用户名或者密码错误!');
            }
            if($user->status==9){
                return back()->with('msg','用户禁止登录！');
            }
            //登录信息写入session
            session(['user'=>$user]);
            return redirect('admin/index');

        }else{
            return view('admin.login');
        }




    }

    /*
     * 生成验证码
     */
    public function code()
    {
        $code = new \Code();
        $code->make();
    }

    //登出
    public function quit()
    {
        session(['user'=>null]);
        return redirect('admin/login');
    }


}
