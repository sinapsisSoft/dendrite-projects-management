<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\User\UserModel;
use App\Models\UserRole\UserRoleModel;
use App\Models\UserStatus\UserStatusModel;
use App\Models\Company\CompanyModel;



class User extends BaseController
{
    public $dataResult;
    private $objModel;
    private $primaryKey;
    private $nameModel;

    public function __construct()
    {
        $this->objModel = new UserModel();
        $this->primaryKey = 'User_id';
        $this->nameModel = 'users';


    }
    /*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:25/05/2022
*Description:This functions Show overview
*/
    public function show()
    {
        $role = new UserRoleModel();
        $status = new UserStatusModel();
        $company = new CompanyModel();
        $data['title'] = 'Usuarios';
        $data['meta'] = view('assets/meta');
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');
        
        $data['toasts'] = view('html/toasts');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('header/header');
        $data['footer'] = view('footer/footer');

        $data[$this->nameModel] = $this->objModel->sp_select_all_users();
        
        $data['roles'] = $role->orderBy('Role_id', 'ASC')->findAll();
        $data['status'] = $status->sp_select_status_users();
        $data['companys'] = $company->orderBy('Comp_id', 'ASC')->findAll();

        return view('user/user', $data);
    }
    /*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:25/05/2022
*Description:This functions create 
*/
    public function create()
    {
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
    /*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:25/05/2022
*Description:This functions edit 
*/
    public function edit()
    {
        try {
            $id = $this->request->getVar($this->primaryKey);
            $getDataId = $this->objModel->sp_select_user_detail($id);
            // $getDataId = $this->objModel->where($this->primaryKey, $id)->first();
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
    /*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:25/05/2022
*Description:This functions update 
*/
    public function update()
    {
        try {
            $today = date("Y-m-d H:i:s");
            $id = $this->request->getVar($this->primaryKey);
            $data = [
                'User_name' => $this->request->getVar('User_name'),
                'User_email' => $this->request->getVar('User_email'),
                'Role_id' => $this->request->getVar('Role_id'),
                'Stat_id' => $this->request->getVar('Stat_id'),
                'updated_at' => $today
            ];
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
    /*
*Author:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:25/05/2022
*Description:This functions delete 
*/
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
    /*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:25/05/2022
*Description:This functions create datamodel  
*/
    public function getDataModel($getShares)
    {
        $data = [
            'User_id' => $getShares,
            'User_name' => $this->request->getVar('User_name'),
            'User_email' => $this->request->getVar('User_email'),
            'User_password' => $this->objModel->hash($this->request->getVar('User_password')),
            'Comp_id' => $this->request->getVar('Comp_id'),
            'Stat_id' => $this->request->getVar('Stat_id'),
            'Role_id' => $this->request->getVar('Role_id'),
            'updated_at' => $this->request->getVar('updated_at')
        ];
        return $data;
    }
}

