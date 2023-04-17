<?php
namespace App\Controllers\Home;

use App\Controllers\BaseController;



class Home extends BaseController{


    public function show(){
    
        $data['title'] = 'Inicio';
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');

        $data['toasts'] = view('html/toasts');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('navbar/header');
        $data['footer'] = view('navbar/footer');

        return view('home/home', $data);
    }
  
    
}