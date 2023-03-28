<?php

namespace App\Models;

use CodeIgniter\Model;

class BrandModel extends Model
{

    protected $table = 'brand';
    protected $primaryKey = 'Brand_id';
    protected $allowedFields = ['Brand_id', 'Brand_name', 'Brand_description', 'Client_id', 'updated_at'];
    protected $updatedField = 'updated_at';
}