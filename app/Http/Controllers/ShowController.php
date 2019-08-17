<?php


namespace App\Http\Controllers;


use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class ShowController extends Controller
{
    public function index(){
    	$arr=Db::select("select * from goods");
    	// var_dump($arr);die;
    		return response()->json($arr);
    	
    }

    public function tree()
    {
        $arr=Db::select("select * from category");
        $ayy=$this->cate_gory($arr,0,0);
       
        $json=['code'=>'200','status'=>'success','data'=>$ayy];
        return response()->json($ayy);
    }

    public function cate_gory($arr,$id,$level){
    	$list =array();
        foreach ($arr as $k=>$v){
            if ($v->parent_id == $id){
            $v->level=$level;
            $v->son = $this->cate_gory($arr,$v->cat_id,$level+1);
            $list[] = $v;
        }
    }
    return $list;
    }

    public function floor()
    {
        $arr=Db::select("select g_f.id,g_f.name,g.goods_id,g.goods_name from goods_floor as g_f join floor_middle as f_m on g_f.id=f_m.goods_floor_id join goods as g on g.goods_id=f_m.goods_id");
        $array=array();
        foreach ($arr as $key => $value) {
            $array[$value->name][]=[$value->goods_name,$value->goods_id];
        }
        return response()->json($array);
    }

    public function goods(Request $request){

       $goods_id=request()->post('goods_id');
        $arr=Db::select("select g.goods_id as g_id,g.goods_name as g_name,a.name as a_name,a_d.name as a_dname,a_d.id as a_d_id from goods as g join goods_attr as g_a on g.goods_id=g_a.goods_id join attr_details as a_d on g_a.attr_details_id=a_d.id join attribute as a on g_a.attr_id=a.id where g.goods_id='$goods_id'");
        
            $data=[];
            foreach ($arr as $key => $value) {
              $data[$value->a_name][]=[$value->a_dname,$value->a_d_id];

            }
            $attr['name']=$value->g_name;
            $attr['data']=$data;
            return response()->json($attr);
        } 

    public function product(Request $request){
        $goods=request()->post();
        $goods_id=$goods['goods_id'];
        $a_id=$goods['id'];
        $a_id=substr($a_id,1);
        $arr=Db::select("select * from huopin_goods where goods_id='$goods_id'and goods_attr_id='$a_id'");
        return response()->json($arr);
    }
    }
 

 
