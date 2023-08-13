<?php
/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:13/08/2023
*Description:General Home management class
*/
namespace App\Controllers\Home;

use App\Controllers\BaseController;

use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Project\ProjectModel;
use App\Models\User\UserModel;
use DateTime;

class Home extends BaseController{

    private $objModel;
    private $objUserModel;
    private $userId;
    private $roleId;
    private $primaryKey;
    private $nameModel;

    public function __construct()
    {
        $this->objModel = new ProjectModel();
        $this->objUserModel = new UserModel();
        $this->primaryKey = 'User_id';
        $this->nameModel = 'users';
        $this->userId =session()->UserId;
        $this->roleId =$this->objUserModel->sp_select_user_role($this->userId);
        
    }

    public function show(){

        $data['userId'] =$this->userId; 
        $today = new DateTime();
       $data['title'] = 'Inicio';
        $data['meta'] = view('assets/meta');
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');
         $initialDate = $today->modify('first day of this month')->format("Y-m-d");
        $finalDate = $today->modify('last day of this month')->format("Y-m-d");

        $data['toasts'] = view('html/toasts');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('header/header');
        $data['footer'] = view('footer/footer');

       $result = $this->objModel->sp_create_general_chart($this->userId, $this->roleId->Role_id, $initialDate, $finalDate);
       if (count($result) > 0){
            $data['chart'] = json_encode($result);
        }
        else {
            $data['chart'] = "";
        }

        return view('home/home', $data);

       
    } 

    public function chart(){
        if ($this->request->isAJAX()) {
            $initialDate = $this->request->getVar('initialDate');
            $finalDate = $this->request->getVar('finalDate');
            $result = $this->objModel->sp_create_general_chart($this->userId, $this->roleId, $initialDate, $finalDate);
            if (count($result) > 0) {
                $data['data'] = $result;
            } else {
                $data['data'] = "";
            }
            $data['message'] = 'success';
            $data['response'] = ResponseInterface::HTTP_OK;
            $data['csrf'] = csrf_hash();
        } else {
            $data['message'] = 'Error Ajax';
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
        }
        return json_encode($data);
    }

    public function getDataModel()
    {
        $data = [
            'initialDate' => $this->request->getVar('initialDate'),
            'finalDate' => $this->request->getVar('finalDate')
        ];
        return $data;
    }
}