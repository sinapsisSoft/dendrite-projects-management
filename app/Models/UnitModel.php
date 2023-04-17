<?php

namespace App\Models;

use CodeIgniter\Model;

class UnitModel extends Model
{

    protected $table = 'unit';
    protected $primaryKey = 'Unit_id';
    protected $allowedFields = [
    'Unit_id', 
    'Unit_name', 
    'Unit_symbol'];
    protected $updatedField = 'updated_at';
}
