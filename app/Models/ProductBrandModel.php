<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductBrandModel extends Model
{

    protected $table = 'product_brand';
    protected $primaryKey = 'Prod_brand_id';
    protected $allowedFields = [
    'Prod_brand_id', 
    'Prod_brand_name', 
    'Prod_brand_description'
    ];
    protected $updatedField = 'updated_at';
}