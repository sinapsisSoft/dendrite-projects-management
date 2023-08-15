<?php 
namespace App\Models\UserManager;

use CodeIgniter\Model;

class UserManagerModel extends Model{

    protected $table ='user_manager';
    protected $primaryKey='UserManager_id';
    protected $allowedFields=[
    'UserManager_id',
    'User_id',
    'Manager_id',
    'created_at', 
    'updated_at'];
    protected $updatedField = 'updated_at';

    function sp_select_user_manager($managerId){
        $query = "CALL sp_select_user_manager(" . $managerId . ");";
        $result = $this->db->query($query)->getResult();
        return $result;
    }

    
    function sp_insert_user_manager($managerId){
        $query = "CALL sp_insert_user_manager(" . $managerId . ");";
        $result = $this->db->query($query)->getResult();
        return $result;
    }

    function sp_update_user_email($managerId){
        $query = "CALL sp_update_user_email(" . $managerId . ");";
        $result = $this->db->query($query)->getResult();
        return $result;
    }

    function sp_update_user_status($managerId, $status){
        $query = "CALL sp_update_user_status(" . $managerId . "," . $status .");";
        $result = $this->db->query($query)->getResult();
        return $result;
    }
}