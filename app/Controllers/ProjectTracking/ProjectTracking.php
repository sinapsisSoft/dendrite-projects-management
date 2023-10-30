<?php
namespace App\Controllers\ProjectTracking;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProjectTracking\ProjectTrackingModel;
use App\Models\Project\ProjectModel;
use App\Models\User\UserModel;
use App\Utils\Email;


class ProjectTracking extends BaseController{
    private $objModel;
    private $primaryKey;
    private $nameModel;

    public function __construct()
    {
        $this->objModel = new ProjectTrackingModel();
        $this->primaryKey = 'ProjectTrack_id';
        $this->nameModel = 'projecttrackings';
    }

    public function show(){
        $data['meta'] = view('assets/meta');
        $data['title'] = 'Seguimiento del Proyecto';
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');

        $data['toasts'] = view('html/toasts');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('header/header');
        $data['footer'] = view('footer/footer');

        $data[$this->nameModel] = $this->objModel->findAll();
        return view('projecttracking/projecttracking', $data);
    }

    public function create(){
        $email = new Email();
        $email1 = new Email();
        $projectModel = new ProjectModel();
        $userModel = new UserModel();
        if ($this->request->isAJAX()) {
            $dataModel = $this->getDataModel(NULL);
            if ($this->objModel->insert($dataModel)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = $dataModel;
                $data['csrf'] = csrf_hash();
                $projectId = $dataModel['Project_id'];
                $project = $projectModel->sp_select_all_project($projectId);
                $commercial = $userModel->where('User_id', $project[0]->User_id)->find();
                $traffic = $userModel->where('User_id', $project[0]->Project_traffic)->find();
                $dataModel['Project_name'] = $project[0]->Project_name;
                $dataModel['Project_id'] = $projectId;
                $email->sendEmail($dataModel, $commercial[0]['User_email'], 10);
                $email1->sendEmail($dataModel, $traffic[0]['User_email'], 10);
            } else {
                $data['message'] = 'Error create user';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
        } else {
            $data['message'] = 'Error Ajax';
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        return json_encode($data);
    }

    public function edit()
    {
        try {
            $id = $this->request->getVar($this->primaryKey);
            $getDataId = $this->objModel->where($this->primaryKey, $id)->first();
            $data['message'] = 'success';
            $data['response'] = ResponseInterface::HTTP_OK;
            $data['data'] = $getDataId;
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
            $id = $this->request->getVar($this->primaryKey);
            if ($this->objModel->where($this->primaryKey, $id)->delete($id)) {
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
            'ProjectTrack_id' => $getShares,
            'ProjectTrack_name' => $this->request->getVar('ProjectTrack_name'),
            'ProjectTrack_description' => $this->request->getVar('ProjectTrack_description'),
            'Project_id' => $this->request->getVar('Project_id'),
            'ProjectTrack_date' => $this->request->getVar('ProjectTrack_date'),
        ];
        return $data;
    }
}