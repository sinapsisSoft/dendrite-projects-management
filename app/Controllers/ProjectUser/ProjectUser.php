<?php

namespace App\Controllers\ProjectUser;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProjectRequest\ProjectRequestModel;
use App\Models\ManagerBrands\ManagerBrandsModel;
use App\Models\UserManager\UserManagerModel;

class ProjectUser extends BaseController
{
    private $objModel;
    private $primaryKey;
    private $nameModel;
    private $userId;

    public function __construct()
    {
        $this->objModel = new ProjectRequestModel();
        $this->primaryKey = 'ProjReq_id';
        $this->nameModel = 'projectrequest';
        $this->userId = session()->UserId;
    }

    public function show()
    {     
        try {
            $brand = new ManagerBrandsModel();
            $usermanager = new UserManagerModel();
    
            $data['title'] = 'Solicitud de proyectos';
            $data['css'] = view('assets/css');
            $data['js'] = view('assets/js');
            $data['toasts'] = view('html/toasts');
            $data['sidebar'] = view('navbar/sidebar');
            $data['header'] = view('navbar/header');
            $data['footer'] = view('navbar/footer');
    
            $data[$this->nameModel] = $this->objModel->sp_select_projectrequest_user($this->userId);
            $managerId = $usermanager->where('User_id',$this->userId)->findAll();
            $managerId = $managerId[0]['Manager_id'];        
            $data['brands'] = $brand->sp_select_manager_brands($managerId); 

            return view('projectrequest/projectrequestcreate', $data); 

        }catch(\Exception $e){
            $data['message'] = $e;
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
        }
        return view('error', $data);        
    }

    public function create()
    {
        if ($this->request->isAJAX()) {
            $dataModel = $this->getDataModel(NULL);
            $dataModel['User_id'] = $this->userId;
            $dataModel['Stat_id'] = 6;
            if ($this->objModel->insert($dataModel)) {
                $id = $this->objModel->insertID();
                $dataModel['ProjReq_id'] = $id;
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = $dataModel;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error creating project';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
        } else {
            $data['message'] = 'Error Ajax';
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
        }
        return json_encode($data);
    }

    public function edit()
    {
        try {            
            $brandModel = new ManagerBrandsModel();
            $usermanager = new UserManagerModel();
            $id = $this->request->getVar($this->primaryKey);
            $getDataId = $this->objModel->where($this->primaryKey, $id)->first();             
            $managerId = $usermanager->where('User_id',$this->userId)->findAll();
            $managerId = $managerId[0]['Manager_id']; 
            $data['brands'] = $brandModel->sp_select_manager_brands($managerId);
            $data['data'] = $getDataId;
            $data['message'] = 'success';
            $data['response'] = ResponseInterface::HTTP_OK;
            $data['csrf'] = csrf_hash();
        } catch (\Exception $e) {
            $data['message'] = $e;
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = 'Error';
        }
        return json_encode($data);
    }

    public function update()
    {
        try {
            $today = date("Y-m-d H:i:s");
            $id = $this->request->getVar($this->primaryKey);
            $data = $this->getDataModel($id);
            $data['updated_at'] = $today;
            $this->objModel->update($id, $data);
            $data['message'] = 'success';
            $data['response'] = ResponseInterface::HTTP_OK;
            $data['data'] = $id;
            $data['csrf'] = csrf_hash();
        } catch (\Exception $e) {
            $data['message'] = $e;
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = 'Error';
        }
        return json_encode($data);
    }

    public function delete()
    {
        try {
            $projectRequestId = $this->request->getVar($this->primaryKey);
            $data['requestId'] = $this->primaryKey  . "-". $projectRequestId;
            if ($this->objModel->where($this->primaryKey, $projectRequestId)->delete($projectRequestId)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = "ok";
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error Ajax';
                $data['response'] = ResponseInterface::HTTP_CONFLICT;
                $data['data'] = 'error';
            }  
        } catch (\Exception $e) {
            $data['message'] = $e;
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = 'Error';
        }
        return json_encode($data);
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
