<?php
namespace App\Controllers\Client;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Client\ClientModel;
use App\Models\Company\CompanyModel;
use App\Models\DocTypeModel\DocTypeModel;
use App\Models\UserStatus\UserStatusModel;
use App\Models\Country\CountryModel;


class Client extends BaseController{
    private $objModel;
    private $primaryKey;
    private $nameModel;

    public function __construct()
    {
        $this->objModel = new ClientModel();
        $this->primaryKey = 'Client_id';
        $this->nameModel = 'clients';
    }

    public function show(){
        $doctype = new DocTypeModel();
        $userstatus = new UserStatusModel();
        $company = new CompanyModel();
        $country = new CountryModel();
        $data['title'] = 'Clientes';
        $data['meta'] = view('assets/meta');
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');

        $data['toasts'] = view('html/toasts');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('header/header');
        $data['footer'] = view('footer/footer');

        $data[$this->nameModel] = $this->objModel->findAll();
        $data['doctypes'] = $doctype->findAll();
        $data['userstatuses'] = $userstatus->sp_select_status_users();
        $data['companies'] = $company->findAll();
        $data['countries'] = $country->findAll();
        return view('client/client', $data);
    }

    public function create(){
        if ($this->request->isAJAX()) {
            $dataModel = $this->getDataModel(NULL);
            if ($this->objModel->insert($dataModel)) {
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
            $data = $this->getDataModel($id);
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

    public function findCountry(){
        try{
            $clientId = $this->request->getVar('clientId');
            $city = $this->objModel->sp_select_country_client($clientId);
            $data['message'] = 'success';
            $data['response'] = ResponseInterface::HTTP_OK;
            $data['data'] = $city;
            $data['csrf'] = csrf_hash();
        }catch (\Exception $e) {
            $data['message'] = $e;
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = 'Error';
        }
        return json_encode($data);
    }

    public function getDataModel($getShares)
    {
        $data = [
            'Client_id' => $getShares,
            'Client_name' => $this->request->getVar('Client_name'),
            'Client_identification' => $this->request->getVar('Client_identification'),
            'Client_email' => $this->request->getVar('Client_email'),
            'Client_phone' => $this->request->getVar('Client_phone'),
            'Client_address' => $this->request->getVar('Client_address'),
            'DocType_id' => $this->request->getVar('DocType_id'),
            'Stat_id' => $this->request->getVar('Stat_id'),
            'Comp_id' => $this->request->getVar('Comp_id'),
            'Country_id' => $this->request->getVar('Country_id'),
            'updated_at' => $this->request->getVar('updated_at')
        ];
        return $data;
    }
}