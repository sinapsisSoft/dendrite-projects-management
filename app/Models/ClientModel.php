<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{

    protected $table = 'client';
    protected $primaryKey = 'Client_id';
    protected $allowedFields = [
    'Client_id', 
    'Client_name', 
    'Client_identification', 
    'Client_email', 
    'Client_phone', 
    'Client_address', 
    'DocType_id', 
    'Comp_id', 
    'Stat_id', 
    'Country_id'];
    protected $updatedField = 'updated_at';
}