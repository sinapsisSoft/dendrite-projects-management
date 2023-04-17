<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivitiesModel extends Model
{

    protected $table = 'activities';
    protected $primaryKey = 'Activi_id';
    protected $allowedFields = ['Activi_id', 
    'Activi_name',
    'Activi_observation',
    'Activi_startDate', 
    'Activi_endDate',
    'Activi_link',
    'Activi_time', 
    'Activi_completion',  
    'ApprCode_id', 
    'Stat_id',  
    'Project_product_id', 
    'User_id',	
    'User_assigned',
    'updated_at'];
    protected $updatedField = 'updated_at';

    function sp_select_all_activities(){

        $query = "CALL sp_select_all_activities()";
        $result = $this->db->query($query)->getResult();
        return $result;
    }
}



		