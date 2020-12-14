<?php namespace App\Models\Products;

use App\Models\Base;

class Categories extends Base
{
    protected $table      = 'products_categories';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['parent_id', 'code','name','status'];

    protected $useTimestamps = false;
    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';    
    protected $deletedField  = 'date_delete';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}