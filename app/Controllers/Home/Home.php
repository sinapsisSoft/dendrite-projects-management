<?php
/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:13/08/2023
*Description:General Home management class
*/
namespace App\Controllers\Home;

use App\Controllers\BaseController;

class Home extends BaseController{


    public function show(){

        $data['userId'] = session()->UserId;
        
        $data['title'] = 'Inicio';
        $data['meta'] = view('assets/meta');
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');

        $data['toasts'] = view('html/toasts');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('header/header');
        $data['footer'] = view('footer/footer');
        return view('home/home', $data);
    } 
}