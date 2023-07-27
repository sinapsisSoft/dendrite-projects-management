<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectRequestProductModel extends Model{
    protected $table = 'project_request';
    protected $primaryKey = 'project_request_product';
    protected $allowedFields = [
        'project_request_product', 
        'ProjReq_id', 
        'Prod_id', 
        'ProjReq_product_amount',
        'created_at',
        'updated_at'
    ];
    protected $updatedField = 'updated_at';

    function sp_select_projectrequest_product($projectRequestId){
        $query = "CALL sp_select_projectrequest_product(" . $projectRequestId .")";
        $result = $this->db->query($query)->getResult();
        return $result;
    }
}