<?php
namespace App\Models\StatusType;

use CodeIgniter\Model;

class StatusType extends Model{

    protected $table ='statustype';
    protected $primaryKey='StatType_id';
    protected $allowedFields=[
    'StatType_id',
    'StatType_name',
    'StatType_description'];
    protected $updatedField = 'updated_at';
}
