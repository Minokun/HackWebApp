<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table  ='menu';
    protected $primaryKey = 'menu_id';
    public $timestamps = false;
    protected $guarded = [];


    public function get_menu()
    {
        $field = $this->orderBy('menu_order','asc')->get();
        $data = $this->tree($field);

        return $data;
    }


    public function tree($data,$pid=0,&$arr=array(),$n=0)
    {
        $str = "";
        for($i=0;$i<$n;$i++){
            $str.="&nbsp;";
        }
        $n+=10;

        foreach($data as $v){
            if($v->pid==$pid){
                $arr[] = $v;
                $v['_menu_name'] =$str.'|--'. $v['menu_name'];
                $this->tree($data,$v->menu_id,$arr,$n);
            }
        }

        return $arr;
    }

    public function get_menu_tree()
    {
        $field = $this->orderBy('menu_order','asc')->get();
        $data = $this->formatTree($field);

        return $data;

    }

    function formatTree($array, $pid = 0, &$arr=array()){
        foreach ($array as $v) {
            if ($v->pid == $pid) {
                $tem = $this->formatTree($array, $v->menu_id);
                //判断是否存在子数组
                $tem && $v['_children'] = $tem;
                $arr[] = $v;
            }
        }
        return $arr;
    }

}
