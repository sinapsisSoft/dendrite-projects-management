<?php 
namespace App\Models;

use CodeIgniter\Model;

class UserRole extends Model{

    protected $table ='role';
    protected $primaryKey='Role_id';
    protected $allowedFields=['Role_id','Role_name','Role_description'];
    protected $updatedField = 'updated_at';
   
}