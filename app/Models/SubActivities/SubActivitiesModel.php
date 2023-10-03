<?php

namespace App\Models\SubActivities;

use CodeIgniter\Model;

class SubActivitiesModel extends Model
{

    protected $table = 'subactivities';
    protected $primaryKey = 'SubAct_id';
    protected $allowedFields = ['SubAct_id', 
    'SubAct_name',
    'SubAct_description',
    'SubAct_estimatedEndDate',
    'SubAct_endDate',  
    'SubAct_percentage', 
    'SubAct_duration', 
    'Stat_id', 
    'Priorities_id',
    'Activi_id', 
    'User_id',
    'updated_at',
    'created_at'];
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

    function sp_select_subactivity_user($userId){
        $query = "CALL sp_select_subactivity_user($userId)";
        $result = $this->db->query($query)->getResult();
        return $result;
    }

    function sp_select_info_subactivity($subactId){
        $query = "CALL sp_select_info_subactivity($subactId)";
        $result = $this->db->query($query)->getResult();
        return $result;
    }

}



		