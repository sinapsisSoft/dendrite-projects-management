<?php

namespace App\Models\City;

use CodeIgniter\Model;

class CityModel extends Model
{

    protected $table = 'city';
    protected $primaryKey = 'City_id';
    protected $allowedFields = ['City_id', 'City_name', 'Country_id'];
    protected $updatedField = 'updated_at';
}