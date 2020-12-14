<?php namespace App\Controllers\Api\Middleware;

use App\Controllers\Api\BaseApiController;

class Authentication extends BaseApiController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $authorization = $this->request->getHeader('Authorization');

        if($authorization) {
           
            $bearer = explode(' ',$authorization)[1];
            if($bearer === 'Bearer'){
                $token = explode(' ',$authorization)[2];
                $modelUser = new \App\Models\Users();
                $user = $modelUser->where('token', $token)->first();
                if($user){
                    $this->request->setHeader('user', $user);                    
                    return true;
                }
            }
        }
        $this->sendResponse([],'Access Denied');

        exit;
        


		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		// $this->session = \Config\Services::session();
	}
}