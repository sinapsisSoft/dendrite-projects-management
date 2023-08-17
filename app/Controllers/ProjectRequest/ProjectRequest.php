<?php

namespace App\Controllers\ProjectRequest;

use App\Controllers\BaseController;
use App\Models\ProjectRequest\ProjectRequestModel;
use App\Models\Country\CountryModel;
use App\Models\Manager\ManagerModel;
use App\Models\Brand\BrandModel;

class ProjectRequest extends BaseController
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
        $manager = new ManagerModel();    
        $brand = new BrandModel();
        $country = new CountryModel();

        $data['title'] = 'Solicitud de proyectos';
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');
        $data['toasts'] = view('html/toasts');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('navbar/header');
        $data['footer'] = view('navbar/footer');

        $data[$this->nameModel] = $this->objModel->sp_select_projectrequest_all();
        $data['managers'] = $manager->findAll();
        $data['brands'] = $brand->findAll();
        $data['countries'] = $country->findAll();
        return view('projectrequest/projectrequest', $data);
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
