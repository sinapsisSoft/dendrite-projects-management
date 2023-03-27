<?php 
namespace App\Models;

use CodeIgniter\Model;

class UserStatusModel extends Model{

    protected $table ='status';
    protected $primaryKey='Stat_id';
    protected $allowedFields=['Stat_id','Stat_name','Stat_description','StatType_id'];
    protected $updatedField = 'updated_at';

    function sp_select_status_users()
    {
        $query = "CALL sp_select_status_users()";
        $result = $this->db->query($query)->getResult();
        return $result;
    }
   
}