<?php

namespace App\Models;

use CodeIgniter\Model;

class PrioritiesModel extends Model
{

    protected $table = 'priorities';
    protected $primaryKey = 'Priorities_id';
    protected $allowedFields = ['Priorities_id', 'Priorities_name', 'Priorities_color'];
    protected $updatedField = 'updated_at';
}