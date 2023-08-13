<?php

namespace App\Models\ProjectRequestProduct;

use CodeIgniter\Model;

class ProjectRequestProductModel extends Model{
    protected $table = 'project_request_product';
    protected $primaryKey = 'ProjReq_product_id';
    protected $allowedFields = [
        'ProjReq_product_id', 
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