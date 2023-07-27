<?php
namespace App\Controllers\Details;

use App\Controllers\BaseController;
use App\Models\ProjectRequestModel;
use App\Models\ProjectRequestProductModel;
use App\Models\ProductModel;
use App\Models\UserStatusModel;
use App\Models\ActivitiesModel;
use App\Models\ProjectTrackingModel;





class Details extends BaseController{


    public function show(){
        $projectRequest = new ProjectRequestModel();
        $projectRequestProduct = new ProjectRequestProductModel();
        $product = new ProductModel();
        $projectRequestId = $this->request->getGet('projectId');

        $data['title'] = 'Detalles de la solicitud';
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');

        $data['toasts'] = view('html/toasts');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('navbar/header');
        $data['footer'] = view('navbar/footer');

        $data['data'] = ['projectrequest' => $projectRequest->sp_select_projectrequest_detail($projectRequestId)[0],
                         'projectrequestproducts' => $projectRequestProduct->sp_select_projectrequest_product($projectRequestId)];
        return view('detailsprojectrequest/detailsprojectrequest', $data);
    }  
    
}