<?php namespace App\Controllers\Administrator;
use App\Controllers\BaseController;
class Dashboard extends BaseController
{
	public function index()
	{
		return view('administrator/dashboard/index.phtml',[
			'title'	=> 'Dashboard'
		]);
	}

	//--------------------------------------------------------------------

}
