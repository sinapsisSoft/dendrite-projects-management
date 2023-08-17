<?php
namespace App\Controllers\DetailProjectUser;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Product\ProductModel;
use App\Models\ManagerBrands\ManagerBrandsModel;
use App\Models\ProjectRequest\ProjectRequestModel;
use App\Models\UserManager\UserManagerModel;
use App\Models\ProjectRequestProduct\ProjectRequestProductModel;


class DetailProjectUser extends BaseController{

    private $objModel;
    private $projectRequestProduct;
    private $primaryKey;
    private $nameModel;
    private $userId;

    public function __construct()
    {
        $this->objModel = new ProjectRequestModel();
        $this->projectRequestProduct = new ProjectRequestProductModel();
        $this->primaryKey = 'ProjReq_id';
        $this->nameModel = 'projects';
        $this->userId = 9; //Id del usuario logueado
    }

    public function show(){
        $product = new ProductModel();
        $brandModel = new ManagerBrandsModel();
        $usermanager = new UserManagerModel();
        $projectRequestId = $this->request->getGet('projectRequestId');

        $data['title'] = 'Detalles';
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');

        $data['toasts'] = view('html/toasts');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('navbar/header');
        $data['footer'] = view('navbar/footer');
        $managerId = $usermanager->where('User_id',$this->userId)->findAll();
        $managerId = $managerId[0]['Manager_id']; 
        $data['brands'] = $brandModel->sp_select_manager_brands($managerId);
        $data['products'] = $product->findAll();
        $data['data'] = [
            'projectrequest' => $this->objModel->sp_select_projectrequest_detail($projectRequestId)[0],
            'projectrequestproducts' => $this->projectRequestProduct->sp_select_projectrequest_product($projectRequestId)
        ];     
        return view('detailsprojectrequest/detailsprojectrequestuser', $data);
    }

    public function create()
    {
        try {
            if ($this->request->isAJAX()) {
                $dataModel = $this->getDataModel(NULL);
                if ($this->projectRequestProduct->insert($dataModel)) {
                    $id = $this->objModel->insertID();
                    $data['ProjReq_product_id'] = $id;
                    $data['message'] = 'success';
                    $data['response'] = ResponseInterface::HTTP_OK;
                    $data['data'] = $dataModel;
                    $data['csrf'] = csrf_hash();
                } else {
                    $data['message'] = 'Error creating product request product';
                    $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                    $data['data'] = '';
                }
            } else {
                $data['message'] = 'Error Ajax';
                $data['response'] = ResponseInterface::HTTP_CONFLICT;
                $data['data'] = '';
            }
        } catch (\Exception $e) {
            $data['message'] = $e;
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = 'Error';
        }
        return json_encode($data);
    }

    public function edit()
    {
        try {
            $id = $this->request->getVar('ProjReq_product_id');
            $getDataId = $this->projectRequestProduct->where('ProjReq_product_id', $id)->first();
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
            $id = $this->request->getVar('ProjReq_product_id');
            $data = $this->getDataModel($id);
            $data['updated_at'] = $today;
            $this->projectRequestProduct->update($id, $data);
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
            $id = $this->request->getVar('ProjReq_product_id');
            if ($this->projectRequestProduct->where('ProjReq_product_id', $id)->delete($id)) {
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
            'ProjReq_product_id' => $getShares,
            'ProjReq_id' => $this->request->getVar('ProjReq_id'),
            'Prod_id' => $this->request->getVar('Prod_id'),
            'ProjReq_product_amount' => $this->request->getVar('ProjReq_product_amount'),
            'updated_at' => $this->request->getVar('updated_at')
        ];
        return $data;
    }
}