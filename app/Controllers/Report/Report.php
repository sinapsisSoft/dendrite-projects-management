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

class Report extends BaseController
{

  private $objModel;
  private $objUserModel;
  private $userId;
  private $roleId;

  public function __construct()
  {
    $this->objModel = new ReportModel();
    $this->objUserModel = new UserModel();
    $this->userId = session()->UserId;
    $this->roleId = $this->objUserModel->sp_select_user_role($this->userId);
  }

  public function show()
  {

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
      case 5:
        $data['dataTable'] = $this->objModel->sp_select_directive_info_table($initialDate, $finalDate);
        $data['dataTable2'] = $this->objModel->sp_select_directive_info_table2($initialDate, $finalDate);
        $chart1 = $this->objModel->sp_select_directive_info_chart1($initialDate, $finalDate);
        $chart3 = $this->objModel->sp_select_directive_info_chart3($initialDate, $finalDate);
        count($chart1) > 0 ? $data['chart1'] = json_encode($chart1) : $data['chart1'] = 0;
        count($chart3) > 0 ? $data['chart3'] = json_encode($chart3) : $data['chart3'] = 0;
        return view('report/directivereport', $data);
        break;
      case 6:
        $data['dataTable'] = $this->objModel->sp_select_administrative_info_table($initialDate, $finalDate);
        $data['dataTable2'] = $this->objModel->sp_select_administrative_info_table2($initialDate, $finalDate);
        $chart1 = $this->objModel->sp_select_administrative_info_chart1($initialDate, $finalDate);
        $chart3 = $this->objModel->sp_select_administrative_info_chart3($initialDate, $finalDate);
        count($chart1) > 0 ? $data['chart1'] = json_encode($chart1) : $data['chart1'] = 0;
        count($chart3) > 0 ? $data['chart3'] = json_encode($chart3) : $data['chart3'] = 0;
        return view('report/administrativereport', $data);
        break;
      case 7:
        $data['dataTable'] = $this->objModel->sp_select_traffic_info_table($initialDate, $finalDate, $this->userId);
        $chart1 = $this->objModel->sp_select_traffic_info_chart1($initialDate, $finalDate, $this->userId);
        $chart2 = $this->objModel->sp_select_traffic_info_chart2($initialDate, $finalDate, $this->userId);
        $chart3 = $this->objModel->sp_select_traffic_info_chart3($initialDate, $finalDate, $this->userId);
        count($chart1) > 0 ? $data['chart1'] = json_encode($chart1) : $data['chart1'] = 0;
        count($chart2) > 0 ? $data['chart2'] = json_encode($chart2) : $data['chart2'] = 0;
        count($chart3) > 0 ? $data['chart3'] = json_encode($chart3) : $data['chart3'] = 0;
        return view('report/trafficreport', $data);
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
        case 5:
          $data['dataTable'] = $this->objModel->sp_select_directive_info_table($initialDate, $finalDate);
          $data['dataTable2'] = $this->objModel->sp_select_directive_info_table2($initialDate, $finalDate);
          $chart1 = $this->objModel->sp_select_directive_info_chart1($initialDate, $finalDate);
          $chart3 = $this->objModel->sp_select_directive_info_chart3($initialDate, $finalDate);
          count($chart1) > 0 ? $data['chart1'] = $chart1 : $data['chart1'] = 0;
          count($chart3) > 0 ? $data['chart3'] = $chart3 : $data['chart3'] = 0;
          break;
        case 6:
          $data['dataTable'] = $this->objModel->sp_select_administrative_info_table($initialDate, $finalDate);
          $data['dataTable2'] = $this->objModel->sp_select_administrative_info_table2($initialDate, $finalDate);
          $chart1 = $this->objModel->sp_select_administrative_info_chart1($initialDate, $finalDate);
          $chart3 = $this->objModel->sp_select_administrative_info_chart3($initialDate, $finalDate);
          count($chart1) > 0 ? $data['chart1'] = $chart1 : $data['chart1'] = 0;
          count($chart3) > 0 ? $data['chart3'] = $chart3 : $data['chart3'] = 0;
          break;
        case 7;
          $data['dataTable'] = $this->objModel->sp_select_traffic_info_table($initialDate, $finalDate, $this->userId);
          $chart1 = $this->objModel->sp_select_traffic_info_chart1($initialDate, $finalDate, $this->userId);
          $chart2 = $this->objModel->sp_select_traffic_info_chart2($initialDate, $finalDate, $this->userId);
          $chart3 = $this->objModel->sp_select_traffic_info_chart3($initialDate, $finalDate, $this->userId);
          count($chart1) > 0 ? $data['chart1'] = $chart1 : $data['chart1'] = 0;
          count($chart2) > 0 ? $data['chart2'] = $chart2 : $data['chart2'] = 0;
          count($chart3) > 0 ? $data['chart3'] = $chart3 : $data['chart3'] = 0;
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
      try {
        $sheet = new Spreadsheet();
        $sheet->getProperties()->setCreator('Made in Casa')->setTitle('Reporte Comercial');
        $sheet->getActiveSheet()->setTitle('Reporte Comercial');

        $activeWorksheet = $sheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'Código');
        $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
        $activeWorksheet->setCellValue('B1', 'Proyecto');
        $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
        $activeWorksheet->setCellValue('C1', 'Orden de compra');
        $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
        $activeWorksheet->setCellValue('D1', 'Cliente');
        $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
        $activeWorksheet->setCellValue('E1', 'País');
        $activeWorksheet->getColumnDimension('E')->setAutoSize(true);
        $activeWorksheet->setCellValue('F1', 'Gerente');
        $activeWorksheet->getColumnDimension('F')->setAutoSize(true);
        $activeWorksheet->setCellValue('G1', 'Marca');
        $activeWorksheet->getColumnDimension('G')->setAutoSize(true);
        $activeWorksheet->setCellValue('H1', 'Fecha inicio proyecto');
        $activeWorksheet->getColumnDimension('H')->setAutoSize(true);
        $activeWorksheet->setCellValue('I1', '% Avance del proyecto');
        $activeWorksheet->getColumnDimension('I')->setAutoSize(true);
        $activeWorksheet->setCellValue('J1', 'Fecha estimada entrega proyecto');
        $activeWorksheet->getColumnDimension('J')->setAutoSize(true);
        $activeWorksheet->setCellValue('K1', 'Fecha finalización del proyecto');
        $activeWorksheet->getColumnDimension('K')->setAutoSize(true);
        $activeWorksheet->setCellValue('L1', 'Tráfico');
        $activeWorksheet->getColumnDimension('L')->setAutoSize(true);
        $activeWorksheet->setCellValue('M1', 'Actividad');
        $activeWorksheet->getColumnDimension('M')->setAutoSize(true);
        $activeWorksheet->setCellValue('N1', 'Producto');
        $activeWorksheet->getColumnDimension('N')->setAutoSize(true);
        $activeWorksheet->setCellValue('O1', 'Fecha estimada entrega actividad');
        $activeWorksheet->getColumnDimension('O')->setAutoSize(true);
        $activeWorksheet->setCellValue('P1', 'Fecha finalización actividad');
        $activeWorksheet->getColumnDimension('P')->setAutoSize(true);
        $activeWorksheet->setCellValue('Q1', 'Subactividad');
        $activeWorksheet->getColumnDimension('Q')->setAutoSize(true);
        $activeWorksheet->setCellValue('R1', 'Colaborador');
        $activeWorksheet->getColumnDimension('R')->setAutoSize(true);        
        $activeWorksheet->setCellValue('S1', '% Avance');
        $activeWorksheet->getColumnDimension('S')->setAutoSize(true);
        $activeWorksheet->setCellValue('T1', 'Fecha estimada entrega subactividad');
        $activeWorksheet->getColumnDimension('T')->setAutoSize(true);
        $activeWorksheet->setCellValue('U1', 'Fecha finalización subactividad');
        $activeWorksheet->getColumnDimension('U')->setAutoSize(true);

        $rowNumber = 2;
        foreach ($tableResult as $row) {
          $activeWorksheet->setCellValue('A' . $rowNumber, $row->Project_code);
          $activeWorksheet->setCellValue('B' . $rowNumber, $row->Project_name);
          $activeWorksheet->setCellValue('C' . $rowNumber, $row->Project_purchaseOrder);
          $activeWorksheet->setCellValue('D' . $rowNumber, $row->Client_name);
          $activeWorksheet->setCellValue('E' . $rowNumber, $row->Country_name);
          $activeWorksheet->setCellValue('F' . $rowNumber, $row->Manager_name);
          $activeWorksheet->setCellValue('G' . $rowNumber, $row->Brand_name);
          $activeWorksheet->setCellValue('H' . $rowNumber, $row->Project_startDate);
          $activeWorksheet->setCellValue('I' . $rowNumber, $row->Project_percentage);
          $activeWorksheet->setCellValue('J' . $rowNumber, $row->Project_estimatedEndDate);
          $activeWorksheet->setCellValue('K' . $rowNumber, $row->Project_activitiEndDate);
          $activeWorksheet->setCellValue('L' . $rowNumber, $row->Project_traffic);
          $activeWorksheet->setCellValue('M' . $rowNumber, $row->Activi_name);
          $activeWorksheet->setCellValue('N' . $rowNumber, $row->Prod_name);
          $activeWorksheet->setCellValue('O' . $rowNumber, $row->Activi_startDate);
          $activeWorksheet->setCellValue('P' . $rowNumber, $row->Activi_endDate);
          $activeWorksheet->setCellValue('Q' . $rowNumber, $row->SubAct_name);
          $activeWorksheet->setCellValue('R' . $rowNumber, $row->User_name);
          $activeWorksheet->setCellValue('S' . $rowNumber, $row->SubAct_percentage);
          $activeWorksheet->setCellValue('T' . $rowNumber, $row->SubAct_estimatedEndDate);
          $activeWorksheet->setCellValue('U' . $rowNumber, $row->SubAct_endDate);
          $rowNumber++;
        }

        $writer = new Xlsx($sheet);
        $download = 'reports/Reporte' . $initialDate . 'a' . $finalDate . '.xlsx';
        $writer->save('reports/Reporte' . $initialDate . 'a' . $finalDate . '.xlsx');
        $data['data'] = $tableResult;
        $data['message'] = 'success';
        $data['response'] = ResponseInterface::HTTP_OK;
        $data['csrf'] = csrf_hash();
        $data['document'] = $download;
        return json_encode($data);
        $sheet->disconnectWorksheets();
        unset($sheet);
      } catch (Exception $e) {
        $data['message'] = 'Error Ajax';
        $data['response'] = ResponseInterface::HTTP_CONFLICT;
      }
    }
  }

  public function createAdministrativeExcel()
  {
    if ($this->request->isAJAX()) {
      $initialDate = $this->request->getVar('initialDate');
      $finalDate = $this->request->getVar('finalDate');
      $tableResult = $this->objModel->sp_select_administrative_info_table($initialDate, $finalDate);
      try {
        $sheet = new Spreadsheet();
        $sheet->getProperties()->setCreator('Made in Casa')->setTitle('Reporte Administrativo');
        $sheet->getActiveSheet()->setTitle('Reporte Admin Solicitudes');

        $activeWorksheet = $sheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', '# Solicitud');
        $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
        $activeWorksheet->setCellValue('B1', 'Cliente');
        $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
        $activeWorksheet->setCellValue('C1', 'Gerente');
        $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
        $activeWorksheet->setCellValue('D1', 'Marca');
        $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
        $activeWorksheet->setCellValue('E1', 'Producto');
        $activeWorksheet->getColumnDimension('E')->setAutoSize(true);
        $activeWorksheet->setCellValue('F1', 'Solicitud');
        $activeWorksheet->getColumnDimension('F')->setAutoSize(true);
        $activeWorksheet->setCellValue('G1', 'Código del proyecto');
        $activeWorksheet->getColumnDimension('G')->setAutoSize(true);
        $activeWorksheet->setCellValue('H1', 'Comercial');
        $activeWorksheet->getColumnDimension('H')->setAutoSize(true);
        $activeWorksheet->setCellValue('I1', 'Estado solicitud');
        $activeWorksheet->getColumnDimension('I')->setAutoSize(true);
        $activeWorksheet->setCellValue('J1', 'Fecha solicitud');
        $activeWorksheet->getColumnDimension('J')->setAutoSize(true);

        $rowNumber = 2;
        foreach ($tableResult as $row) {
          $activeWorksheet->setCellValue('A' . $rowNumber, 'REQ_' . $row->ProjReq_id);
          $activeWorksheet->setCellValue('B' . $rowNumber, $row->Client_name);
          $activeWorksheet->setCellValue('C' . $rowNumber, $row->Manager_name);
          $activeWorksheet->setCellValue('D' . $rowNumber, $row->Brand_name);
          $activeWorksheet->setCellValue('E' . $rowNumber, $row->Prod_name == null ? '' : $row->Prod_name);
          $activeWorksheet->setCellValue('F' . $rowNumber, $row->ProjReq_name);
          $activeWorksheet->setCellValue('G' . $rowNumber, $row->Project_code == null ? '' : $row->Project_code);
          $activeWorksheet->setCellValue('H' . $rowNumber, $row->User_name == null ? '' : $row->User_name);
          $activeWorksheet->setCellValue('I' . $rowNumber, $row->Stat_name);
          $activeWorksheet->setCellValue('J' . $rowNumber, $row->created_at);
          $rowNumber++;
        }

        $writer = new Xlsx($sheet);
        $download = 'reports/Reporte' . $initialDate . 'a' . $finalDate . '.xlsx';
        $writer->save('reports/Reporte' . $initialDate . 'a' . $finalDate . '.xlsx');
        $data['data'] = $tableResult;
        $data['message'] = 'success';
        $data['response'] = ResponseInterface::HTTP_OK;
        $data['csrf'] = csrf_hash();
        $data['document'] = $download;
        return json_encode($data);
        $sheet->disconnectWorksheets();
        unset($sheet);
      } catch (Exception $e) {
        $data['message'] = 'Error Ajax';
        $data['response'] = ResponseInterface::HTTP_CONFLICT;
      }
    }
  }

  public function createAdministrativeExcel2()
  {
    if ($this->request->isAJAX()) {
      $initialDate = $this->request->getVar('initialDate');
      $finalDate = $this->request->getVar('finalDate');
      $tableResult = $this->objModel->sp_select_administrative_info_table2($initialDate, $finalDate);
      try {
        $sheet = new Spreadsheet();
        $sheet->getProperties()->setCreator('Made in Casa')->setTitle('Reporte Administrativo');
        $sheet->getActiveSheet()->setTitle('Reporte Admin Proyectos');

        $activeWorksheet = $sheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'Código');
        $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
        $activeWorksheet->setCellValue('B1', 'Proyecto');
        $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
        $activeWorksheet->setCellValue('C1', 'Orden de compra');
        $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
        $activeWorksheet->setCellValue('D1', 'Cliente');
        $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
        $activeWorksheet->setCellValue('E1', 'País');
        $activeWorksheet->getColumnDimension('E')->setAutoSize(true);
        $activeWorksheet->setCellValue('F1', 'Gerente');
        $activeWorksheet->getColumnDimension('F')->setAutoSize(true);
        $activeWorksheet->setCellValue('G1', 'Marca');
        $activeWorksheet->getColumnDimension('G')->setAutoSize(true);
        $activeWorksheet->setCellValue('H1', 'Fecha inicio proyecto');
        $activeWorksheet->getColumnDimension('H')->setAutoSize(true);
        $activeWorksheet->setCellValue('I1', '% Avance del proyecto');
        $activeWorksheet->getColumnDimension('I')->setAutoSize(true);
        $activeWorksheet->setCellValue('J1', 'Fecha estimada entrega proyecto');
        $activeWorksheet->getColumnDimension('J')->setAutoSize(true);
        $activeWorksheet->setCellValue('K1', 'Fecha finalización del proyecto');
        $activeWorksheet->getColumnDimension('K')->setAutoSize(true);
        $activeWorksheet->setCellValue('L1', 'Comercial');
        $activeWorksheet->getColumnDimension('L')->setAutoSize(true);
        $activeWorksheet->setCellValue('M1', 'Tráfico');
        $activeWorksheet->getColumnDimension('M')->setAutoSize(true);
        $activeWorksheet->setCellValue('N1', 'Actividad');
        $activeWorksheet->getColumnDimension('N')->setAutoSize(true);
        $activeWorksheet->setCellValue('O1', 'Producto');
        $activeWorksheet->getColumnDimension('O')->setAutoSize(true);
        $activeWorksheet->setCellValue('P1', 'Fecha estimada entrega actividad');
        $activeWorksheet->getColumnDimension('P')->setAutoSize(true);
        $activeWorksheet->setCellValue('Q1', 'Fecha finalización actividad');
        $activeWorksheet->getColumnDimension('Q')->setAutoSize(true);
        $activeWorksheet->setCellValue('R1', 'Subactividad');
        $activeWorksheet->getColumnDimension('R')->setAutoSize(true);
        $activeWorksheet->setCellValue('S1', 'Colaborador');
        $activeWorksheet->getColumnDimension('S')->setAutoSize(true);        
        $activeWorksheet->setCellValue('T1', '% Avance');
        $activeWorksheet->getColumnDimension('T')->setAutoSize(true);
        $activeWorksheet->setCellValue('U1', 'Fecha estimada entrega subactividad');
        $activeWorksheet->getColumnDimension('U')->setAutoSize(true);
        $activeWorksheet->setCellValue('V1', 'Fecha finalización subactividad');
        $activeWorksheet->getColumnDimension('V')->setAutoSize(true);

        $rowNumber = 2;
        foreach ($tableResult as $row) {
          $activeWorksheet->setCellValue('A' . $rowNumber, $row->Project_code);
          $activeWorksheet->setCellValue('B' . $rowNumber, $row->Project_name);
          $activeWorksheet->setCellValue('C' . $rowNumber, $row->Project_purchaseOrder);
          $activeWorksheet->setCellValue('D' . $rowNumber, $row->Client_name);
          $activeWorksheet->setCellValue('E' . $rowNumber, $row->Country_name);
          $activeWorksheet->setCellValue('F' . $rowNumber, $row->Manager_name);
          $activeWorksheet->setCellValue('G' . $rowNumber, $row->Brand_name);
          $activeWorksheet->setCellValue('H' . $rowNumber, $row->Project_startDate);
          $activeWorksheet->setCellValue('I' . $rowNumber, $row->Project_percentage);
          $activeWorksheet->setCellValue('J' . $rowNumber, $row->Project_estimatedEndDate);
          $activeWorksheet->setCellValue('K' . $rowNumber, $row->Project_activitiEndDate);
          $activeWorksheet->setCellValue('L' . $rowNumber, $row->Project_commercialName);
          $activeWorksheet->setCellValue('M' . $rowNumber, $row->Project_traffic);
          $activeWorksheet->setCellValue('N' . $rowNumber, $row->Activi_name);
          $activeWorksheet->setCellValue('O' . $rowNumber, $row->Prod_name);
          $activeWorksheet->setCellValue('P' . $rowNumber, $row->Activi_startDate);
          $activeWorksheet->setCellValue('Q' . $rowNumber, $row->Activi_endDate);
          $activeWorksheet->setCellValue('R' . $rowNumber, $row->SubAct_name);
          $activeWorksheet->setCellValue('S' . $rowNumber, $row->User_name);
          $activeWorksheet->setCellValue('T' . $rowNumber, $row->SubAct_percentage);
          $activeWorksheet->setCellValue('U' . $rowNumber, $row->SubAct_estimatedEndDate);
          $activeWorksheet->setCellValue('V' . $rowNumber, $row->SubAct_endDate);
          $rowNumber++;
        }

        $writer = new Xlsx($sheet);
        $download = 'reports/Reporte' . $initialDate . 'a' . $finalDate . '.xlsx';
        $writer->save('reports/Reporte' . $initialDate . 'a' . $finalDate . '.xlsx');
        $data['data'] = $tableResult;
        $data['message'] = 'success';
        $data['response'] = ResponseInterface::HTTP_OK;
        $data['csrf'] = csrf_hash();
        $data['document'] = $download;
        return json_encode($data);
        $sheet->disconnectWorksheets();
        unset($sheet);
      } catch (Exception $e) {
        $data['message'] = 'Error Ajax';
        $data['response'] = ResponseInterface::HTTP_CONFLICT;
      }
    }
  }

  public function createTrafficExcel()
  {
    if ($this->request->isAJAX()) {
      $initialDate = $this->request->getVar('initialDate');
      $finalDate = $this->request->getVar('finalDate');
      $tableResult = $this->objModel->sp_select_traffic_info_table($initialDate, $finalDate, $this->userId);
      try {
        $sheet = new Spreadsheet();
        $sheet->getProperties()->setCreator('Made in Casa')->setTitle('Reporte Tráfico');
        $sheet->getActiveSheet()->setTitle('Reporte Tráfico');

        $activeWorksheet = $sheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'Código');
        $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
        $activeWorksheet->setCellValue('B1', 'Proyecto');
        $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
        $activeWorksheet->setCellValue('C1', 'Orden de compra');
        $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
        $activeWorksheet->setCellValue('D1', 'Cliente');
        $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
        $activeWorksheet->setCellValue('E1', 'País');
        $activeWorksheet->getColumnDimension('E')->setAutoSize(true);
        $activeWorksheet->setCellValue('F1', 'Gerente');
        $activeWorksheet->getColumnDimension('F')->setAutoSize(true);
        $activeWorksheet->setCellValue('G1', 'Marca');
        $activeWorksheet->getColumnDimension('G')->setAutoSize(true);
        $activeWorksheet->setCellValue('H1', 'Fecha inicio proyecto');
        $activeWorksheet->getColumnDimension('H')->setAutoSize(true);
        $activeWorksheet->setCellValue('I1', '% Avance del proyecto');
        $activeWorksheet->getColumnDimension('I')->setAutoSize(true);
        $activeWorksheet->setCellValue('J1', 'Fecha estimada entrega proyecto');
        $activeWorksheet->getColumnDimension('J')->setAutoSize(true);
        $activeWorksheet->setCellValue('K1', 'Fecha finalización del proyecto');
        $activeWorksheet->getColumnDimension('K')->setAutoSize(true);
        $activeWorksheet->setCellValue('L1', 'Comercial');
        $activeWorksheet->getColumnDimension('L')->setAutoSize(true);
        $activeWorksheet->setCellValue('M1', 'Actividad');
        $activeWorksheet->getColumnDimension('M')->setAutoSize(true);
        $activeWorksheet->setCellValue('N1', 'Producto');
        $activeWorksheet->getColumnDimension('N')->setAutoSize(true);
        $activeWorksheet->setCellValue('O1', 'Fecha estimada entrega actividad');
        $activeWorksheet->getColumnDimension('O')->setAutoSize(true);
        $activeWorksheet->setCellValue('P1', 'Fecha finalización actividad');
        $activeWorksheet->getColumnDimension('P')->setAutoSize(true);
        $activeWorksheet->setCellValue('Q1', 'Subactividad');
        $activeWorksheet->getColumnDimension('Q')->setAutoSize(true);
        $activeWorksheet->setCellValue('R1', 'Colaborador');
        $activeWorksheet->getColumnDimension('R')->setAutoSize(true);        
        $activeWorksheet->setCellValue('S1', '% Avance');
        $activeWorksheet->getColumnDimension('S')->setAutoSize(true);
        $activeWorksheet->setCellValue('T1', 'Fecha estimada entrega subactividad');
        $activeWorksheet->getColumnDimension('T')->setAutoSize(true);
        $activeWorksheet->setCellValue('U1', 'Fecha finalización subactividad');
        $activeWorksheet->getColumnDimension('U')->setAutoSize(true);

        $rowNumber = 2;
        foreach ($tableResult as $row) {
          $activeWorksheet->setCellValue('A' . $rowNumber, $row->Project_code);
          $activeWorksheet->setCellValue('B' . $rowNumber, $row->Project_name);
          $activeWorksheet->setCellValue('C' . $rowNumber, $row->Project_purchaseOrder);
          $activeWorksheet->setCellValue('D' . $rowNumber, $row->Client_name);
          $activeWorksheet->setCellValue('E' . $rowNumber, $row->Country_name);
          $activeWorksheet->setCellValue('F' . $rowNumber, $row->Manager_name);
          $activeWorksheet->setCellValue('G' . $rowNumber, $row->Brand_name);
          $activeWorksheet->setCellValue('H' . $rowNumber, $row->Project_startDate);
          $activeWorksheet->setCellValue('I' . $rowNumber, $row->Project_percentage);
          $activeWorksheet->setCellValue('J' . $rowNumber, $row->Project_estimatedEndDate);
          $activeWorksheet->setCellValue('K' . $rowNumber, $row->Project_activitiEndDate);
          $activeWorksheet->setCellValue('L' . $rowNumber, $row->Project_commercialName);
          $activeWorksheet->setCellValue('M' . $rowNumber, $row->Activi_name);
          $activeWorksheet->setCellValue('N' . $rowNumber, $row->Prod_name);
          $activeWorksheet->setCellValue('O' . $rowNumber, $row->Activi_startDate);
          $activeWorksheet->setCellValue('P' . $rowNumber, $row->Activi_endDate);
          $activeWorksheet->setCellValue('Q' . $rowNumber, $row->SubAct_name);
          $activeWorksheet->setCellValue('R' . $rowNumber, $row->User_name);
          $activeWorksheet->setCellValue('S' . $rowNumber, $row->SubAct_percentage);
          $activeWorksheet->setCellValue('T' . $rowNumber, $row->SubAct_estimatedEndDate);
          $activeWorksheet->setCellValue('U' . $rowNumber, $row->SubAct_endDate);
          $rowNumber++;
        }

        $writer = new Xlsx($sheet);
        $download = 'reports/Reporte' . $initialDate . 'a' . $finalDate . '.xlsx';
        $writer->save('reports/Reporte' . $initialDate . 'a' . $finalDate . '.xlsx');
        $data['data'] = $tableResult;
        $data['message'] = 'success';
        $data['response'] = ResponseInterface::HTTP_OK;
        $data['csrf'] = csrf_hash();
        $data['document'] = $download;
        return json_encode($data);
        $sheet->disconnectWorksheets();
        unset($sheet);
      } catch (Exception $e) {
        $data['message'] = 'Error Ajax';
        $data['response'] = ResponseInterface::HTTP_CONFLICT;
      }
    }
  }

  public function createDirectiveExcel()
  {
    if ($this->request->isAJAX()) {
      $initialDate = $this->request->getVar('initialDate');
      $finalDate = $this->request->getVar('finalDate');
      $tableResult = $this->objModel->sp_select_directive_info_table($initialDate, $finalDate);
      try {
        $sheet = new Spreadsheet();
        $sheet->getProperties()->setCreator('Made in Casa')->setTitle('Reporte Directivo');
        $sheet->getActiveSheet()->setTitle('Reporte Direc Solicitudes');

        $activeWorksheet = $sheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', '# Solicitud');
        $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
        $activeWorksheet->setCellValue('B1', 'Cliente');
        $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
        $activeWorksheet->setCellValue('C1', 'Gerente');
        $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
        $activeWorksheet->setCellValue('D1', 'Marca');
        $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
        $activeWorksheet->setCellValue('E1', 'Producto');
        $activeWorksheet->getColumnDimension('E')->setAutoSize(true);
        $activeWorksheet->setCellValue('F1', 'Solicitud');
        $activeWorksheet->getColumnDimension('F')->setAutoSize(true);
        $activeWorksheet->setCellValue('G1', 'Código del proyecto');
        $activeWorksheet->getColumnDimension('G')->setAutoSize(true);
        $activeWorksheet->setCellValue('H1', 'Comercial');
        $activeWorksheet->getColumnDimension('H')->setAutoSize(true);
        $activeWorksheet->setCellValue('I1', 'Estado solicitud');
        $activeWorksheet->getColumnDimension('I')->setAutoSize(true);
        $activeWorksheet->setCellValue('J1', 'Fecha solicitud');
        $activeWorksheet->getColumnDimension('J')->setAutoSize(true);

        $rowNumber = 2;
        foreach ($tableResult as $row) {
          $activeWorksheet->setCellValue('A' . $rowNumber, 'REQ_' . $row->ProjReq_id);
          $activeWorksheet->setCellValue('B' . $rowNumber, $row->Client_name);
          $activeWorksheet->setCellValue('C' . $rowNumber, $row->Manager_name);
          $activeWorksheet->setCellValue('D' . $rowNumber, $row->Brand_name);
          $activeWorksheet->setCellValue('E' . $rowNumber, $row->Prod_name == null ? '' : $row->Prod_name);
          $activeWorksheet->setCellValue('F' . $rowNumber, $row->ProjReq_name);
          $activeWorksheet->setCellValue('G' . $rowNumber, $row->Project_code == null ? '' : $row->Project_code);
          $activeWorksheet->setCellValue('H' . $rowNumber, $row->User_name == null ? '' : $row->User_name);
          $activeWorksheet->setCellValue('I' . $rowNumber, $row->Stat_name);
          $activeWorksheet->setCellValue('J' . $rowNumber, $row->created_at);
          $rowNumber++;
        }

        $writer = new Xlsx($sheet);
        $download = 'reports/Reporte' . $initialDate . 'a' . $finalDate . '.xlsx';
        $writer->save('reports/Reporte' . $initialDate . 'a' . $finalDate . '.xlsx');
        $data['data'] = $tableResult;
        $data['message'] = 'success';
        $data['response'] = ResponseInterface::HTTP_OK;
        $data['csrf'] = csrf_hash();
        $data['document'] = $download;
        return json_encode($data);
        $sheet->disconnectWorksheets();
        unset($sheet);
      } catch (Exception $e) {
        $data['message'] = 'Error Ajax';
        $data['response'] = ResponseInterface::HTTP_CONFLICT;
      }
    }
  }

  public function createDirectiveExcel2()
  {
    if ($this->request->isAJAX()) {
      $initialDate = $this->request->getVar('initialDate');
      $finalDate = $this->request->getVar('finalDate');
      $tableResult = $this->objModel->sp_select_diective_info_table2($initialDate, $finalDate);
      try {
        $sheet = new Spreadsheet();
        $sheet->getProperties()->setCreator('Made in Casa')->setTitle('Reporte Directivo');
        $sheet->getActiveSheet()->setTitle('Reporte Direc Proyectos');

        $activeWorksheet = $sheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'Código');
        $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
        $activeWorksheet->setCellValue('B1', 'Proyecto');
        $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
        $activeWorksheet->setCellValue('C1', 'Orden de compra');
        $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
        $activeWorksheet->setCellValue('D1', 'Cliente');
        $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
        $activeWorksheet->setCellValue('E1', 'País');
        $activeWorksheet->getColumnDimension('E')->setAutoSize(true);
        $activeWorksheet->setCellValue('F1', 'Gerente');
        $activeWorksheet->getColumnDimension('F')->setAutoSize(true);
        $activeWorksheet->setCellValue('G1', 'Marca');
        $activeWorksheet->getColumnDimension('G')->setAutoSize(true);
        $activeWorksheet->setCellValue('H1', 'Fecha inicio proyecto');
        $activeWorksheet->getColumnDimension('H')->setAutoSize(true);
        $activeWorksheet->setCellValue('I1', '% Avance del proyecto');
        $activeWorksheet->getColumnDimension('I')->setAutoSize(true);
        $activeWorksheet->setCellValue('J1', 'Fecha estimada entrega proyecto');
        $activeWorksheet->getColumnDimension('J')->setAutoSize(true);
        $activeWorksheet->setCellValue('K1', 'Fecha finalización del proyecto');
        $activeWorksheet->getColumnDimension('K')->setAutoSize(true);
        $activeWorksheet->setCellValue('L1', 'Comercial');
        $activeWorksheet->getColumnDimension('L')->setAutoSize(true);
        $activeWorksheet->setCellValue('M1', 'Tráfico');
        $activeWorksheet->getColumnDimension('M')->setAutoSize(true);
        $activeWorksheet->setCellValue('N1', 'Actividad');
        $activeWorksheet->getColumnDimension('N')->setAutoSize(true);
        $activeWorksheet->setCellValue('O1', 'Producto');
        $activeWorksheet->getColumnDimension('O')->setAutoSize(true);
        $activeWorksheet->setCellValue('P1', 'Fecha estimada entrega actividad');
        $activeWorksheet->getColumnDimension('P')->setAutoSize(true);
        $activeWorksheet->setCellValue('Q1', 'Fecha finalización actividad');
        $activeWorksheet->getColumnDimension('Q')->setAutoSize(true);
        $activeWorksheet->setCellValue('R1', 'Subactividad');
        $activeWorksheet->getColumnDimension('R')->setAutoSize(true);
        $activeWorksheet->setCellValue('S1', 'Colaborador');
        $activeWorksheet->getColumnDimension('S')->setAutoSize(true);        
        $activeWorksheet->setCellValue('T1', '% Avance');
        $activeWorksheet->getColumnDimension('T')->setAutoSize(true);
        $activeWorksheet->setCellValue('U1', 'Fecha estimada entrega subactividad');
        $activeWorksheet->getColumnDimension('U')->setAutoSize(true);
        $activeWorksheet->setCellValue('V1', 'Fecha finalización subactividad');
        $activeWorksheet->getColumnDimension('V')->setAutoSize(true);

        $rowNumber = 2;
        foreach ($tableResult as $row) {
          $activeWorksheet->setCellValue('A' . $rowNumber, $row->Project_code);
          $activeWorksheet->setCellValue('B' . $rowNumber, $row->Project_name);
          $activeWorksheet->setCellValue('C' . $rowNumber, $row->Project_purchaseOrder);
          $activeWorksheet->setCellValue('D' . $rowNumber, $row->Client_name);
          $activeWorksheet->setCellValue('E' . $rowNumber, $row->Country_name);
          $activeWorksheet->setCellValue('F' . $rowNumber, $row->Manager_name);
          $activeWorksheet->setCellValue('G' . $rowNumber, $row->Brand_name);
          $activeWorksheet->setCellValue('H' . $rowNumber, $row->Project_startDate);
          $activeWorksheet->setCellValue('I' . $rowNumber, $row->Project_percentage);
          $activeWorksheet->setCellValue('J' . $rowNumber, $row->Project_estimatedEndDate);
          $activeWorksheet->setCellValue('K' . $rowNumber, $row->Project_activitiEndDate);
          $activeWorksheet->setCellValue('L' . $rowNumber, $row->Project_commercialName);
          $activeWorksheet->setCellValue('M' . $rowNumber, $row->Project_traffic);
          $activeWorksheet->setCellValue('N' . $rowNumber, $row->Activi_name);
          $activeWorksheet->setCellValue('O' . $rowNumber, $row->Prod_name);
          $activeWorksheet->setCellValue('P' . $rowNumber, $row->Activi_startDate);
          $activeWorksheet->setCellValue('Q' . $rowNumber, $row->Activi_endDate);
          $activeWorksheet->setCellValue('R' . $rowNumber, $row->SubAct_name);
          $activeWorksheet->setCellValue('S' . $rowNumber, $row->User_name);
          $activeWorksheet->setCellValue('T' . $rowNumber, $row->SubAct_percentage);
          $activeWorksheet->setCellValue('U' . $rowNumber, $row->SubAct_estimatedEndDate);
          $activeWorksheet->setCellValue('V' . $rowNumber, $row->SubAct_endDate);
          $rowNumber++;
        }

        $writer = new Xlsx($sheet);
        $download = 'reports/Reporte' . $initialDate . 'a' . $finalDate . '.xlsx';
        $writer->save('reports/Reporte' . $initialDate . 'a' . $finalDate . '.xlsx');
        $data['data'] = $tableResult;
        $data['message'] = 'success';
        $data['response'] = ResponseInterface::HTTP_OK;
        $data['csrf'] = csrf_hash();
        $data['document'] = $download;
        return json_encode($data);
        $sheet->disconnectWorksheets();
        unset($sheet);
      } catch (Exception $e) {
        $data['message'] = 'Error Ajax';
        $data['response'] = ResponseInterface::HTTP_CONFLICT;
      }
    }
  }

}

