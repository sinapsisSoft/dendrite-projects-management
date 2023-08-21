<?php

namespace App\Controllers\Product;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Product\ProductModel;
use App\Models\Filing\FilingModel;
use App\Models\ProductBrand\ProductBrandModel;


class Product extends BaseController
{
    private $objModel;
    private $primaryKey;
    private $nameModel;

    public function __construct()
    {
        $this->objModel = new ProductModel();
        $this->primaryKey = 'Prod_id';
        $this->nameModel = 'products';
    }

    public function show()
    {
        $filing = new FilingModel();
        $productbrand = new ProductBrandModel();
    
        $data['meta'] = view('assets/meta');
        $data['title'] = 'Productos';
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');

        $data['toasts'] = view('html/toasts');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('header/header');
        $data['footer'] = view('footer/footer');

        $data[$this->nameModel] = $this->objModel->findAll();
        $data['filings'] = $filing->findAll();
        $data['productbrands'] = $productbrand->findAll();
        return view('product/product', $data);
    }

    public function create()
    {

        $codeProduct = '';
        if ($this->request->isAJAX()) {
            $dataModel = $this->getDataModel(NULL, $codeProduct);
            if ($this->objModel->insert($dataModel)) {
                $id = $this->objModel->insertID();
                $codeProduct = $this->generateCode((string) $id);
                $dataModel['Prod_id'] = $id;
                $this->objModel->update($id, array_merge($dataModel, ["Prod_code" => $codeProduct]));
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
    public function generateCode($id)
    {
        return "PROD_" . str_pad($id, 3, '0', STR_PAD_LEFT);
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
            $code = $this->generateCode((string) $id);
            $data = $this->getDataModel($id, $code);
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

    public function getDataModel($getShares, $code = '')
    {
        $data = [
            'Prod_id' => $getShares,
            'Prod_code' => $code,
            'Prod_name' => $this->request->getVar('Prod_name'),
            'Prod_description' => $this->request->getVar('Prod_description'),
            'Prod_brand_id' => $this->request->getVar('Prod_brand_id'),
            'Filing_id' => $this->request->getVar('Filing_id'),
            'updated_at' => $this->request->getVar('updated_at')
        ];
        return $data;
    }
}
