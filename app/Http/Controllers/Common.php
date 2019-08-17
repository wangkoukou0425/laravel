<?php
namespace App\Http\Controller;

use Illuminate\Routing\Controller

class Common extends Controller
{
	public function __construct()
	{
		parent:: __construct();
		$name=Session::get('name');
		if (empty($name)) { 
			$this->redirect('login/login');
		}else{
			$this->assign('name',$name);
		}
	}
}
