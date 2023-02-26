<?php 
namespace App\Models;

use CodeIgniter\Model;

class Company extends Model{

    protected $table ='company';
    protected $primaryKey='Comp_id';
    protected $allowedFields=['Comp_id','Comp_name','Comp_identification','Comp_email','Comp_phone','DocType_id','Stat_id'];
    protected $updatedField = 'updated_at';
   
}