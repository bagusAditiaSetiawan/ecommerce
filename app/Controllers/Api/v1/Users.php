<?php namespace App\Controllers\Api\v1;

use App\Controllers\Api\BaseApiController;

class Users extends BaseApiController
{
    protected $modelName = 'App\Models\Users';

    public function current()
    {
        $authorization = $this->request->getHeader('Authorization');

        if($authorization) {
            $bearer = explode(' ',$authorization)[1];
            if($bearer === 'Bearer'){
                $token = explode(' ',$authorization)[2];
                $modelUser = new \App\Models\Users();
                $user = $modelUser->where('token', $token)->first();
                if($user){
                    $this->request->setHeader('user', $user);                    
                    return  $this->sendResponse($user,'Access Denied');
                }
            }
        }
        $this->response->setStatusCode(400);
        return  $this->sendResponse([],'Access Denied');
    }

    public function login()
    {
        if($post = $this->request->getPost()){
            $this->validate( 
                 [
                       'username' => [
                            'label'  => 'Username',
                            'rules'  => 'required',
                       ] ,
                        'password' => [
                            'label'  => 'password',
                            'rules'  => 'required',
                        ] 
                ]
            );
            
            if(! $this->validator->run()){
                return $this->sendError($this->validator->getErrors(),'Failed insert '.$this->content);
            }
            if($user = $this->model->where('username', $post['username'])->first()){
                $hashToken = password_hash($user->username,PASSWORD_DEFAULT);
                if(password_verify($post['password'], $user->password)){
                    $this->model->update($user->id, [
                        'token' => $hashToken
                    ]);
                    return $this->sendResponseGet([
                        'token' => $hashToken,
                        'user'  => $user
                    ]);
                }else{
                    return  $this->sendError([],'Username Or Password Not Founded '.$this->content);
                }

            }else{
                return  $this->sendError([],'Username Or Password Not Founded '.$this->content);
            }
        }
        return $this->sendError([],'Request should Post');
    }
    

    // ...
}