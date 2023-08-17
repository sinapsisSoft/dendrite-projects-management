<?php
namespace App\Controllers\Manager;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Manager\ManagerModel;
use App\Models\Brand\BrandModel;
use App\Models\Client\ClientModel;
use App\Models\ManagerBrands\ManagerBrandsModel;
use App\Models\UserManager\UserManagerModel;
use App\Models\User\UserModel;


class Manager extends BaseController{
    private $objModel;
    private $primaryKey;
    private $nameModel;
    private $managerBrandModel;
    private $usermanagerModel;
    private $userModel;

    public function __construct()
    {
        $this->objModel = new ManagerModel();
        $this->primaryKey = 'Manager_id';
        $this->nameModel = 'manager';
        $this->managerBrandModel = new ManagerBrandsModel();
        $this->usermanagerModel = new UserManagerModel();
        $this->userModel = new UserModel();
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
        $managerBrands = new ManagerBrandsModel();
        try {
            $id = $this->request->getVar($this->primaryKey);
            $getDataId = $this->objModel->where($this->primaryKey, $id)->first();
            $data['message'] = 'success';            
            $data['response'] = ResponseInterface::HTTP_OK;
            $brands = $managerBrands->sp_select_brands_client($getDataId['Client_id']);
            $data['data'] = ["manager" => $getDataId, "brands" => $brands];
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
            $dataModel = $this->getDataModel($id);
            $this->delete_brands_by_manager($id);            
            $dataModel['updated_at'] = $today;
            $this->objModel->update($id, $dataModel);
            $this->usermanagerModel->sp_update_user_email($id);
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

    public function findUser()
    {
        try {
            
            $id = $this->request->getVar($this->primaryKey);
            $getDataId = $this->usermanagerModel->sp_select_user_manager($id);
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

    public function createUser()
    {
        try {            
            $id = $this->request->getVar($this->primaryKey);
            $pass = password_hash($this->request->getVar('User_password'), PASSWORD_BCRYPT);
            $getDataId = $this->usermanagerModel->sp_insert_user_manager($id);
            $data['User_password'] = $pass;
            $this->userModel->update($getDataId[0]->User_id, $data);
            $usermanagerData = [
                'User_id' => $getDataId[0]->User_id,
                'Manager_id' => $id
            ];
            $this->usermanagerModel->insert($usermanagerData);
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

    public function updateUser()
    {
        try {
            $today = date("Y-m-d H:i:s");
            $id = $this->request->getVar($this->primaryKey);
            $status = $this->request->getVar('Stat_id');
            $userId = $this->usermanagerModel->sp_update_user_status($id, $status);            
            $dataUser['updated_at'] = $today;
            $this->userModel->update($userId[0]->User_id, $dataUser);
            $this->usermanagerModel->update($userId[0]->User_id, $dataUser);
            $data['message'] = $dataUser;
            // $data['message'] = 'success';
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