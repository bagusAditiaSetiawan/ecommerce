<?php namespace App\Controllers\Api\v1;

use App\Controllers\Api\BaseApiController;

class Users extends BaseApiController
{
    protected $modelName = 'App\Models\Users';

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