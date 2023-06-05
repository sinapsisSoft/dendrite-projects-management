<?php

namespace App\Models;

use CodeIgniter\Model;

class MailModel extends Model
{

    protected $table = 'mail';
    protected $primaryKey = 'Mail_id';
    protected $allowedFields = [
    'Mail_id', 
    'Mail_user', 
    'updated_at'];
    protected $updatedField = 'updated_at';
}