<?php

namespace App\Models\Mail;

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