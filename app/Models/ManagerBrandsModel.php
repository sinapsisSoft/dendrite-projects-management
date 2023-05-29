<?php

namespace App\Models;

use CodeIgniter\Model;

class ManagerBrandsModel extends Model{
    protected $table = 'manager_brands';
    protected $primaryKey = 'Manager_brand_id';
    protected $allowedFields = [
    'Manager_brand_id', 
    'Manager_id',
    'Brand_id'
    ];

    function sp_select_all_brands_client($clientId){
        $query = "CALL sp_select_all_brands_client($clientId)";
        $result = $this->db->query($query)->getResult();
        return $result;
    }
}