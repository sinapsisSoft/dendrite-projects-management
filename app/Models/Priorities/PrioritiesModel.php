<?php

namespace App\Models\Priorities;

use CodeIgniter\Model;

class PrioritiesModel extends Model
{

    protected $table = 'priorities';
    protected $primaryKey = 'Priorities_id';
    protected $allowedFields = ['Priorities_id', 'Priorities_name', 'Priorities_color'];
    protected $updatedField = 'updated_at';
}