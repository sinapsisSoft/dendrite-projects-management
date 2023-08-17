<?php
namespace App\Controllers\DetailsClient;

use App\Controllers\BaseController;
use App\Models\Manager\ManagerModel;
use App\Models\Client\ClientModel;
use App\Models\Brand\BrandModel;
use App\Models\ManagerBrands\ManagerBrandsModel;
use App\Models\UserStatus\UserStatusModel;

class DetailsClient extends BaseController{


    public function show(){
        $manager = new ManagerModel();
        $client = new ClientModel();
        $brand = new BrandModel();
        $managerBrands = new ManagerBrandsModel();
        $status = new UserStatusModel();
        $detailsclientId = $this->request->getGet('detailsclientId');

        $data['title'] = 'Detalles';
        $data['css'] = view('assets/css');
        $data['js'] = view('assets/js');

        $data['toasts'] = view('html/toasts');
        $data['sidebar'] = view('navbar/sidebar');
        $data['header'] = view('navbar/header');
        $data['footer'] = view('navbar/footer');
      
        $data['managers'] = $manager->where('Client_id', $detailsclientId)->find();
        $data['clients'] = $client->sp_select_all_clients($detailsclientId)[0];
        $data['brands'] = $brand->where('Client_id', $detailsclientId)->find();
        $data['status'] = $status->sp_select_status_users();
        $data['managerBrands'] = $managerBrands->sp_select_all_brands_client($detailsclientId);
        return view('detailsclient/detailsclient', $data);
    }
}