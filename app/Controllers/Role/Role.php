<?php

namespace App\Controllers\Role;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserRole;
use App\Models\RoleModuleModel;
use App\Models\RoleModulePermitModel;
use App\Models\PermitModel;
use App\Models\ModuleModel;

class Role extends BaseController
{
    private $objModel;
    private $primaryKey;
    private $nameModel;
    private $roleModule;
    private $roleModulePermit;

    public function __construct()
    {
        $this->objModel = new UserRole();
        $this->roleModule = new RoleModuleModel();
        $this->roleModulePermit = new RoleModulePermitModel();
        $this->primaryKey = "Role_id";
        $this->nameModel = "roles";
    }

    public function show()
    {
        $permits = new PermitModel();
        $modules = new ModuleModel();

        $data['title'] = 'Roles';
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');

        $data['toasts'] = view('html/toasts');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('navbar/header');
        $data['footer'] = view('navbar/footer');

        $data[$this->nameModel] = $this->objModel->findAll();
        $data['permits'] = $permits->findAll();
        $data['modules'] = $modules->findAll();

        return view('role/role', $data);
    }

    public function create()
    {
        if ($this->request->isAJAX()) {
            $dataModel = $this->getDataModel(NULL);
            if ($this->objModel->insert($dataModel)) {
                $roleId = $this->objModel->insertID();
                $this->save_module_role($roleId);
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

    public function update()
    {
        try {
            $today = date("Y-m-d H:i:s");
            $id = $this->request->getVar($this->primaryKey);
            $this->delete_module_role($id);
            $data = $this->getDataModel($id);
            $this->save_module_role($id);
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

    public function save_module_role($roleId)
    {
        $modules = $this->request->getVar('modules');
        foreach ($modules as $module) {
            $object = explode(";", $module);
            $this->roleModule->insert(["Role_id" => $roleId, "Mod_id" => $object[0]]);
            $roleModuleId = $this->roleModule->insertID();
            $permits = explode(",", $object[1]);
            foreach ($permits as $permit) {
                $this->roleModulePermit->insert(["Perm_id" => $permit, "Role_mod_id" => $roleModuleId]);
            }
        }
    }

    public function edit()
    {
        try {
            $id = $this->request->getVar($this->primaryKey);
            $getDataId = $this->objModel->where($this->primaryKey, $id)->first();
            $data['message'] = 'success';
            $data['response'] = ResponseInterface::HTTP_OK;
            $data['data'] = ["role" => $getDataId, "modules" => $this->objModel->sp_select_modules_role($id)];
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
            $this->delete_module_role($id);
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

    public function delete_module_role($roleId){
        $this->roleModule->delete([$this->primaryKey => $roleId]);
        $roleModules = $this->roleModule->where($this->primaryKey, $roleId)->findAll();
        foreach($roleModules as $roleModule){
            $roleModIdColumn = 'Role_mod_id';
            $roleModId = $roleModule[$roleModIdColumn];
            //$this->roleModulePermit->where($roleModIdColumn, $roleModId)->delete($roleModId);
            $this->roleModule->where($roleModIdColumn, $roleModId)->delete($roleModId);
        }
    }

    public function getDataModel($getShares)
    {
        $data = [
            'Role_id' => $getShares,
            'Role_name' => $this->request->getVar('Role_name'),
            'updated_at' => $this->request->getVar('updated_at')
        ];
        return $data;
    }
}
