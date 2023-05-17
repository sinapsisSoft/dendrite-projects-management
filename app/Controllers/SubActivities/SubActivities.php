<?php
namespace App\Controllers\SubActivities;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SubActivitiesModel;
use App\Models\UserStatusModel;
use App\Models\UserModel;
use App\Models\ActivitiesModel;

class SubActivities extends BaseController{
    private $objModel;
    private $primaryKey;
    private $nameModel;
    private $activities;

    public function __construct()
    {
        $this->objModel = new SubActivitiesModel();
        $this->primaryKey = 'SubAct_id';
        $this->nameModel = 'subactivities';
        $this->activities = new ActivitiesModel();
    }

    public function show(){
        $userstatus = new UserStatusModel();
        $user = new UserModel();

        $activityId = $this->request->getGet('activitiesId');
        // $subactivityId = $this->request->getGet('subactivitiesId');

        $data['title'] = 'Subactividades';
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');

        $data['toasts'] = view('html/toasts');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('navbar/header');
        $data['footer'] = view('navbar/footer');

        $data[$this->nameModel] = $this->objModel->findAll();
        $data['userstatuses'] = $userstatus->where('StatType_id', 4)->find();
        $data['activity'] = $this->activities->sp_select_all_details_activities($activityId);
        $data['subactivities'] = $this->objModel->sp_select_all_sub_actitivites($activityId);
        // $data['subactivitiesDetails'] = $this->objModel->sp_select_all_details_subactivities($subactivityId);
        $data['users'] = $user->sp_select_all_users();
        return view('subactivities/subactivities', $data);
    }

    public function create(){
        if ($this->request->isAJAX()) {
            $dataModel = $this->getDataModel(NULL);
            if ($this->objModel->insert($dataModel)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = $dataModel;
                $data['csrf'] = csrf_hash();
                $this->activities->sp_update_percent_activity($dataModel['Activi_id']);
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
            $this->activities->sp_update_percent_activity($data['Activi_id']);
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
            $activityId = $this->request->getVar('activityId');
            if ($this->objModel->where($this->primaryKey, $id)->delete($id)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = "ok";
                $data['csrf'] = csrf_hash();
                $this->activities->sp_update_percent_activity($activityId);
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
            'SubAct_id' => $getShares,
            'SubAct_name' => $this->request->getVar('SubAct_name'),
            'SubAct_description' => $this->request->getVar('SubAct_description'),
            'SubAct_estimatedEndDate' => $this->request->getVar('SubAct_estimatedEndDate'),
            'SubAct_percentage' => $this->request->getVar('SubAct_percentage'),
            'Stat_id' => $this->request->getVar('Stat_id'),
            'Activi_id' => $this->request->getVar('Activi_id'),
            'User_id' => $this->request->getVar('User_id'),
        ];
        return $data;
    }
}