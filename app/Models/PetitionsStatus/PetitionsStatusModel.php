<?php
namespace App\Models\PetitionsStatus;

use CodeIgniter\Model;

class PetitionsStatusModel extends Model{

    protected $table ='petitionstatus';
    protected $primaryKey='Petition_status_id';
    protected $allowedFields=[
    'Petition_status_id',
    'Petition_status_name',
    'Petition_status_description'];
    protected $updatedField = 'updated_at';

    function sp_select_status_petitions()
    {
        $query = "CALL sp_select_status_petitions()";
        $result = $this->db->query($query)->getResult();
        return $result;
    }
}
