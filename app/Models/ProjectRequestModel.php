<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectRequestModel extends Model{
    protected $table = 'project_request';
    protected $primaryKey = 'ProjReq_id';
    protected $allowedFields = [
        'ProjReq_id', 
        'User_id', 
        'ProjReq_name', 
        'Brand_id',
        'ProjReq_observation',
        'created_at',
        'updated_at'
    ];
    protected $updatedField = 'updated_at';

    function sp_select_projectrequest_all(){
        $query = "CALL sp_select_projectrequest_all()";
        $result = $this->db->query($query)->getResult();
        return $result;
    }

    function sp_select_projectrequest_detail($projectRequestId){
        $query = "CALL sp_select_projectrequest_detail(" . $projectRequestId .")";
        $result = $this->db->query($query)->getResult();
        return $result;
    }
}