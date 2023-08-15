<?php

namespace App\Models\ProjectProduct;

use CodeIgniter\Model;

class ProjectProductModel extends Model{
    protected $table = 'project_product';
    protected $primaryKey = 'Project_product_id';
    protected $allowedFields = [
        'Project_productAmount', 
        'Project_product_percentage', 
        'Project_id', 
        'Prod_id', 
        'Stat_id', 
        'updated_at'
    ];

    function sp_select_all_project_product($id)
    {
        $query = "CALL sp_select_all_project_product($id)";
        $result = $this->db->query($query)->getResult();
        return $result;
    }
}