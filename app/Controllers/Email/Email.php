<?php
namespace App\Controllers\Email;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Email\EmailModel;

class Email extends BaseController{
    private $objModel;
    private $primaryKey;
    private $nameModel;

    public function __construct()
    {
        $this->objModel = new EmailModel();
        $this->primaryKey = 'Email_id';
        $this->nameModel = 'emails';
    }

    public function show(){
        $data['title'] = 'Correo Electronico';
        $data['meta'] = view('assets/meta');
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');

        $data['toasts'] = view('html/toasts');
      $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('header/header');
        $data['footer'] = view('footer/footer');
        $emails = $this->objModel->first();
        if (empty($emails)) {
            $data[$this->nameModel] = null;
        } else {
            $data[$this->nameModel] = $emails;
        }
        return view('email/email', $data);
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

    public function getDataModel($getShares)
    {
        $data = [
            'Email_id' => $getShares,
            'Email_user' => $this->request->getVar('Email_user'),
            'Email_pass' => $this->request->getVar('Email_pass'),
            'Email_host' => $this->request->getVar('Email_host'),
            'Email_puerto' => $this->request->getVar('Email_puerto'),
            'updated_at' => $this->request->getVar('updated_at')
        ];
        return $data;
    }
}