<?php namespace App\Models\Products;

use App\Models\Base;

class Items extends Base
{
    protected $table      = 'products_items';

    public $path = 'storage/products/items/';

    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id_product_category', 'slugs','id_currency','name','price_purchase','price_sale','description','image','status'];

    protected $useTimestamps = false;
    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';    
    protected $deletedField  = 'date_delete';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}