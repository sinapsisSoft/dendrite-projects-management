<?php

namespace App\Models;

use CodeIgniter\Model;

class PermitModel extends Model{
    protected $table ='permit';
    protected $primaryKey='Perm_id';
    protected $allowedFields=[
    'Perm_id',
    'Perm_name',
    'Perm_description', 
    'created_at'];
    protected $updatedField = 'updated_at';
}