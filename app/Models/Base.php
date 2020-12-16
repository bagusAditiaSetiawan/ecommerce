<?php namespace App\Models;

use CodeIgniter\Model;

class Base extends Model
{
    protected $table;
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [];

    protected $useTimestamps = false;
    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';    
    protected $deletedField  = 'date_delete';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function allWithPaging($page = 0, $limit = 10)
    {
        $this->orderBy($this->table.'.'.$this->primaryKey,'desc');
        return $this->findAll($limit, $page*$limit);
    }
}