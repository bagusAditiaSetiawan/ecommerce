<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class BaseApiController extends ResourceController
{
    protected $modelName;
    protected $format    = 'json';

    /**
     * @var string
     */

    public $primaryKey = 'id';
    /**
     * @var array
     * column of name table database
     * name of param post
     */
//    [
//        'column'    => 'value'
//    ]
    public $fillSearch = [];

    /**
     * @var array
     * column of name table database
     * name of param post
     */
//    [
//        'column'    => 'value'
//    ]
    public $fillWhere = [];


//    [
//        'name' => [
//        'label'  => 'Name',
//        'rules'  => 'required',
//        'errors' => [
//        'required' => 'Required Name '
//        ]
//    ],
    public $validateInsert = [];
//  [
//        'name' => [
//        'label'  => 'Name',
//        'rules'  => 'required',
//        'errors' => [
//        'required' => 'Required Name '
//        ]
//    ],

    public $validateUpdate = [];

    /**
     * @var array
     * column of name table database
     * name of param post
     */
//    [
//        'column'    => 'value'
//    ]
    public $fillableInsert = [];

    /**
     * @var array
     * column of name table database
     * name of param post
     */
//    [
//        'column'    => 'value'
//    ]


    public $fillableIupdate = [];

//    product
    public $content;

    public function whereIndex()
    {
        if(count($this->fillSearch)){
            foreach ($this->fillSearch as $column => $param){
                $get = $this->request->getGet($param);
                if($get != null){
                    $this->model->like($column,$get);
                }
            }
        }

        if(count($this->fillWhere)){
            foreach ($this->fillWhere as $column => $param){
                $get = $this->request->getGet($param);
                if($get != null){
                    $this->model->where($column,$get);
                }
            }
        }
    }


    public function index()
    {
        if($this->model){
            if($this->request->getGet('page')){
                $page = $this->request->getGet('page');
            }else{
                $page = 0;
            }
            if($this->request->getGet('limit')){
                $limit = $this->request->getGet('limit');
            }else{
                $limit = 0;
            }
            if($gets = $this->request->getGet()){
                $this->whereIndex($gets);

            }
            if(method_exists($this,'beforeIndex')){
                $data = $this->beforeIndex();
            }
            $data = $this->model->allWithPaging($page, $limit);
            if(method_exists($this,'afterIndex')){
                $data = $this->afterIndex($data);
            }
            $this->whereIndex();
            $total = $this->model->findAll();
            return $this->sendResponseGet([
                'data'  => $data,
                'total' => count($total),
            ]);
        }
        return $this->sendError(['error'=>'Model not Found']);

    }

    public function insert()
    {
        if($this->model){
            if($post = $this->request->getPost()){
                if(method_exists($this, 'beforeValidate')){
                    $this->beforeValidate();
                }
                if(count($this->validateInsert)){
                    $this->validate($this->validateInsert);
                }
                if(! $this->validator->run()){
                    return $this->sendError($this->validator->getErrors(),'Failed insert '.$this->content);
                }
                if(count($this->fillableInsert)){
                    $this->model->db->transBegin();
                    if(method_exists($this, 'beforeInsert')){
                        $this->beforeInsert();
                    }
                    if(method_exists($this, 'beforeInsertOrUpdate')){
                        $this->beforeInsertOrUpdate();
                    }

                    $data = [];
                    foreach ($this->fillableInsert as $column => $param){
                        if($this->request->getPost($param) != null){
                            $data[$column]  = $this->request->getPost($param);
                        }
                    }

                    $this->model->save($data);
                    if(method_exists($this, 'afterInsert')){
                        $this->afterInsert();
                    }
                    if(method_exists($this, 'afterInsertOrUpdate')){
                        $this->afterInsertOrUpdate();
                    }
                    if($this->model->db->transStatus()){
                        $this->model->db->transCommit();
                        return $this->sendResponseInsert($this->model->find($this->model->getInsertID()),'Successfully insert '.$this->content);
                    }else{
                        $this->model->db->transRollback();
                        return $this->sendError($this->model->db->getLastQuery(),'Failed insert '.$this->content);
                    }
                }
            }
            return $this->sendError([],  'Request Should Post');
        }
        return $this->sendError([],'Model Not Found '.$this->model);
    }

    public function update($id = null)
    {
        if($this->model){
            if($this->request->getPost()){
                if(method_exists($this, 'beforeValidate')){
                    $this->beforeValidate();
                }
                if(count($this->validateUpdate)){
                    $this->validate($this->validateUpdate);
                }
                if(! $this->validator->run()){
                    return $this->sendError($this->validator->getErrors(),'Failed Updated '.$this->content);
                }
                if(count($this->fillableIupdate)){
                    $this->model->db->transBegin();
                    if(method_exists($this, 'beforeUpdate')){
                        $this->beforeUpdate();
                    }
                    if(method_exists($this, 'beforeInsertOrUpdate')){
                        $this->beforeInsertOrUpdate();
                    }

                    $data = [];
                    foreach ($this->fillableIupdate as $column => $param){
                        if($this->request->getPost($param) != null){
                            $data[$column]  = $this->request->getPost($param);
                        }
                    }

                    $this->model->update($id,$data);


                    if(method_exists($this, 'afterUpdate')){
                        $this->afterUpdate();
                    }
                    if(method_exists($this, 'afterInsertOrUpdate')){
                        $this->afterInsertOrUpdate();
                    }
                    if($this->model->db->transStatus()){
                        $this->model->db->transCommit();
                        return $this->sendResponseUpdate($this->model->find($id),'Successfully updated '.$this->content);
                    }else{
                        $this->model->db->transRollback();
                        return $this->sendError($this->model->db->getLastQuery(),'Failed updated '.$this->content);
                    }
                }

            }
            return $this->sendError(false, 'Request Should Post');
        }
        return $this->sendError('Model Not Found','Model Not Found '.$this->model);
    }

    public function delete($id = null)
    {
        if($this->model) {
            $data = $this->model->find($id);
            if ($find = $this->model->delete($id)) {
                if(method_exists($this, 'afterDeleted')){
                    $this->afterDeleted($data);
                }
                return $this->sendResponseGet($data, 'Successfully get ' . $this->content);
            } else {
                return $this->sendResponseGet([],'Successfully get ' . $this->content);
            }
        }
        return $this->sendError([],'Model Not Found '.$this->model);
    }


    public function show($id = null)
    {
        if($this->model) {
            if ($find = $this->model->find($id)) {
                if(method_exists($this, 'afterView')){
                    $find = $this->afterView($find);
                }
                return $this->sendResponseGet($find,'Successfully get ' . $this->content);
            } else {
                return $this->sendError([], 'Failed get post' . $this->content);
            }
        }
        return $this->sendResponse('Model Not Found','Model Not Found '.$this->model);

    }

    public function images_url($path)
    {
        if(!is_file($path)){
            return base_url('storage/images/default/noimage.jpg');
        }
        return base_url($path);
    }
    public function avatar_url($path)
    {
        if(!is_file($path)){
            return base_url('storage/images/default/avatar.png');
        }
        return base_url($path);
    }

    public function sendResponseGet($data = [], $message = 'Successfully get data', $status = 200)
    {
        $this->response->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Headers', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        return $this->respond([
            'data'  => $data,
            'message'   => $message,
            'status'    => $status
        ]);
    }

    public function sendResponseInsert($data = [], $message = 'Successfully get insert', $status = 201)
    {
        $this->response->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Headers', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        return $this->respond([
            'data'  => $data,
            'message'   => $message,
            'status'    => $status
        ]);
    }

    public function sendResponseUpdate($data = [], $message = 'Successfully get update', $status = 201)
    {
        $this->response->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Headers', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        return $this->respond([
            'data'  => $data,
            'message'   => $message,
            'status'    => $status
        ]);
    }

    public function sendError($data = [], $message = 'Failed request', $status = 400)
    {
        $this->response->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Headers', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        return $this->respond([
            'data'  => $data,
            'message'   => $message,
            'status'    => $status
        ]);
    }

    public function sendResponse($data = [], $message = '',  $status = 200)
    {
        $this->response->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Headers', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        return $this->respond(array(
            'data'  => $data,
            'status'    => $status,
            'message'   => $message
        ));
    }

    // ...
}