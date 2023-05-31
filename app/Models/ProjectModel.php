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
        'Project_activitiEndDate',
        'Project_link', 
        'Project_percentage',
        'Project_observation', 
        'Client_id', 
        'Brand_id',
        'Manager_id',
        'Country_id', 
        'User_id', 
        'Stat_id',
        'Project_commercial',
        'Priorities_id', 
        'updated_at'
    ];
    protected $updatedField = 'updated_at';

    function sp_select_all_project_table()
    {
        $query = "CALL sp_select_all_project_table()";
        $result = $this->db->query($query)->getResult();
        return $result;
    }
    
    function sp_select_all_project($projectId)
    {
        $query = "CALL sp_select_all_project($projectId)";
        $result = $this->db->query($query)->getResult();
        return $result;
    }

    function updateCode($id, $code){
        $query = 'UPDATE project SET Project_code = '.$code." WHERE Project_id = ".$id." ;";
        $result = $this->db->query($query)->getResult();
        return $result;
    }

    function sp_select_percent_project($projectId){
        $query = "call sp_select_percent_project($projectId)";
        $result = $this->db->query($query)->getResult();
        return $result;
    }
}