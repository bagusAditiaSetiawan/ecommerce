<?php namespace App\Controllers\Administrator\Products;
use App\Controllers\BaseController;
class Items extends BaseController
{
	public function index()
	{
		return view('administrator/products/items/index.phtml',[
			'title' => 'Product Items'
		]);
	}

	//--------------------------------------------------------------------

}
