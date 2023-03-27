<?php

namespace App\Models;

use CodeIgniter\Model;

class DocTypeModel extends Model
{
    protected $table            = 'doctype';
    protected $primaryKey       = 'DocType_id';
    protected $allowedFields    = ["DocType_id", "DocType_name", "DocType_code", "created_at"];
    protected $updatedField = 'updated_at';
}
