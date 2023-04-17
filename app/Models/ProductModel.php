<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{

    protected $table = 'product';
    protected $primaryKey = 'Prod_id';
    protected $allowedFields = [
    'Prod_id', 
    'Prod_name', 
    'Prod_description', 
    'Prod_value', 
    'TypePro_id',
    'Brand_id', 
    'Unit_id', 
    'Filing_id'];
    protected $updatedField = 'updated_at';
}