<?php

namespace App\Models\RoleModule;

use CodeIgniter\Model;

class RoleModuleModel extends Model{
    protected $table = 'role_module';
    protected $primaryKey = 'Role_mod_id';
    protected $allowedFields = [
    'Role_mod_id', 
    'Role_id', 
    'Mod_id', 
    'updated_at'];

    protected $updatedField = 'updated_at';

    function sp_delete_role_module($roleId){
        $query = "CALL sp_delete_role_module($roleId)";
        $result = $this->db->query($query)->getResult();
        return $result;
    }
}