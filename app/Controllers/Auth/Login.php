<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class Login extends BaseController
{
    public function show()
    {
        $data['title'] = 'TITLE';
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');
        return view('auth/login',$data);
       
    }
    public function login()
    {
        $user=new UserModel();
        $Username = $this->request->getVar('Username');
        $Password = $this->request->getVar('UserPassword');
        $responsUser=$user->findUserByEmailPassword($Username,$Password);
        if($responsUser==ResponseInterface::HTTP_NO_CONTENT){
            $data['message']='Error search user';
            $data['response']=ResponseInterface::HTTP_NO_CONTENT;
            $data['data']='';

        }else{
           
            $dataResult['token']=getSignedJWTForUser($responsUser);
            $data['message']='Search user';
            $data['response']=ResponseInterface::HTTP_OK;
            $data['data']=$dataResult;
        }
       
        return json_encode($data);
       
    }
}
