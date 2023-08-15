<?php

namespace App\Models\Manager;

use CodeIgniter\Model;

class ManagerModel extends Model
{

    protected $table = 'manager';
    protected $primaryKey = 'Manager_id';
    protected $allowedFields = [
        'Manager_id', 
        'Manager_name', 
        'Manager_email', 
        'Manager_phone', 
        'Client_id'
    ];
    protected $updatedField = 'updated_at';
}