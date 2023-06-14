<?php

namespace App\Models;

use CodeIgniter\Model;

class SubActivitiesModel extends Model
{

    protected $table = 'subactivities';
    protected $primaryKey = 'SubAct_id';
    protected $allowedFields = ['SubAct_id', 
    'SubAct_name',
    'SubAct_description',
    'SubAct_estimatedEndDate', 
    'SubAct_percentage', 
    'Stat_id', 
    'Priorities_id',
    'Activi_id', 
    'User_id'];
    protected $updatedField = 'updated_at';


    function sp_select_all_sub_actitivites($id)
    {
        $query = "CALL sp_select_all_subactivities($id)";
        $result = $this->db->query($query)->getResult();
        return $result;
    }

    function sp_select_all_details_subactivities($id)
    {
        $query = "CALL sp_select_all_details_subactivities($id)";
        $result = $this->db->query($query)->getResult();
        return $result;
    }

    function sp_select_subactivity_info($id){
        $query = "CALL sp_select_subactivity_info($id)";
        $result = $this->db->query($query)->getResult();
        return $result;
    }

}



		