<?php
namespace App\Models\PetitionsType;

use CodeIgniter\Model;

class PetitionsTypeModel extends Model{

    protected $table ='petitiontype';
    protected $primaryKey='Petition_type_id';
    protected $allowedFields=[
    'Petition_type_id',
    'Petition_type_name',
    'Petition_type_description'];
    protected $updatedField = 'updated_at';

    function sp_select_type_petitions()
    {
        $query = "CALL sp_select_type_petitions()";
        $result = $this->db->query($query)->getResult();
        return $result;
    }
}
