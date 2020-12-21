<?php namespace App\Controllers\Api\v1\Products;

use  App\Controllers\Api\Middleware\Authentication;

class Items extends Authentication
{
    protected $modelName = 'App\Models\Products\Items';   

    public $fillSearch = [
        'name'    => 'name'
    ];

      /**
     * @var string
     */

    public $primaryKey = 'id';
    /**
     * @var array
     * column of name table database
     * name of param post
     */

    /**
     * @var array
     * column of name table database
     * name of param post
     */
//    [
//        'column'    => 'value'
//    ]
    public $fillWhere = [
        'id_currency' => 'id_currency',
        'id_product_category'  => 'id_product_category'
    ];


//    [
//        'name' => [
//        'label'  => 'Name',
//        'rules'  => 'required',
//        'errors' => [
//        'required' => 'Required Name '
//        ]
//    ],
    public $validateInsert = [
        'id_product_category'  => [
            'label' => 'Id Product Category',
            'rules' => 'required|integer'
        ],
        'id_currency'  => [
            'label' => 'id_currency',
            'rules' => 'required|integer'
        ],        
        'name'  => [
            'label' => 'Name',
            'rules' => 'required'
        ],
        'price_sale'  => [
            'label' => 'Price Sale',
            'rules' => 'required|decimal'
        ],
        'price_purchase'  => [
            'label' => 'Price Purchase',
            'rules' => 'required|decimal'
        ],
    ];
//  [
//        'name' => [
//        'label'  => 'Name',
//        'rules'  => 'required',
//        'errors' => [
//        'required' => 'Required Name '
//        ]
//    ],

    public $validateUpdate = [
        'id'  => [
            'label' => 'id',
            'rules' => 'required|integer'
        ],
        'id_product_category'  => [
            'label' => 'Id Product Category',
            'rules' => 'required|integer'
        ],
        'id_currency'  => [
            'label' => 'id_currency',
            'rules' => 'required|integer'
        ],        
        'name'  => [
            'label' => 'Name',
            'rules' => 'required'
        ],
        'price_sale'  => [
            'label' => 'Price Sale',
            'rules' => 'required|decimal'
        ],
        'price_purchase'  => [
            'label' => 'Price Purchase',
            'rules' => 'required|decimal'
        ],
    ];

    /**
     * @var array
     * column of name table database
     * name of param post
     */
//    [
//        'column'    => 'value'
//    ]
    public $fillableInsert = [
        'id_product_category'  => 'id_product_category',
        'id_currency'  => 'id_currency',
        'name'  => 'name',
        'slugs' => 'slugs',
        'price_sale'  => 'price_sale',
        'price_purchase'  => 'price_purchase',
        'description'  => 'price_purchase',
        'image' => 'image'
    ];

    /**
     * @var array
     * column of name table database
     * name of param post
     */
//    [
//        'column'    => 'value'
//    ]


    public $fillableIupdate = [     
        'id'    => 'id',
        'id_product_category'  => 'id_product_category',
        'id_currency'  => 'id_currency',
        'name'  => 'name',
        'price_sale'  => 'price_sale',
        'price_purchase'  => 'price_purchase',
        'description'  => 'price_purchase',        
        'slugs' => 'slugs',
        'image' => 'image'
    ];

    public function beforeInsertOrUpdate()
    {             
        $post = $this->request->getPost();
        if($this->request->getFile('image')){
            if($filename = $this->request->getFile('image')->getClientName()){   
                if(!is_dir($this->model->path)){
                    mkdir($this->model->path,0777,true);
                }
                $this->request->getFile('image')->move($this->model->path,$filename);
                $post['image'] = $this->images_url($this->model->path.$filename);
            }

        }
        $post['slugs'] = $this->buildSlugs($this->request->getPost('name'));            
        $this->request->setGlobal('post',$post);
    }
    
    // ...
}