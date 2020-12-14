<?php namespace App\Controllers\Administrator;
use App\Controllers\BaseController;
class Login extends BaseController
{
	public function index()
	{
		return view('administrator/login/index.phtml');
	}

	//--------------------------------------------------------------------

}
