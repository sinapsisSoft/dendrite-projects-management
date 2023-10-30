<?php

namespace App\Controllers\SubActivities;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SubActivities\SubActivitiesModel;
use App\Models\UserStatus\UserStatusModel;
use App\Models\User\UserModel;
use App\Models\Activities\ActivitiesModel;
use App\Models\Mail\MailModel;
use App\Models\Priorities\PrioritiesModel;
use App\Models\Project\ProjectModel;
use App\Models\ProjectProduct\ProjectProductModel;
use App\Utils\Email;
use DateTime;
use PhpParser\Node\Expr\Cast\Array_;

class SubActivities extends BaseController
{
    private $objModel;
    private $primaryKey;
    private $nameModel;
    private $activities;
    private $userId;
    private $roleId;
    private $objUserModel;

    public function __construct()
    {
        $this->objModel = new SubActivitiesModel();
        $this->objUserModel = new UserModel();
        $this->primaryKey = 'SubAct_id';
        $this->nameModel = 'subactivities';
        $this->activities = new ActivitiesModel();
        $this->userId = session()->UserId;
        $this->roleId = $this->objUserModel->sp_select_user_role($this->userId);        
    }

    public function finishTask()
    {
        if ($this->request->isAJAX()) {
            $today = date("Y-m-d H:i:s");
            $email = new Email();
            $email1 = new Email();
            $mail = new ProjectModel();
            $projectModel = new ProjectModel();
            $status = new UserStatusModel();
            $user = new UserModel();
            $user1 = new UserModel();
            $subactivityId = $this->request->getVar($this->primaryKey);
            $mainMail = $mail->sp_select_user_notification($subactivityId);
            $subActivitie = $this->objModel->sp_select_subactivity_info($subactivityId);
            if ($subActivitie != null){                
                $finishStatus = $status->where('Stat_name', 'Realizado')->first();
                $updateSubactivity = [
                    'Stat_id' => $finishStatus["Stat_id"],
                    'SubAct_percentage' => '100',
                    'SubAct_duration' => $this->request->getVar('SubAct_duration'),
                    'SubAct_description' => $this->request->getVar('SubAct_description'),
                    'SubAct_endDate' => date("Y-m-d H:i:s"),
                    'updated_at' => $today
                ];
                $this->objModel->update($subactivityId, $updateSubactivity);
                $this->activities->sp_update_percent_activity($subActivitie[0]->Activi_id);
                $subactivityInfo = $this->objModel->sp_select_info_subactivity($subactivityId);
                $projectInfo = $projectModel->where('Project_id', $subactivityInfo[0]->Project_id)->first();
                $userInfo = $user->where('User_id', $projectInfo['Project_commercial'])->first();
                $commercialMail = $userInfo['User_email'];
                $userInfo1 = $user1->where('User_id', $projectInfo['User_id'])->first();
                $trafficMail = $userInfo1["User_email"];
                if ($projectInfo['Project_percentage'] == 100) {
                    $email->sendEmail($subactivityInfo, $commercialMail, 8);
                    $email1->sendEmail($subactivityInfo, $trafficMail, 8);
                } else {
                    $email->sendEmail($subactivityInfo, $commercialMail, 1);
                    $email1->sendEmail($subactivityInfo, $trafficMail, 1);                    
                }        
                $response = $this->updateEndDate(["Activi_id" => $subActivitie[0]->Activi_id]);
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['csrf'] = csrf_hash();
                $data['data'] = $response;
            }
            else {
                $data['message'] = 'Subactivity information not found';
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

        $data['meta'] = view('assets/meta');
        $data['title'] = 'Subactividades';
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');

        $data['toasts'] = view('html/toasts');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('header/header');
        $data['footer'] = view('footer/footer');

        // $data[$this->nameModel] = $this->objModel->findAll();
        $data['userstatuses'] = $userstatus->where('StatType_id', 4)->find();
        $data['activity'] = $this->activities->sp_select_all_details_activities($activityId) != null ? $this->activities->sp_select_all_details_activities($activityId)[0] : [];
        $data['subactivities'] = $this->objModel->sp_select_all_sub_actitivites($activityId);
        $data['collaborators'] = $user->sp_select_all_users_collaborator();
        $data['priorities'] = $priorities->findAll();
        $data['users'] = $user->sp_select_all_users();
        $data['roleUser'] = $this->roleId;
        return view('subactivities/subactivities', $data);
    }

    public function sendNotification()
    {
        if ($this->request->isAJAX()) {
            $emailObject = new Email();
            $subactivityId = $this->request->getVar('not_subId');
            $subActivitie = $this->objModel->sp_select_subactivity_info($subactivityId);
            if(count($subActivitie) > 0){
                $subActivitie[0]->subject = $this->request->getVar('subject');
                $subActivitie[0]->link = $this->request->getVar('link');
                $subActivitie[0]->message = $this->request->getVar('description');
                $collaborators = $this->request->getVar('collaborators');
                $emails = explode(',', $collaborators);
                foreach ($emails as $email) {
                    $emailObject->sendEmail($subActivitie, $email, 2);
                }
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['csrf'] = csrf_hash();
            }
            else {
                $data['message'] = 'Subactivity information not found';
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

    public function create()
    {
        if ($this->request->isAJAX()) {
            $email = new Email();
            $email1 = new Email();
            $projectModel = new ProjectModel();
            $user = new UserModel();
            $user1 = new UserModel();
            $dataModel = $this->getDataModel(NULL);
            if ($this->objModel->insert($dataModel)) {
                $id = $this->objModel->insertID();
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = $dataModel;
                $data['csrf'] = csrf_hash();
                $this->activities->sp_update_percent_activity($dataModel['Activi_id']);
                $subactivityInfo = $this->objModel->sp_select_info_subactivity($id);                
                $projectInfo = $projectModel->where('Project_id', $subactivityInfo[0]->Project_id)->first();
                $userInfo = $user->where('User_id', $projectInfo['Project_commercial'])->first();
                $commercialMail = $userInfo['User_email'];
                $email->sendEmail($subactivityInfo, $commercialMail, 5);
                $userInfo1 = $user1->where('User_id', $subactivityInfo[0]->User_id)->first();
                $collaboratorMail = $userInfo1["User_email"];
                $email1->sendEmail($subactivityInfo, $collaboratorMail, 4);                
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
            $user = new UserModel();
            $user1 = new UserModel();
            $email = new Email();
            $email1 = new Email();
            $projectModel = new ProjectModel();
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
            $subactivityInfo = $this->objModel->sp_select_info_subactivity($id);                
            $projectInfo = $projectModel->where('Project_id', $subactivityInfo[0]->Project_id)->first();
            $userInfo = $user->where('User_id', $projectInfo['Project_commercial'])->first();
            $commercialMail = $userInfo['User_email'];             
            $userInfo1 = $user1->where('User_id', $projectInfo['User_id'])->first();
            $trafficMail = $userInfo1["User_email"];
            if($projectInfo['Project_percentage'] == 100){
                $email->sendEmail($subactivityInfo, $commercialMail, 8);
                $email1->sendEmail($subactivityInfo, $trafficMail, 8);
            } else {
                $email->sendEmail($subactivityInfo, $commercialMail, 6);
                $email1->sendEmail($subactivityInfo, $trafficMail, 6);
            }                         
        } catch (\Exception $e) {
            $data['message'] = $e;
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = 'Error';
        }
        return json_encode($data);
    }

    public function updateEndDate($data){
        $activityModel = new ActivitiesModel();
        $projectModel = new ProjectModel();
        $Activi_id = $data['Activi_id'];
        $totalFinish = (int) $this->objModel->where('SubAct_percentage', '100')->where('Activi_id', $Activi_id)->countAllResults();
        $total = (int) $this->objModel->where('Activi_id', $Activi_id)->countAllResults();
        $date = date('d-m-y h:i:s');;
        if($totalFinish == $total){
            $activity = $activityModel->where('Activi_id', $Activi_id)->first();
            $activity['Activi_endDate'] =  $date;
            $activityModel->update($Activi_id, $activity);
        }
        return [$totalFinish, $total, $Activi_id, $date];
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
            'SubAct_endDate' => $this->request->getVar('SubAct_endDate'),
            'SubAct_duration' => $this->request->getVar('SubAct_duration'),
            'SubAct_percentage' => $this->request->getVar('SubAct_percentage'),
            'Stat_id' => $this->request->getVar('Stat_id'),
            'Activi_id' => $this->request->getVar('Activi_id'),
            'Priorities_id' => $this->request->getVar('Priorities_id'),
            'User_id' => $this->request->getVar('User_id'),
        ];
        return $data;
    }
}
