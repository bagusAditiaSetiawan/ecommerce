<?php namespace App\Models;

use App\Models\Base;

class Users extends Base
{
    protected $table      = 'auth_users';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name', 'email','password','token'];

    protected $useTimestamps = false;
    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';    
    protected $deletedField  = 'date_delete';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}