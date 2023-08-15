<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{

    protected $table = 'product';
    protected $primaryKey = 'Prod_id';
    protected $allowedFields = [
    'Prod_id', 
    'Prod_code', 
    'Prod_name', 
    'Prod_description', 
    'Prod_brand_id', 
    'Filing_id',
    'created_at',
    'updated_at'];
    protected $updatedField = 'updated_at';
}