<?php
namespace App\Controllers\Details;

use App\Controllers\BaseController;
use App\Models\ProjectModel;
use App\Models\ProjectProductModel;
use App\Models\ProductModel;
use App\Models\UserStatusModel;
use App\Models\UserModel;
use App\Models\ApprovalCodeModel;
use App\Models\ActivitiesModel;
use App\Models\ProjectTrackingModel;





class Details extends BaseController{


    public function show(){
        $project = new ProjectModel();
        $projectProduct = new ProjectProductModel();
        $projecttracking = new ProjectTrackingModel();
        $product = new ProductModel();
        $activities = new ActivitiesModel();
        $projectId = $this->request->getGet('projectId');
        $userstatus = new UserStatusModel();
        $approvalcode = new ApprovalCodeModel();

        $data['title'] = 'Detalles';
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');

        $data['toasts'] = view('html/toasts');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('navbar/header');
        $data['footer'] = view('navbar/footer');

        $data['data'] = ['project' => $project->sp_select_all_project($projectId)[0],
                          'percent' => $project->sp_select_percent_project($projectId)[0],
                         'products' => $projectProduct->sp_select_all_project_product($projectId)];
        $data['products'] = $product->findAll();
        $data['activities'] = $activities->sp_select_activities_project($projectId);
        $data['projecttrackings'] = $projecttracking->where('Project_id', $projectId)->find();
        $data['userstatuses'] = $userstatus->where('StatType_id', 4)->find();
        $data['approvalcodes'] = $approvalcode->findAll();
        return view('details/details', $data);
    }
  
    
}