<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductTypeModel extends Model
{
    protected $table            = 'product_type';
    protected $primaryKey       = 'TypePro_id';
    protected $allowedFields    = [
    "TypePro_id", 
    "TypePro_name", 
    "TypePro_description"];
    protected $updatedField = 'updated_at';
}