<?php namespace App\Controllers\Administrator\Products;
use App\Controllers\BaseController;
class Categories extends BaseController
{
	public function index()
	{
		return view('administrator/products/categories/index.phtml');
	}

	//--------------------------------------------------------------------

}
