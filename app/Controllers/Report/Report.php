<?php
namespace App\Controllers\Report;

use App\Controllers\BaseController;
use App\Models\Report\ReportModel;
use App\Models\User\UserModel;


class Report extends BaseController{

    private $objModel;
    private $objUserModel;
    private $userId;
    private $roleId;

    public function __construct()
    {   $this->objModel = new ReportModel();
        $this->objUserModel = new UserModel();
        $this->userId = session()->UserId;
        $this->roleId = $this->objUserModel->sp_select_user_role($this->userId);
    }

    public function show(){

        $data['title'] = 'Reportes';
        $data['meta'] = view('assets/meta');
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');

        $data['toasts'] = view('html/toasts');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('header/header');
        $data['footer'] = view('footer/footer');

        switch ($this->roleId) {
            case 1:
                
                return view('report/report', $data);
                break;
            case 2:
                return view('report/report', $data);
                break;
            case 3:                
                $data['dataTable'] = $this->objModel->sp_select_commercial_info_table('2023-01-01', '2023-12-30', $this->userId);
                $chart1 = $this->objModel->sp_select_commercial_info_chart1('2023-01-01', '2023-12-30', $this->userId);
                $chart2 = $this->objModel->sp_select_commercial_info_chart2('2023-01-01', '2023-12-30', $this->userId);
                $chart3 = $this->objModel->sp_select_commercial_info_chart3('2023-01-01', '2023-12-30', $this->userId);
                count($chart1) > 0 ? $data['chart1'] = json_encode($chart1) : $data['chart1'] = 0;
                count($chart2) > 0 ? $data['chart2'] = json_encode($chart2) : $data['chart2'] = 0;
                count($chart3) > 0 ? $data['chart3'] = json_encode($chart3) : $data['chart3'] = 0;
                
                return view('report/commercialreport', $data);
                break;
            case 4:
                return view('report/report', $data);
                break;
            default:
                $reportName = "SUBACTIVIDADES POR CLIENTE";
                break;
        }        
    }    
}