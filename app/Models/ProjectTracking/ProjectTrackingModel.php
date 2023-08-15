<?php

namespace App\Models\ProjectTracking;

use CodeIgniter\Model;

class ProjectTrackingModel extends Model
{

    protected $table = 'project_tracking';
    protected $primaryKey = 'ProjectTrack_id';
    protected $allowedFields = ['ProjectTrack_id', 
    'ProjectTrack_name',
    'Project_id',
    'ProjectTrack_description',
    'ProjectTrack_date'];
}