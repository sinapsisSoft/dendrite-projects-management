<?php

namespace App\Controllers\DetailProjectRequest;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProjectModel;
use App\Models\ProjectRequestModel;
use App\Models\ProjectRequestProductModel;
use App\Models\UserModel;
use App\Models\PrioritiesModel;

class DetailProjectRequest extends BaseController
{

    private $objModel;
    private $primaryKey;
    private $nameModel;

    public function __construct()
    {
        $this->objModel = new ProjectRequestModel();
        $this->primaryKey = 'ProjReq_id';
        $this->nameModel = 'projects';
    }

    public function show()
    {
        $projectRequestProduct = new ProjectRequestProductModel();
        $user = new UserModel();
        $priorities = new PrioritiesModel();
        $projectRequestId = $this->request->getGet('projectRequestId');

        $data['title'] = 'Detalles de la solicitud';
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');

        $data['toasts'] = view('html/toasts');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('navbar/header');
        $data['footer'] = view('navbar/footer');
        $data['commercial'] = $user->sp_select_all_users_comercial();
        $data['users'] = $user->sp_select_all_users();
        $data['priorities'] = $priorities->findAll();
        $data['data'] = [
            'projectrequest' => $this->objModel->sp_select_projectrequest_detail($projectRequestId)[0],
            'projectrequestproducts' => $projectRequestProduct->sp_select_projectrequest_product($projectRequestId)
        ];
        return view('detailsprojectrequest/detailsprojectrequest', $data);
    }

    public function create()
    {
        try {
            $projectModel = new ProjectModel();
            $projectRequestId = $this->request->getVar($this->primaryKey);
            $result = $this->objModel->sp_insert_projectRequest($projectRequestId);
            $projectId = $result[0]->Project_id;            
            $codeProject = $this->generateCode((string)$projectId);
            $dataProject = [
                'Project_code' => $codeProject,
                'Project_commercial' => $this->request->getVar('Project_commercial'),
                'User_id' => $this->request->getVar('User_id'),
                'Priorities_id' => $this->request->getVar('Priorities_id')
            ];
            $projectModel->update($projectId, $dataProject);
            $dataRequest = [
                'Stat_id' => 7,
                'Project_id' => $projectId
            ];
            $this->objModel->update($projectRequestId, $dataRequest);
            $data['message'] = 'success';
            $data['response'] = ResponseInterface::HTTP_OK;
            $data['data'] = $codeProject;
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
            $dataProjectReq = [
                'Stat_id' => 8
            ];
            $this->objModel->update($projectRequestId, $dataProjectReq);
            $data['message'] = 'success';
            $data['response'] = ResponseInterface::HTTP_OK;
            $data['data'] = $projectRequestId;
            $data['csrf'] = csrf_hash();
        } catch (\Exception $e) {
            $data['message'] = $e;
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = 'Error';
        }
        return json_encode($data);
    }

    public function generateCode($id)
    {
        return "PRO_" . str_pad($id, 3, '0', STR_PAD_LEFT);
    }
}
