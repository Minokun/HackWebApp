<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

//分类管理控制器
class CategoryController extends CommonController
{
    //get,admin/category  全部分类列表
    public function index()
    {
        //加static
//        $data = Category::tree();
        //不加static
        $data = (new Category())->tree();
        return view('admin.category.index')->with('data',$data);
    }


    public function changeOrder()
    {
      $input = Input::all();
        $cate = Category::find($input['cate_id']);
        $cate->cate_order = $input['cate_order'];
        $re = $cate->update();
        if($re){
            $data = [
                'status'=>0,
                'msg'=>'分类排序更新成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'分类排序更新失败'
            ];
        }
       return $data;
    }






    //get,admin/category/create   添加分类
    public function create()
    {
        $data = (new Category())->tree();
        return view('admin/category/add',compact('data'));
    }

    //post,admin/category  添加分类提交
    public function store()
    {
        $input = Input::except('_token');
        //验证
        $rules = [
            'cate_name'=>'required',
            ''
        ];

        $message = [
            'cate_name.required'=>'分类名称不能为空!',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            //写入数据库
           $re = Category::create($input);
           if($re){
               return redirect('admin/category');
           }else{
               return back()->withErrors('errors','数据添加失败，请稍后重试！');
           }
        }else{
            return back()->withErrors($validator);
        }
    }

    //GET,admin/category/{category}/edit  编辑分类
    public function edit($cate_id)
    {
        $field = Category::find($cate_id);
        $data = (new Category())->tree();
        return view('admin.category.edit',compact('field','data'));

    }


    //get, admin/category/{category}   显示单个分类信息
    public function show()
    {

    }

    // DELETE,admin/category/{category}  删除单个分类
    public function destroy($cate_id)
    {
        $pid = Category::find($cate_id);
        Category::where('cate_pid',$cate_id)->update(['cate_pid'=>$pid->cate_pid]);
        $re = Category::where('cate_id',$cate_id)->delete();
        if($re){
            $data = [
                'status'=>0,
                'msg'=>'分类删除成功！'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'分类删除失败，请稍后重试！'
            ];
        }
        return $data;

    }

    //PUT, admin/category/{category}  更新分类
    public function update($cate_id)
    {
        $input = Input::except('_token','_method');
        $rules = [
            'cate_name'=>'required',
        ];
        $message = [
            'cate_name.required'=>'分类名称不能为空!',
        ];

        $val = Validator::make($input,$rules,$message);
        if($val->passes()){
            $re = Category::where('cate_id',$cate_id)->update($input);
            if($re){
                return redirect('admin/category');
            }else{
                return back()->withErrors('errors','分类更新失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($val);
        }





    }

}
