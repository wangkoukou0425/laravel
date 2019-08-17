<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Member_AddressController extends Controller
{
  public function __construct()
    {
       $this->middleware('auth:api', ['except' => ['']]);
        //构造函数，过滤login
    } 
  public function member_address(Request $request)
    {
     $request=$request->input();
     $p_id=$request['p_id'];
     $arr=DB::select("select * from area where parent_id='$p_id'");
     return response()->json($arr);
    }

  public function address(Request $request)
    {
      $request=$request->input();
      $name=$request['name'];
      $address=$request['address'];
      $phone=$request['phone'];
      $email=$request['email'];
      $phone_d=$request['phone_d'];
      $code=$request['code'];
      $arr=Db::table('address')->insert(['address'=>$address,'phone'=>$phone,'email'=>$email,'code'=>$code,'name'=>$name,'phone_d'=>$phone_d]);

       return response()->json([
            'code' => 200,
            'status' => 'ok',
            'data' =>'添加成功' ,
          
        ]);
    }

      public function show()
    {
      $arr=DB::select("select * from address");
       return response()->json($arr);
    }

}