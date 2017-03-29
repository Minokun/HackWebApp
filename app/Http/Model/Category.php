<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table  ='category';
    protected $primaryKey = 'cate_id';
    public $timestamps = false;
    protected $guarded = [];

        //加static
//    public static function tree()
//    {
//        $categorys = Category::all();
//        return  (new Category)->get_tree($categorys);
//    }
    //不加static
    public  function tree()
    {
        $categorys = $this->orderBy('cate_order','asc')->get();
        return  $this->get_tree($categorys);
    }


    //递归 无限极分类(网上找)
//    function formatTree($array, $pid = 0){
//        $arr = array();
//        foreach ($array as $v) {
//            if ($v->cate_pid == $pid) {
//                $tem = $this->formatTree($array, $v->cate_id);
//                //判断是否存在子数组
//                $tem && $v['son'] = $tem;
//                $arr[] = $v;
//            }
//        }
//        return $arr;
//    }

    //递归 无限极分类(自写）
    public function get_tree($arr,$pid=0,&$result = array(),$n=0,$file_id='cate_id',$file_pid='cate_pid',$file_name ='cate_name')
    {
        $str = "";
        for($i=0;$i<$n;$i++){
            $str.="&nbsp;";
        }
        $n+=10;
        foreach($arr as $k=>$v){
            if($v->$file_pid == $pid){
                $v['_'.$file_name] = $str.'├─ '.$v[$file_name];
                $result[] = $v;
                $this->get_tree($arr,$v->$file_id,$result,$n,$file_id,$file_pid,$file_name);
            }
        }
        return $result;
    }



}
