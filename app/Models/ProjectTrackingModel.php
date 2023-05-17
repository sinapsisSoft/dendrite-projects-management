<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectTrackingModel extends Model
{

    protected $table = 'project_tracking';
    protected $primaryKey = 'ProjectTrack_id';
    protected $allowedFields = ['ProjectTrack_id', 
    'ProjectTrack_name',
    'ProjectTrack_description',
    'ProjectTrack_date',
    'updated_at'];
    protected $updatedField = 'updated_at';

}