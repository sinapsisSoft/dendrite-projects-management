<?php

namespace App\Models\RoleModulePermit;

use CodeIgniter\Model;

class RoleModulePermitModel extends Model{
    protected $table = 'role_module_permit';
    protected $primaryKey = 'Role_mod_per_id';
    protected $allowedFields = [
    'Role_mod_per_id', 
    'Perm_id', 
    'Role_mod_id', 
    'updated_at'];

    protected $updatedField = 'updated_at';
}