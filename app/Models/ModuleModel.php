<?php

namespace App\Models;

use CodeIgniter\Model;

class ModuleModel extends Model{
    protected $table            = 'module';
    protected $primaryKey       = 'Mod_id';
    protected $allowedFields    = [
    "Mod_id", 
    "Mod_name", 
    "Mod_description", 
    "Mod_route", 
    "created_at"];
    protected $updatedField = 'updated_at';
}