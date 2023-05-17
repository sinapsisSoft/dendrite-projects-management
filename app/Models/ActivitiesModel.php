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
    'Activi_code', 
    'Activi_codeMiigo', 
    'Activi_codeSpectra',
    'Activi_codeDelivery',
    'Activi_percentage',
    'Stat_id',  
    'Project_product_id', 
    'User_assigned',
    'updated_at'];
    protected $updatedField = 'updated_at';

    function sp_select_all_activities(){

        $query = "CALL sp_select_all_activities()";
        $result = $this->db->query($query)->getResult();
        return $result;
    }
    function sp_select_all_details_activities($ActivitiesId)
    {
        $query = "CALL sp_select_all_details_activities($ActivitiesId)";
        $result = $this->db->query($query)->getResult()[0];
        return $result;
    }

    function sp_update_percent_activity($activityId){
        $query = "CALL sp_update_percent_activity($activityId)";
        $this->db->query($query);
    }
}



		