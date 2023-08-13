<?php

namespace App\Models\Filing;

use CodeIgniter\Model;

class FilingModel extends Model
{
    protected $table            = 'filing';
    protected $primaryKey       = 'Filing_id';
    protected $allowedFields    = [
    "Filing_id", 
    "Filing_name", 
    "Filing_description"];
    protected $updatedField = 'updated_at';
}