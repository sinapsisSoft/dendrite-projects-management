<?php
namespace App\Controllers\ApprovalCode;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ApprovalCodeModel;


class ApprovalCode extends BaseController{
    private $objModel;
    private $primaryKey;
    private $nameModel;

    public function __construct()
    {
        $this->objModel = new ApprovalCodeModel();
        $this->primaryKey = 'ApprCode_id';
        $this->nameModel = 'approvalcodes';
    }

    public function show(){
        $data['title'] = 'Codigo';
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');

        $data['toasts'] = view('html/toasts');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('navbar/header');
        $data['footer'] = view('navbar/footer');

        $data[$this->nameModel] = $this->objModel->findAll();
        return view('approvalcode/approvalcode', $data);
    }

    public function create()
    {
        $codeProject = '';
        if ($this->request->isAJAX()) {
            $dataModel = $this->getDataModel(NULL, $codeProject);
            if ($this->objModel->insert($dataModel)) {
                $id = $this->objModel->insertID();
                $codeProject = $this->generateCode((string) $id);
                $dataModel['ApprCode_id'] = $id;
                $this->objModel->update($id, array_merge($dataModel, ["ApprCode_code" => $codeProject]));
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
    public function generateCode($id){
        return "Act_".str_pad($id, 3, '0', STR_PAD_LEFT);
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

    public function getDataModel($getShares)
    {
        $data = [
            'ApprCode_id' => $getShares,
            'ApprCode_code' => $this->request->getVar('ApprCode_code'),
            'ApprCode_name' => $this->request->getVar('ApprCode_name'),
            'updated_at' => $this->request->getVar('updated_at')
        ];
        return $data;
    }
}