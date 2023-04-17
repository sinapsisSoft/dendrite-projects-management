<?php

namespace App\Models;

use CodeIgniter\Model;

class ApprovalCodeModel extends Model
{

    protected $table = 'approvalcode';
    protected $primaryKey = 'ApprCode_id';
    protected $allowedFields = [
    'ApprCode_id',
    'ApprCode_code', 
    'ApprCode_name'];
    protected $updatedField = 'updated_at';
}