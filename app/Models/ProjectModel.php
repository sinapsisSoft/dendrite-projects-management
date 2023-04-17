<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model{
    protected $table = 'project';
    protected $primaryKey = 'Project_id';
    protected $allowedFields = [
        'Project_id', 
        'Project_code', 
        'Project_name', 
        'Project_purchaseOrder', 
        'Project_ddtStartDate', 
        'Project_ddtEndDate', 
        'Project_startDate', 
        'Project_estimatedEndDate', 
        'Project_activitiStartDate', 
        'Project_link',
        'Project_percentage',  
        'Project_observation', 
        'Client_id', 
        'Country_id', 
        'User_id', 
        'Stat_id', 
        'updated_at'
    ];
    protected $updatedField = 'updated_at';
    
    function updateCode($id, $code){
        $query = 'UPDATE project SET Project_code = '.$code." WHERE Project_id = ".$id." ;";
        $result = $this->db->query($query)->getResult();
        return $result;
    }
}