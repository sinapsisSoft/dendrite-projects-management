<?php

namespace App\Models\Email;

use CodeIgniter\Model;

class EmailModel extends Model
{

    protected $table = 'email';
    protected $primaryKey = 'Email_id';
    protected $allowedFields = [
    'Email_id', 
    'Email_user', 
    'Email_pass', 
    'Email_host', 
    'Email_puerto', 
    'updated_at'];
    protected $updatedField = 'updated_at';
}