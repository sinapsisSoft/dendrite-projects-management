<?php
namespace App\Controllers\Manager;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ManagerModel;
use App\Models\BrandModel;
use App\Models\ClientModel;
use App\Models\ManagerBrandsModel;


class Manager extends BaseController{
    private $objModel;
    private $primaryKey;
    private $nameModel;
    private $managerBrandModel;

    public function __construct()
    {
        $this->objModel = new ManagerModel();
        $this->primaryKey = 'Manager_id';
        $this->nameModel = 'managers';
        $this->managerBrandModel = new ManagerBrandsModel();
    }

    public function show(){
        $brand = new BrandModel();
        $client = new ClientModel();
        $data['title'] = 'Gerentes';
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');

        $data['toasts'] = view('html/toasts');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('navbar/header');
        $data['footer'] = view('navbar/footer');

        $data[$this->nameModel] = $this->objModel->findAll();
        $data['clients'] = $client->findAll();
        $data['brands'] = $brand->findAll();
        return view('manager/manager', $data);
    }

    public function create(){
        if ($this->request->isAJAX()) {
            $dataModel = $this->getDataModel(NULL);
            if ($this->objModel->insert($dataModel)) {
                $managerId = $this->objModel->insertID();
                $this->save_brands($managerId);
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

    public function save_brands($managerId){
        $brands = $this->request->getVar('Brands');
        foreach($brands as $brand){
            $this->managerBrandModel->insert(["Brand_id" => $brand, "Manager_id" => $managerId]);
        }
    }

    public function delete_brands_by_manager($managerId){
        $this->managerBrandModel->where('Manager_id', $managerId)->delete();
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

    public function findByClient(){
        try{
            $clientId = $this->request->getVar('clientId');
            $managers = $this->objModel->where('Client_id', $clientId)->find();
            $data['message'] = 'success';
            $data['response'] = ResponseInterface::HTTP_OK;
            $data['data'] = $managers;
            $data['csrf'] = csrf_hash();
        }catch (\Exception $e) {
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
            $this->delete_brands_by_manager($id);
            $data['updated_at'] = $today;
            $this->objModel->update($id, $data);
            $this->save_brands($id);
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
            $this->delete_brands_by_manager($id);
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
            'Manager_id' => $getShares,
            'Manager_name' => $this->request->getVar('Manager_name'),
            'Manager_email' => $this->request->getVar('Manager_email'),
            'Manager_phone' => $this->request->getVar('Manager_phone'),
            'Client_id' => $this->request->getVar('Client_id'),
            'updated_at' => $this->request->getVar('updated_at')
        ];
        return $data;
    }
}