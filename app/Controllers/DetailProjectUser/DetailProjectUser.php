<?php
namespace App\Controllers\DetailProjectUser;

use App\Controllers\BaseController;
use App\Models\ProjectModel;
use App\Models\ProjectProductModel;
use App\Models\ProductModel;
use App\Models\UserStatusModel;
use App\Models\ActivitiesModel;
use App\Models\ManagerBrandsModel;
use App\Models\ProjectRequestModel;
use App\Models\UserManagerModel;
use App\Models\ProjectRequestProductModel;


class DetailProjectUser extends BaseController{

    private $objModel;
    private $primaryKey;
    private $nameModel;
    private $userId;

    public function __construct()
    {
        $this->objModel = new ProjectRequestModel();
        $this->primaryKey = 'ProjReq_id';
        $this->nameModel = 'projects';
        $this->userId = 24; //Id del usuario logueado
    }

    public function show(){
        $userId = 24; //Id del usuario logueado
        $product = new ProductModel();
        $brandModel = new ManagerBrandsModel();
        $usermanager = new UserManagerModel();
        $projectRequestProduct = new ProjectRequestProductModel();
        $projectRequestId = $this->request->getGet('projectRequestId');

        $data['title'] = 'Detalles';
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');

        $data['toasts'] = view('html/toasts');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('navbar/header');
        $data['footer'] = view('navbar/footer');
        $managerId = $usermanager->where('User_id',$userId)->findAll();
        $managerId = $managerId[0]['Manager_id']; 
        $data['brands'] = $brandModel->sp_select_manager_brands($managerId);
        $data['products'] = $product->findAll();
        $data['data'] = [
            'projectrequest' => $this->objModel->sp_select_projectrequest_detail($projectRequestId)[0],
            'projectrequestproducts' => $projectRequestProduct->sp_select_projectrequest_product($projectRequestId)
        ];     
        return view('detailsprojectrequest/detailsprojectrequestuser', $data);
    }  
    
}