<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatController extends Controller
{
     public function __construct()
    {
       $this->middleware('auth:api', ['except' => ['']]);
        //构造函数，过滤login
    }


public function insert()
    {

         $name=auth()->user();
         $u_id=$name['id'];
         $goodsp_id=request()->post('goodsp_id');
         $attr_name=request()->post('details');
         $num=request()->post('num');
         $arr1=DB::select("select * from catr where g_id='$goodsp_id'");
         if (empty($arr1)) {
          $arr2=DB::insert("insert into catr (`u_id`,`g_id`,`number`,`attr_name`) values ('$u_id','$goodsp_id','$num','$attr_name')");
         }else{
           $arr=DB::update("update catr set number='$num' where g_id='$goodsp_id'");
         }
      return response()->json([
            'code' => 200,
            'status' => 'ok',
            'data' =>'添加成功' ,
          
        ]);
    }
    public function buycar()
    {
      $name=auth()->user();
      $u_id=$name['id'];
      // var_dump($u_id);die;
      $arr=Db::select("select catr.id,h.goods_id,h.price,catr.number,catr.attr_name,goods.goods_name from catr join huopin_goods as h on catr.g_id=h.id join goods on h.goods_id=goods.goods_id where u_id='$u_id'");
      return response()->json($arr);
    }

    public function greed(Request $request)
    {
      $number=request()->post('number');
      $id=request()->post('id');
      $name=auth()->user();
      $u_id=$name['id'];
      Db::update("update catr set number='$number' where u_id='$u_id' and g_id='$id'");
      return response()->json($id);
    }


    public function price(Request $request){
      $arr=$request->post('arr');
      // var_dump($arr);
      $price=0;
      foreach ($arr as $key => $value) {
        $ayy=Db::select("select catr.id,h.goods_id,h.price,catr.number,catr.attr_name,goods.goods_name from catr join huopin_goods as h on catr.g_id=h.id join goods on h.goods_id=goods.goods_id where catr.id=$value");
        // var_dump($ayy);
        $price+=$ayy[0]->number*$ayy[0]->price;
      }
      return response()->json($price);
    }
  }


