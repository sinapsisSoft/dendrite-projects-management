<?php 
namespace App\Models\UserRole;

use CodeIgniter\Model;

class UserRoleModel extends Model{

    protected $table ='role';
    protected $primaryKey='Role_id';
    protected $allowedFields=[
    'Role_id',
    'Role_name',
    'Role_description'];
    protected $updatedField = 'updated_at';

    function sp_select_modules_role($roleId){
        $query = "CALL sp_select_modules_role(" . $roleId . ");";
        $result = $this->db->query($query)->getResult();
        return $result;
    }
}