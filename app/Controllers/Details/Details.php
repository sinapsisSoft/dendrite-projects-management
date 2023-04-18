<?php
namespace App\Controllers\Details;

use App\Controllers\BaseController;
use App\Models\ProjectModel;
use App\Models\ProjectProductModel;
use App\Models\ProductModel;
use App\Models\UserStatusModel;


class Details extends BaseController{


    public function show(){
        $project = new ProjectModel();
        $projectProduct = new ProjectProductModel();
        $product = new ProductModel();
        $projectId = $this->request->getGet('projectId');
        $status = new UserStatusModel();
        $data['title'] = 'Detalles';
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');

        $data['toasts'] = view('html/toasts');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('navbar/header');
        $data['footer'] = view('navbar/footer');

        $data['data'] = ['project' => $project->where('Project_id', $projectId)->first(),
                         'products' => $projectProduct->sp_select_all_project_product($projectId)];
        $data['products'] = $product->findAll();
        $data['statuses'] = $status->where('StatType_id', 4)->find();
        return view('details/details', $data);
    }
  
    
}