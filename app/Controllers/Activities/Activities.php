<?php

namespace App\Controllers\Activities;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Activities\ActivitiesModel;
use App\Models\UserStatus\UserStatusModel;
use App\Models\ProjectProduct\ProjectProductModel;

class Activities extends BaseController
{
  private $objModel;
  private $primaryKey;
  private $nameModel;

  public function __construct()
  {
    $this->objModel = new ActivitiesModel();
    $this->primaryKey = 'Activi_id';
    $this->nameModel = 'activities';
  }

  public function show()
  {
    $userstatus = new UserStatusModel();
    $projectproduct = new ProjectProductModel();
    $data['title'] = 'Actividad';
    $data['css'] = view('assets/css');
    $data['js'] = view('assets/js');

    $data['toasts'] = view('html/toasts');
    $data['sidebar'] = view('navbar/sidebar');
    $data['header'] = view('navbar/header');
    $data['footer'] = view('navbar/footer');

    $data[$this->nameModel] = $this->objModel->sp_select_all_activities();
    $data['userstatuses'] = $userstatus->sp_select_status_users();
    $data['projectproducts'] = $projectproduct->findAll();
    return view('activities/activities', $data);
  }


  public function create()
  {
    $codeProject = '';
    if ($this->request->isAJAX()) {
      $dataModel = $this->getDataModel(NULL, $codeProject);
      if ($this->objModel->insert($dataModel)) {
        $id = $this->objModel->insertID();
        $codeActivities = $this->generateCode((string) $id);
        $dataModel['Activi_id'] = $id;
        $this->objModel->update($id, array_merge($dataModel, ["Activi_code" => $codeActivities]));
        $data['message'] = 'success';
        $data['response'] = ResponseInterface::HTTP_OK;
        $data['data'] = $dataModel;
        $data['csrf'] = csrf_hash();
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
      $codeActivities = $this->generateCode((string) $id);
      $data = $this->getDataModel($id);
      $data['updated_at'] = $today;
      $this->objModel->update($id, array_merge($data, ["Activi_code" => $codeActivities]));
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
  public function generateCode($id)
  {
    return "ACT_" . str_pad($id, 3, '0', STR_PAD_LEFT);
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

  public function getDataModel($getShares)
  {
    $data = [
      'Activi_id' => $getShares,
      'Activi_name' => $this->request->getVar('Activi_name'),
      'Activi_observation' => $this->request->getVar('Activi_observation'),
      'Activi_startDate' => $this->request->getVar('Activi_startDate'),
      'Activi_endDate' => $this->request->getVar('Activi_endDate'),
      'Activi_link' => $this->request->getVar('Activi_link'),
      'ApprCode_id' => $this->request->getVar('ApprCode_id'),
      'Activi_codeMiigo' => $this->request->getVar('Activi_codeMiigo'),
      'Activi_codeSpectra' => $this->request->getVar('Activi_codeSpectra'),
      'Activi_codeDelivery' => $this->request->getVar('Activi_codeDelivery'),
      'Activi_percentage' => $this->request->getVar('Activi_percentage') == null ? 0  : $this->request->getVar('Activi_percentage'),
      'Stat_id' => $this->request->getVar('Stat_id'),
      'Project_product_id' => $this->request->getVar('Project_product_id'),
      'updated_at' => $this->request->getVar('updated_at')
    ];
    return $data;
  }
}
