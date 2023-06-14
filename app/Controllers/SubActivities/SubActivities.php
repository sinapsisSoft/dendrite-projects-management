<?php

namespace App\Controllers\SubActivities;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SubActivitiesModel;
use App\Models\UserStatusModel;
use App\Models\UserModel;
use App\Models\ActivitiesModel;
use App\Models\MailModel;
use App\Models\PrioritiesModel;
use App\Utils\Email;

class SubActivities extends BaseController
{
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

    public function finishTask()
    {
        if ($this->request->isAJAX()) {
            $email = new Email();
            $mail = new MailModel();
            $mainMail = $mail->findAll()[0];
            $status = new UserStatusModel();
            $subactivityId = $this->request->getVar('id');
            $subActivitie = $this->objModel->sp_select_subactivity_info($subactivityId);  
            if ($subActivitie != null){
                $email->sendEmail($subActivitie, $mainMail["Mail_user"], 1);
                $finishStatus = $status->where('Stat_name', 'Realizado')->first();    
                $updateSubactivity = [
                    'Stat_id' => $finishStatus["Stat_id"],
                    'SubAct_percentage' => '100'
                ];            
                $this->objModel->update($subactivityId, $updateSubactivity);
                $this->activities->sp_update_percent_activity($subActivitie[0]->Activi_id);
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['csrf'] = csrf_hash();
            }      
            else {
                $data['message'] = 'Subactivity not found';
                $data['response'] = ResponseInterface::HTTP_CONFLICT;
                $data['data'] = '';
            }            
        } else {
            $data['message'] = 'Error Ajax';
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        return json_encode($data);
    }

    public function show()
    {
        $userstatus = new UserStatusModel();
        $priorities = new PrioritiesModel();
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
        $data['activity'] = $this->activities->sp_select_all_details_activities($activityId) != null ? $this->activities->sp_select_all_details_activities($activityId)[0] : [];
        $data['subactivities'] = $this->objModel->sp_select_all_sub_actitivites($activityId);
        $data['collaborators'] = $user->sp_select_all_users_collaborator();
        $data['priorities'] = $priorities->findAll();
        // $data['subactivitiesDetails'] = $this->objModel->sp_select_all_details_subactivities($subactivityId);
        $data['users'] = $user->sp_select_all_users();
        return view('subactivities/subactivities', $data);
    }

    public function sendNotification()
    {
        if ($this->request->isAJAX()) {
            $emailObject = new Email();
            $subactivityId = $this->request->getVar('not_subId');
            $subActivitie = $this->objModel->sp_select_subactivity_info($subactivityId);
            var_dump($subActivitie);
            $newData = [
                'subject' => $this->request->getVar('subject'),
                'link' => $this->request->getVar('link'),
                'description' => $this->request->getVar('description')
            ];
            if($subActivitie =! null){
                $subActivitie[0]->subject = $this->request->getVar('subject');
                array_push($subActivitie[], $newData);
            }
            // $subject = $this->request->getVar('subject');
            // $link = $this->request->getVar('link');
            // $description = $this->request->getVar('description');
            $collaborators = $this->request->getVar('collaborators');
            $emails = explode(',', $collaborators);
            // $dataEmail = ["subject" => $subject, "link" => $link, "message" => $description];
            foreach ($emails as $email) {
                $emailObject->sendEmail($subActivitie, $email, 2);
            }
            $data['message'] = 'success';
            $data['response'] = ResponseInterface::HTTP_OK;
            $data['csrf'] = csrf_hash();
        } else {
            $data['message'] = 'Error Ajax';
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        return json_encode($data);
    }

    public function create()
    {
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
            'Priorities_id' => $this->request->getVar('Priorities_id'),
            'User_id' => $this->request->getVar('User_id'),
        ];
        return $data;
    }
}
