<?php

namespace App\Controllers\Project;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProjectModel;
use App\Models\ClientModel;
use App\Models\CountryModel;
use App\Models\UserModel;
use App\Models\UserStatusModel;
use App\Models\ManagerModel;
use App\Models\BrandModel;
use App\Models\MailModel;
use App\Models\PrioritiesModel;
use App\Utils\Email;

class Project extends BaseController
{
    private $objModel;
    private $primaryKey;
    private $nameModel;

    public function __construct()
    {
        $this->objModel = new ProjectModel();
        $this->primaryKey = 'Project_id';
        $this->nameModel = 'projects';
    }

    public function show()
    {
        $priorities = new PrioritiesModel();
        $client = new CLientModel();        
        $user = new UserModel();
        $userstatus = new UserStatusModel();  
        $manager = new ManagerModel();    
        $brand = new BrandModel();
        $country = new CountryModel();

        $data['title'] = 'Proyectos';
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');
        $data['toasts'] = view('html/toasts');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('navbar/header');
        $data['footer'] = view('navbar/footer');

        $data[$this->nameModel] = $this->objModel->sp_select_all_project_table();
        $data['clients'] = $client->findAll();
        $data['commercial'] = $user->sp_select_all_users_comercial();
        $data['users'] = $user->sp_select_all_users();
        $data['userstatuses'] = $userstatus->sp_select_status_users();
        $data['priorities'] = $priorities->findAll();
        $data['managers'] = $manager->findAll();
        $data['brands'] = $brand->findAll();
        $data['countries'] = $country->findAll();
        return view('project/project', $data);
    }

    public function create()
    {
        $codeProject = '';
        $user = new UserModel();
        $mail = new MailModel();
        $email = new Email();
        $mainMail = $mail->findAll()[0]["Mail_user"];
        if ($this->request->isAJAX()) {
            $dataModel = $this->getDataModel(NULL, $codeProject);
            if ($this->objModel->insert($dataModel)) {
                $id = $this->objModel->insertID();
                $codeProject = $this->generateCode((string) $id);
                //Aqui se trae el correo de la persona a la cual se va a notificar
                $userEmail = $user->where("User_id", $dataModel["User_id"])->first();
                $dataModel['Project_id'] = $id;
                $this->objModel->update($id, array_merge($dataModel, ["Project_code" => $codeProject]));
                $projectInfo = $this->objModel->sp_select_info_project($id);
                if ($projectInfo != null){
                    $email->sendEmail($projectInfo, $mainMail, 3);
                    $data['message'] = 'success';
                    $data['response'] = ResponseInterface::HTTP_OK;
                }
                else {
                    $data['message'] = 'Error sending email';
                    $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                    
                }
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
            $data['data'] = $mainMail;
        }
        return json_encode($data);
    }

    public function edit()
    {
        try {            
            $manager = new ManagerModel();    
            $brand = new BrandModel();
            $client = new ClientModel();
            $id = $this->request->getVar($this->primaryKey);
            $getDataId = $this->objModel->where($this->primaryKey, $id)->first(); 
            $data['clients'] = $client->findAll();
            $data['managers'] = $manager->findAll();
            $data['brands'] = $brand->findAll();
            $country = $client->select('client.Country_id')
            ->where("Client_id", $getDataId["Client_id"])->first(); 
            $data['data'] = $country;
            $data['message'] = 'success';
            $data['response'] = ResponseInterface::HTTP_OK;
            $data['data'] += $getDataId;
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
            $code = $this->generateCode((string) $id);
            $data = $this->getDataModel($id, $code);
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

    public function generateCode($id){
        return "PRO_".str_pad($id, 3, '0', STR_PAD_LEFT);
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

    public function getDataModel($getShares, $code = '')
    {
        $data = [
            'Project_id' => $getShares,
            'Project_code' => $code,
            'Project_name' => $this->request->getVar('Project_name'),
            'Project_purchaseOrder' => $this->request->getVar('Project_purchaseOrder'),
            'Project_ddtStartDate' => $this->request->getVar('Project_ddtStartDate'),
            'Project_ddtEndDate' => $this->request->getVar('Project_ddtEndDate'),
            'Project_startDate' => $this->request->getVar('Project_startDate'),
            'Project_estimatedEndDate' => $this->request->getVar('Project_estimatedEndDate'),
            'Project_activitiEndDate' => $this->request->getVar('Project_activitiEndDate'),
            'Project_percentage' => $this->request->getVar('Project_percentage'),
            'Project_observation' => $this->request->getVar('Project_observation'),
            'Client_id' => $this->request->getVar('Client_id'),
            'Manager_id' => $this->request->getVar('Manager_id'),
            'Brand_id' => $this->request->getVar('Brand_id'),
            'Project_commercial' => $this->request->getVar('Project_commercial'),
            'Stat_id' => $this->request->getVar('Stat_id'),
            'User_id' => $this->request->getVar('User_id'),
            'Priorities_id' => $this->request->getVar('Priorities_id'),
            'updated_at' => $this->request->getVar('updated_at')
        ];
        return $data;
    }
}
