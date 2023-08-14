<?php

namespace App\Models\Module;

use CodeIgniter\Model;

class ModuleModel extends Model{
    protected $table            = 'module';
    protected $primaryKey       = 'Mod_id';
    protected $allowedFields    = [
    "Mod_id", 
    "Mod_name", 
    "Mod_description", 
    "Mod_route", 
    "updated_at",
    "created_at"];
    protected $updatedField = 'updated_at';

    function getModuleAll(){
        $query = "SELECT * FROM module WHERE Mod_parent IS NULL ORDER BY Mod_name;";
        $result = $this->db->query($query)->getResult();
        return $result;
    }
    function sp_select_module_id($idModule){
        $query = "CALL sp_select_module_id($idModule)";
        $result = $this->db->query($query)->getResult();
        return $result;
    }
}