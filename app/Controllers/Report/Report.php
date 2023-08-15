<?php
namespace App\Controllers\Report;

use App\Controllers\BaseController;


class Report extends BaseController{


    public function show(){

        $data['title'] = 'Reportes';
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');

        $data['toasts'] = view('html/toasts');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('navbar/header');
        $data['footer'] = view('navbar/footer');
        return view('report/report', $data);
    }
    
}