<?php
namespace App\Controllers\DetailsClient;

use App\Controllers\BaseController;
use App\Models\ManagerModel;
use App\Models\ClientModel;
use App\Models\BrandModel;
use App\Models\ManagerBrandsModel;

class DetailsClient extends BaseController{


    public function show(){
        $manager = new ManagerModel();
        $client = new ClientModel();
        $brand = new BrandModel();
        $managerBrands = new ManagerBrandsModel();
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
        $data['managerBrands'] = $managerBrands->sp_select_all_brands_client($detailsclientId);
        return view('detailsclient/detailsclient', $data);
    }
}