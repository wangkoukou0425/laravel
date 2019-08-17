<?php


namespace App\Http\Controllers;


use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function index(){
    	$arr=Db::select("select * from goods");
    	// var_dump($arr);die;
    		return response()->json($arr);
    	
    }

    
    }
 

 
