<?php
namespace App\Controllers\Report;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Report\ReportModel;
use App\Models\User\UserModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


use DateTime;
use FFI\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;

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

        $today = new DateTime();
        $data['title'] = 'Reportes';
        $data['meta'] = view('assets/meta');
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');
        $initialDate = $today->modify('first day of this month')->format("Y-m-d");
        $finalDate = $today->modify('last day of this month')->format("Y-m-d");

        $data['toasts'] = view('html/toasts');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('header/header');
        $data['footer'] = view('footer/footer');

        switch ($this->roleId) {
            case 1:
                return view('error', $data);
                break;
            case 2:
                return view('error', $data);
                break;
            case 3:
                $data['dataTable'] = $this->objModel->sp_select_commercial_info_table($initialDate, $finalDate, $this->userId);
                $chart1 = $this->objModel->sp_select_commercial_info_chart1($initialDate, $finalDate, $this->userId);
                $chart2 = $this->objModel->sp_select_commercial_info_chart2($initialDate, $finalDate, $this->userId);
                $chart3 = $this->objModel->sp_select_commercial_info_chart3($initialDate, $finalDate, $this->userId);
                count($chart1) > 0 ? $data['chart1'] = json_encode($chart1) : $data['chart1'] = 0;
                count($chart2) > 0 ? $data['chart2'] = json_encode($chart2) : $data['chart2'] = 0;
                count($chart3) > 0 ? $data['chart3'] = json_encode($chart3) : $data['chart3'] = 0;
                return view('report/commercialreport', $data);
                break;
            case 4:
                return view('error', $data);
                break;
            case 6:
                $data['dataTable'] = $this->objModel->sp_select_commercial_info_table('2023-01-01', '2023-12-31', $this->userId);
                // $data['dataTable'] = $this->objModel->sp_select_commercial_info_table($initialDate, $finalDate, $this->userId);
                // $chart1 = $this->objModel->sp_select_commercial_info_chart1($initialDate, $finalDate, $this->userId);
                // $chart2 = $this->objModel->sp_select_commercial_info_chart2($initialDate, $finalDate, $this->userId);
                // $chart3 = $this->objModel->sp_select_commercial_info_chart3($initialDate, $finalDate, $this->userId);
                // count($chart1) > 0 ? $data['chart1'] = json_encode($chart1) : $data['chart1'] = 0;
                // count($chart2) > 0 ? $data['chart2'] = json_encode($chart2) : $data['chart2'] = 0;
                // count($chart3) > 0 ? $data['chart3'] = json_encode($chart3) : $data['chart3'] = 0;
                return view('report/administrativereport', $data);
                // return view('error', $data);
                break;
            default:
                return view('error', $data);
                break;
        }
    }

    public function createCharts()
    {
        if ($this->request->isAJAX()) {
            $initialDate = $this->request->getVar('initialDate');
            $finalDate = $this->request->getVar('finalDate');
            switch ($this->roleId) {
                case 1:
                    // return view('error');
                    break;
                case 2:
                    // return view('error');
                    break;
                case 3:
                    $data['dataTable'] = $this->objModel->sp_select_commercial_info_table($initialDate, $finalDate, $this->userId);
                    $chart1 = $this->objModel->sp_select_commercial_info_chart1($initialDate, $finalDate, $this->userId);
                    $chart2 = $this->objModel->sp_select_commercial_info_chart2($initialDate, $finalDate, $this->userId);
                    $chart3 = $this->objModel->sp_select_commercial_info_chart3($initialDate, $finalDate, $this->userId);
                    count($chart1) > 0 ? $data['chart1'] = $chart1 : $data['chart1'] = 0;
                    count($chart2) > 0 ? $data['chart2'] = $chart2 : $data['chart2'] = 0;
                    count($chart3) > 0 ? $data['chart3'] = $chart3 : $data['chart3'] = 0;
                    break;
                case 4:
                    // return view('error');
                    break;
                default:
                    // return view('error');
                    break;
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

    public function createCommercialExcel()
    {
        if ($this->request->isAJAX()) {
            $initialDate = $this->request->getVar('initialDate');
            $finalDate = $this->request->getVar('finalDate');
            $tableResult = $this->objModel->sp_select_commercial_info_table($initialDate, $finalDate, $this->userId);
            // try {
                $sheet = new Spreadsheet();
                // $sheet->getProperties()->setCreator('Made in Casa')->setTitle('Reporte Comercial');
                // $sheet->getActiveSheet()->setTitle('Reporte Comercial');

                // $activeWorksheet = $sheet->getActiveSheet();
                // $activeWorksheet->setCellValue('A1', 'Código');
                // $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
                // $activeWorksheet->setCellValue('B1', 'Proyecto');
                // $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
                // $activeWorksheet->setCellValue('C1', 'Cliente');
                // $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
                // $activeWorksheet->setCellValue('D1', 'País');
                // $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
                // $activeWorksheet->setCellValue('E1', 'Actividad');
                // $activeWorksheet->getColumnDimension('E')->setAutoSize(true);
                // $activeWorksheet->setCellValue('F1', 'Producto');
                // $activeWorksheet->getColumnDimension('F')->setAutoSize(true);
                // $activeWorksheet->setCellValue('G1', 'Colaborador');
                // $activeWorksheet->getColumnDimension('G')->setAutoSize(true);
                // $activeWorksheet->setCellValue('H1', 'Subactividad');
                // $activeWorksheet->getColumnDimension('H')->setAutoSize(true);
                // $activeWorksheet->setCellValue('I1', '% Avance');
                // $activeWorksheet->getColumnDimension('I')->setAutoSize(true);
                
                // $rowNumber = 2;
                // foreach ($tableResult as $row){
                //     $activeWorksheet->setCellValue('A'.$rowNumber, $row->Project_code);
                //     $activeWorksheet->setCellValue('B'.$rowNumber, $row->Project_name);
                //     $activeWorksheet->setCellValue('C'.$rowNumber, $row->Client_name);
                //     $activeWorksheet->setCellValue('D'.$rowNumber, $row->Country_name);
                //     $activeWorksheet->setCellValue('E'.$rowNumber, $row->Activi_name);
                //     $activeWorksheet->setCellValue('F'.$rowNumber, $row->Prod_name);
                //     $activeWorksheet->setCellValue('G'.$rowNumber, $row->User_name);
                //     $activeWorksheet->setCellValue('H'.$rowNumber, $row->SubAct_name);
                //     $activeWorksheet->setCellValue('I'.$rowNumber, $row->SubAct_percentage);
                //     $rowNumber++;
                // }
    
                // $writer = new Xlsx($sheet);
                // $download = 'reports/Reporte'.$initialDate.'a'.$finalDate.'.xlsx';
                // $writer->save('reports/Reporte'.$initialDate.'a'.$finalDate.'.xlsx');
                $data['data'] = $tableResult;
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['csrf'] = csrf_hash();
                // $data['document'] = $download;
                return json_encode($data);
                // $sheet->disconnectWorksheets();
                unset($sheet);
            // }
            // catch(Exception $e){
            //     $data['message'] = 'Error Ajax';
            //     $data['response'] = ResponseInterface::HTTP_CONFLICT;
            // }
        }
        
        
    }
}