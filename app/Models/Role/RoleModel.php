<?php

namespace App\Models\Role;

use CodeIgniter\Model;

class RoleModel extends Model{
    protected $table = 'role';
    protected $primaryKey = 'Role_id';
    protected $allowedFields = [
    'Role_id', 
    'Role_name', 
    'Role_description', 
    'updated_at',
    'created_at'];

    protected $updatedField = 'updated_at';

    function getRoleAll(){
        $query = "SELECT * FROM role";
        $result = $this->db->query($query)->getResult();
        return $result;
    }
}