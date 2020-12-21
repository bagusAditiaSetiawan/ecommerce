<?php namespace App\Controllers\Api\v1\Master;

use  App\Controllers\Api\Middleware\Authentication;

class Currency extends Authentication
{
    protected $modelName = 'App\Models\Master\Currency';   

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
        'name'  => 'name',        
        'code'  => 'code'
    ];
    
    // ...
}