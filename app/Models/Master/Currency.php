<?php namespace App\Models\Master;

use App\Models\Base;

class Currency extends Base
{
    protected $table      = 'currency';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['code','name','status'];

    protected $useTimestamps = false;
    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';    
    protected $deletedField  = 'date_delete';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}