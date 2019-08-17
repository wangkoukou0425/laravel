<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Order_detailsController extends Controller
{
     public function __construct()
    {
       $this->middleware('auth:api', ['except' => ['']]);
        //构造函数，过滤login
    }
public function car_one(Request $request)
    {
      $arr=$request->input();
      //   return($arr);
      // die;
      $spid=$arr['id'];
      $array=[];
        foreach ($spid as $key => $value) {
          $arr=Db::select("select catr.id,catr.number,h.id as h_id,h.goods_attr_id as attr_name,goods.goods_name,goods.goods_id as g_id,h.price from goods join huopin_goods as h on goods.goods_id=h.goods_id join catr on h.id=catr.g_id where catr.id=$value");
          foreach ($arr as $key => $value1) {
           $array[]=$value1;
          }
        }
          return response()->json($array);
    }

    public function car_two(Request $request)
    {
      $arr=$request->input();
      $name=auth()->user();
      $id=$name['id'];
      $arr=Db::select("select * from address where id='$id'");
      return response()->json($arr);
    }

    public function add(Request $request){
      $arr=$request->input();
      $spid=$arr['id'];
      $name=auth()->user();
      $id=$name['id'];
    
      $array1=[];
      foreach ($spid as $key => $value) {
         $arr=Db::select("select catr.id,catr.number,h.id as h_id,h.goods_attr_id as attr_name,goods.goods_name,goods.goods_id as g_id,h.price from goods join huopin_goods as h on goods.goods_id=h.goods_id join catr on h.id=catr.g_id where catr.id=$value");
         foreach ($arr as $key1 => $value1) {
           $array1[]=$value1;
         }
      }
      date_default_timezone_set("PRC");
      $time=time();
      $date=date("Y-m-d H:i:s");
      var_dump($date);
      foreach ($array1 as $k1 => $v1) {
        $price=$v1->price;
        $attr_name=$v1->attr_name;
        $h_name=$v1->goods_name;
        $h_id=$v1->h_id;
        $number=$v1->number;
        $arr=DB::table('order_details')->insert(['price'=>$price,'h_type'=>$attr_name,'h_goods'=>$h_name,'h_id'=>$h_id,'number'=> $number,'order_id'=>$time]);

      }
      $arr=Db::select("select name,phone,address from address where id='$id'");
      $new_arr=[];
      foreach ($arr as $key => $value) {
        foreach ($value as $key1 => $value1) {
          $new_arr[]=$value1;
        }
      }
      $address=implode('-',$new_arr);
      $arr=Db::table('order')->insert(['time'=>$date,'status'=>1,'u_id'=>$id,'address'=>$address,'order_id'=>$time]);
      return response()->json($time);

  }
}


