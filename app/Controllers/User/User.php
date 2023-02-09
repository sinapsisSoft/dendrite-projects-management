<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class User extends BaseController
{
    public function show()
    {
        $data['title'] = 'TITLE';
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('navbar/header');
        $data['footer'] = view('navbar/footer');
        return view('user/user',$data);
       
    }
   
}
