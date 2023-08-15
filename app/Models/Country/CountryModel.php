<?php 
namespace App\Models\Country;

use CodeIgniter\Model;

class CountryModel extends Model{

    protected $table ='country';
    protected $primaryKey='Country_id';
    protected $allowedFields=['Country_id','Country_name'];
    protected $updatedField = 'updated_at';
   
}