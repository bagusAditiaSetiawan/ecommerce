<?php namespace App\Controllers\Api\v1\Products;

use  App\Controllers\Api\Middleware\Authentication;

class Categories extends Authentication
{
    protected $modelName = 'App\Models\Products\Categories';   

    public $fillSearch = [
        'name'    => 'name'
    ];
    
    // ...
}