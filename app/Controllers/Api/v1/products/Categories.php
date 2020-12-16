<?php namespace App\Controllers\Api\v1\Products;

use  App\Controllers\Api\Middleware\Authentication;

class Categories extends Authentication
{
    protected $modelName = 'App\Models\Products\Categories';   

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
        'parent_id' => 'parent_id',
        'code'  => 'code'
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
        'parent_id'  => [
            'label' => 'Parent Id',
            'rules' => 'integer'
        ],
        'name'  => [
            'label' => 'Name',
            'rules' => 'required'
        ],
        'code'  => [
            'label' => 'Code',
            'rules' => 'required|is_unique[products_categories.code]'
        ]
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
        'parent_id'  => [
            'label' => 'Parent Id',
            'rules' => 'integer'
        ],
        'name'  => [
            'label' => 'Name',
            'rules' => 'required'
        ],
        'code'  => [
            'label' => 'code',
            'rules' => 'required'
        ]
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
        'parent_id'  => 'parent_id',
        'name'  => 'name',
        'code'  => 'code'
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
        'parent_id'  => 'parent_id',   
        'name'  => 'name',        
        'code'  => 'code'
    ];
    
    // ...
}