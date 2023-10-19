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
      case 6:
        $data['dataTable'] = $this->objModel->sp_select_administrative_info_table($initialDate, $finalDate);
        $data['dataTable2'] = $this->objModel->sp_select_administrative_info_table2($initialDate, $finalDate);
        $chart1 = $this->objModel->sp_select_administrative_info_chart1($initialDate, $finalDate);
        // $chart2 = $this->objModel->sp_select_commercial_info_chart2($initialDate, $finalDate, $this->userId);
        $chart3 = $this->objModel->sp_select_administrative_info_chart3($initialDate, $finalDate);
        count($chart1) > 0 ? $data['chart1'] = json_encode($chart1) : $data['chart1'] = 0;
        // count($chart2) > 0 ? $data['chart2'] = json_encode($chart2) : $data['chart2'] = 0;
        count($chart3) > 0 ? $data['chart3'] = json_encode($chart3) : $data['chart3'] = 0;
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
        case 6:
          $data['dataTable'] = $this->objModel->sp_select_administrative_info_table($initialDate, $finalDate);
          $data['dataTable2'] = $this->objModel->sp_select_administrative_info_table2($initialDate, $finalDate);
          $chart1 = $this->objModel->sp_select_administrative_info_chart1($initialDate, $finalDate);
          // $chart2 = $this->objModel->sp_select_commercial_info_chart2($initialDate, $finalDate, $this->userId);
          $chart3 = $this->objModel->sp_select_administrative_info_chart3($initialDate, $finalDate);
          count($chart1) > 0 ? $data['chart1'] = $chart1 : $data['chart1'] = 0;
          // count($chart2) > 0 ? $data['chart2'] = json_encode($chart2) : $data['chart2'] = 0;
          count($chart3) > 0 ? $data['chart3'] = $chart3 : $data['chart3'] = 0;
          // return view('error', $data);
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
        $activeWorksheet->setCellValue('C1', 'Cliente');
        $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
        $activeWorksheet->setCellValue('D1', 'País');
        $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
        $activeWorksheet->setCellValue('E1', 'Actividad');
        $activeWorksheet->getColumnDimension('E')->setAutoSize(true);
        $activeWorksheet->setCellValue('F1', 'Producto');
        $activeWorksheet->getColumnDimension('F')->setAutoSize(true);
        $activeWorksheet->setCellValue('G1', 'Colaborador');
        $activeWorksheet->getColumnDimension('G')->setAutoSize(true);
        $activeWorksheet->setCellValue('H1', 'Subactividad');
        $activeWorksheet->getColumnDimension('H')->setAutoSize(true);
        $activeWorksheet->setCellValue('I1', '% Avance');
        $activeWorksheet->getColumnDimension('I')->setAutoSize(true);

        $rowNumber = 2;
        foreach ($tableResult as $row) {
          $activeWorksheet->setCellValue('A' . $rowNumber, $row->Project_code);
          $activeWorksheet->setCellValue('B' . $rowNumber, $row->Project_name);
          $activeWorksheet->setCellValue('C' . $rowNumber, $row->Client_name);
          $activeWorksheet->setCellValue('D' . $rowNumber, $row->Country_name);
          $activeWorksheet->setCellValue('E' . $rowNumber, $row->Activi_name);
          $activeWorksheet->setCellValue('F' . $rowNumber, $row->Prod_name);
          $activeWorksheet->setCellValue('G' . $rowNumber, $row->User_name);
          $activeWorksheet->setCellValue('H' . $rowNumber, $row->SubAct_name);
          $activeWorksheet->setCellValue('I' . $rowNumber, $row->SubAct_percentage);
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

  public function createadministrativeExcel()
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
        $activeWorksheet->setCellValue('A1', 'Cliente');
        $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
        $activeWorksheet->setCellValue('B1', 'Manager');
        $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
        $activeWorksheet->setCellValue('C1', 'Marca');
        $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
        $activeWorksheet->setCellValue('D1', 'Producto');
        $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
        $activeWorksheet->setCellValue('E1', 'Solicitud');
        $activeWorksheet->getColumnDimension('E')->setAutoSize(true);
        $activeWorksheet->setCellValue('F1', 'Código del proyecto');
        $activeWorksheet->getColumnDimension('F')->setAutoSize(true);
        $activeWorksheet->setCellValue('G1', 'Comercial');
        $activeWorksheet->getColumnDimension('G')->setAutoSize(true);
        $activeWorksheet->setCellValue('H1', 'Estado solicitud');
        $activeWorksheet->getColumnDimension('H')->setAutoSize(true);

        $rowNumber = 2;
        foreach ($tableResult as $row) {
          $activeWorksheet->setCellValue('A' . $rowNumber, $row->Client_name);
          $activeWorksheet->setCellValue('B' . $rowNumber, $row->Manager_name);
          $activeWorksheet->setCellValue('C' . $rowNumber, $row->Brand_name);
          $activeWorksheet->setCellValue('D' . $rowNumber, $row->Prod_name);
          $activeWorksheet->setCellValue('E' . $rowNumber, $row->ProjReq_name);
          $activeWorksheet->setCellValue('F' . $rowNumber, $row->Project_code);
          $activeWorksheet->setCellValue('G' . $rowNumber, $row->User_name);
          $activeWorksheet->setCellValue('H' . $rowNumber, $row->Stat_name);
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

  public function createadministrativeExcel2()
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
        $activeWorksheet->setCellValue('A1', 'Cliente');
        $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
        $activeWorksheet->setCellValue('B1', 'País');
        $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
        $activeWorksheet->setCellValue('C1', 'Manager');
        $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
        $activeWorksheet->setCellValue('D1', 'Marca');
        $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
        $activeWorksheet->setCellValue('E1', 'Comercial');
        $activeWorksheet->getColumnDimension('E')->setAutoSize(true);
        $activeWorksheet->setCellValue('F1', 'Tráfico');
        $activeWorksheet->getColumnDimension('F')->setAutoSize(true);
        $activeWorksheet->setCellValue('G1', '% Avance');
        $activeWorksheet->getColumnDimension('G')->setAutoSize(true);
        $activeWorksheet->setCellValue('H1', 'Fecha inicio');
        $activeWorksheet->getColumnDimension('H')->setAutoSize(true);
        $activeWorksheet->setCellValue('I1', 'Fecha estimada finalización');
        $activeWorksheet->getColumnDimension('I')->setAutoSize(true);
        $activeWorksheet->setCellValue('J1', 'Fecha finalización real');
        $activeWorksheet->getColumnDimension('J')->setAutoSize(true);
        $activeWorksheet->setCellValue('K1', 'Fecha creación proyecto');
        $activeWorksheet->getColumnDimension('K')->setAutoSize(true);

        $rowNumber = 2;
        foreach ($tableResult as $row) {
          $activeWorksheet->setCellValue('A' . $rowNumber, $row->Client_name);
          $activeWorksheet->setCellValue('B' . $rowNumber, $row->Country_name);
          $activeWorksheet->setCellValue('C' . $rowNumber, $row->Manager_name);
          $activeWorksheet->setCellValue('D' . $rowNumber, $row->Brand_name);
          $activeWorksheet->setCellValue('E' . $rowNumber, $row->Project_commercial);
          $activeWorksheet->setCellValue('F' . $rowNumber, $row->User_name);
          $activeWorksheet->setCellValue('G' . $rowNumber, $row->Project_percentage == null ? 0 : $row->Project_percentage);
          $activeWorksheet->setCellValue('H' . $rowNumber, $row->Project_startDate);
          $activeWorksheet->setCellValue('I' . $rowNumber, $row->Project_estimatedEndDate);
          $activeWorksheet->setCellValue('J' . $rowNumber, $row->Project_activitiEndDate);
          $activeWorksheet->setCellValue('K' . $rowNumber, $row->created_at);
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

