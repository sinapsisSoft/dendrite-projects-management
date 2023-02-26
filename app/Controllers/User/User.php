<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\UserRole;
use App\Models\UserStatus;
use App\Models\Company;


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

    public function show()
    {
        
        $role = new UserRole();
        $status = new UserStatus();
        $company = new Company();

        $data['title'] = 'USERS';
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');
        $data['toasts'] = view('html/toasts');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('navbar/header');
        $data['footer'] = view('navbar/footer');

        $data[$this->nameModel] = $this->objModel->sp_select_all_users();
        $data['roles'] = $role->orderBy('Role_id', 'ASC')->findAll();
        $data['status'] = $status->sp_select_status_users();
        $data['companys'] = $company->orderBy('Comp_id', 'ASC')->findAll();

        return view('user/user', $data);
    }


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


    public function getDataModel($getShares)
    {

        $data = [
            'User_id' => $getShares,
            'User_email' => $this->request->getVar('User_email'),
            'User_password' => password_hash($this->request->getVar('User_password'),PASSWORD_DEFAULT),
            'Comp_id' => $this->request->getVar('Comp_id'),
            'Stat_id' => $this->request->getVar('Stat_id'),
            'Role_id' => $this->request->getVar('Role_id')
        ];

        return $data;
    }
}
