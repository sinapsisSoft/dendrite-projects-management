<?php
namespace App\Controllers\Home;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProjectModel;
use DateTime;

class Home extends BaseController{

    private $objModel;
    private $userId;
    private $roleId;

    public function __construct()
    {
        $this->objModel = new ProjectModel();
        $this->userId = 2;//1;//9;//4; //Id del usuario logueado
        $this->roleId = 1;//2;//4;//3; //Id del rol logueado
    }

    public function show(){
        $today = new DateTime();
        $data['title'] = 'Inicio';
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');
        $initialDate = $today->modify('first day of this month')->format("Y-m-d");
        $finalDate = $today->modify('last day of this month')->format("Y-m-d");        

        $data['toasts'] = view('html/toasts');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('navbar/header');
        $data['footer'] = view('navbar/footer');
        $result = $this->objModel->sp_create_general_chart($this->userId, $this->roleId, $initialDate, $finalDate);
        $data['reportName'] = $this->reportTitle($this->roleId);
        if (count($result) > 0){
            $data['chart'] = json_encode($result);
        }
        else {
            $data['chart'] = 0;
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
                $data['data'] = 0;
            }
            $data['reportName'] = $this->reportTitle($this->roleId);
            $data['message'] = 'success';
            $data['response'] = ResponseInterface::HTTP_OK;
            $data['csrf'] = csrf_hash();
        } else {
            $data['message'] = 'Error Ajax';
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
        }
        return json_encode($data);
    }

    public function reportTitle($roleId){
        $reportName = "";
        switch ($roleId) {
            case 1: 
                $reportName = "PROYECTOS POR CLIENTE";
                break;
            case 2: 
                $reportName = "SUBACTIVIDADES POR CLIENTE";
                break;
            case 3: 
                $reportName = "PROYECTOS POR CLIENTE";
                break;
            case 4: 
                $reportName = "PROYECTOS POR MARCA";
                break;
            default:
                $reportName = "SUBACTIVIDADES POR CLIENTE";
                break;
        }
        return $reportName;
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