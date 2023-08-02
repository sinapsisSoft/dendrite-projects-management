<?php

namespace App\Controllers\ProjectUser;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProjectRequestModel;
use App\Models\ClientModel;
use App\Models\CountryModel;
use App\Models\ManagerBrandsModel;
use App\Models\BrandModel;
use App\Models\UserModel;
use App\Models\UserManagerModel;

class ProjectUser extends BaseController
{
    private $objModel;
    private $primaryKey;
    private $nameModel;

    public function __construct()
    {
        $this->objModel = new ProjectRequestModel();
        $this->primaryKey = 'ProjReq_id';
        $this->nameModel = 'projectrequest';
    }

    public function show()
    {     
        $brand = new ManagerBrandsModel();
        $user = new UserModel();
        $usermanager = new UserManagerModel();
        $userId = 24; //Id del usuario logueado

        $data['title'] = 'Solicitud de proyectos';
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');
        $data['toasts'] = view('html/toasts');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('navbar/header');
        $data['footer'] = view('navbar/footer');

        $data[$this->nameModel] = $this->objModel->sp_select_projectrequest_user($userId);
        $managerId = $usermanager->where('User_id',$userId)->findAll();
        $managerId = $managerId[0]['Manager_id'];        
        $data['brands'] = $brand->sp_select_manager_brands($managerId);
        return view('projectrequest/projectrequestcreate', $data);
    }

    public function getDataModel($getShares)
    {
        $data = [
            'ProjReq_id' => $getShares,
            'User_id' => $this->request->getVar('User_id'),
            'ProjReq_name' => $this->request->getVar('ProjReq_name'),
            'Brand_id' => $this->request->getVar('Brand_id'),            
            'ProjReq_observation' => $this->request->getVar('ProjReq_observation'),
            'Stat_id' => $this->request->getVar('Stat_id'),
            'Project_id' => $this->request->getVar('Project_id'),
            'updated_at' => $this->request->getVar('updated_at')
        ];
        return $data;
    }
}
