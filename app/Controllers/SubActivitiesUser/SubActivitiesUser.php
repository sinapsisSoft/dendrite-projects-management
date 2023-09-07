<?php

namespace App\Controllers\SubActivitiesUser;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SubActivities\SubActivitiesModel;
use App\Models\UserStatus\UserStatusModel;
use App\Models\User\UserModel;
use App\Models\Activities\ActivitiesModel;
use App\Models\Mail\MailModel;
use App\Models\Priorities\PrioritiesModel;
use App\Models\Project\ProjectModel;
use App\Utils\Email;
use DateTime;
use PhpParser\Node\Expr\Cast\Array_;

class SubActivitiesUser extends BaseController
{
    private $objModel;
    private $primaryKey;
    private $nameModel;
    private $activities;
    private $userId;

    public function __construct()
    {
        $this->objModel = new SubActivitiesModel();
        $this->primaryKey = 'SubAct_id';
        $this->nameModel = 'subactivities';
        $this->activities = new ActivitiesModel();
        $this->userId = session()->UserId;
    }

    public function show()
    {
        $userstatus = new UserStatusModel();
        $priorities = new PrioritiesModel();
        $user = new UserModel();
        $data['meta'] = view('assets/meta');
        $data['title'] = 'Subactividades';
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');

        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('header/header');
        $data['footer'] = view('footer/footer');

        $data['userstatuses'] = $userstatus->where('StatType_id', 4)->find();
        $data['subactivities'] = $this->objModel->sp_select_subactivity_user($this->userId);
        $data['priorities'] = $priorities->findAll();
        $data['users'] = $user->sp_select_all_users();
        return view('subactivitiesuser/subactivitiesuser', $data);
    }

    public function finishTask()
    {
        if ($this->request->isAJAX()) {
            $today = date("Y-m-d H:i:s");
            $email = new Email();
            $mail = new ProjectModel();
            $status = new UserStatusModel();
            $subactivityId = $this->request->getVar('id');
            $mainMail = $mail->sp_select_user_notification($subactivityId);
            $subActivitie = $this->objModel->sp_select_subactivity_info($subactivityId);
            if ($subActivitie != null){
                $email->sendEmail($subActivitie, $mainMail[0]->User_email, 1);
                $finishStatus = $status->where('Stat_name', 'Realizado')->first();
                $updateSubactivity = [
                    'Stat_id' => $finishStatus["Stat_id"],
                    'SubAct_percentage' => '100',
                    'SubAct_endDate' => date("Y-m-d H:i:s"),
                    'updated_at' => $today
                ];
                $this->objModel->update($subactivityId, $updateSubactivity);
                $this->activities->sp_update_percent_activity($subActivitie[0]->Activi_id);
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
            $percent = $this->request->getVar('SubAct_percentage');
            $dataNew = [
                'SubAct_percentage' => $percent,
                'updated_at' => $today
            ];
            $this->objModel->update($id, $dataNew);
            $data['message'] = 'success';
            $data['response'] = ResponseInterface::HTTP_OK;
            $data['data'] = $id;
            $data['csrf'] = csrf_hash();
            $this->activities->sp_update_percent_activity($id);
        } catch (\Exception $e) {
            $data['message'] = $e;
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = 'Error';
        }
        return json_encode($data);
    }

    public function updateEndDate($data){
        $activityModel = new ActivitiesModel();
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

    public function getDataModel($getShares)
    {
        $data = [
            'SubAct_id' => $getShares,
            'SubAct_name' => $this->request->getVar('SubAct_name'),
            'SubAct_description' => $this->request->getVar('SubAct_description'),
            'SubAct_estimatedEndDate' => $this->request->getVar('SubAct_estimatedEndDate'),
            'SubAct_endDate' => $this->request->getVar('SubAct_endDate'),
            'SubAct_percentage' => $this->request->getVar('SubAct_percentage'),
            'Stat_id' => $this->request->getVar('Stat_id'),
            'Activi_id' => $this->request->getVar('Activi_id'),
            'Priorities_id' => $this->request->getVar('Priorities_id'),
            'User_id' => $this->request->getVar('User_id'),
        ];
        return $data;
    }
}
