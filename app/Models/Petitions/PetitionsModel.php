<?php
/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:10/01/2024
*Description:This model is for data petitions
*/

namespace App\Models\Petitions;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;
use Exception;

class PetitionsModel extends Model
{

    protected $table = 'petition';
    protected $primaryKey = 'Petition_id';
    protected $allowedFields = [
        'Petition_id',
        'Petition_code',
        'Petition_descriptions',
        'Petition_start_date',
        'Petition_end_date',
        'Petition_status_id',
        'Petition_type_id',
        'Client_id',
        'User_id',
        'updated_at'
    ];

    protected $updatedField = 'updated_at';
    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];
    /*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:10/01/2024
*Description:This model is for data petitions all
*/
    function sp_select_all_petitions()
    {
        $query = "CALL sp_select_all_petitions()";
        $result = $this->db->query($query)->getResult();
        return $result;
    }
    /*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:10/01/2024
*Description:This model is for data petitions id
*/
    public function sp_select_petition_detail(int $petitionId)
    {
        try {
            $query = "CALL sp_select_petition_detail($petitionId)";
            $result = $this->db->query($query)->getResult();
        } catch (Exception $e) {

        }
        return $result;
    }


    // public function getUserBy(string $column, string $value)
    // {
    //     return $this->where($column, $value)->first();
    // }

    // public function sp_select_user_modules(int $userId)
    // {
    //     $query = "CALL sp_select_user_modules($userId)";
    //     $result = $this->db->query($query)->getResult();
    //     return $result;
    // }

    // public function sp_select_role_module_permit(int $userId, string $moduleName)
    // {
    //     $query = "CALL sp_select_role_module_permit($userId,'$moduleName')";
    //     $result = $this->db->query($query)->getResult();
    //     return $result;
    // }
    // public function sp_select_user_role(int $userId)
    // {
    //     $query = "CALL sp_select_user_role($userId)";
    //     $result = $this->db->query($query)->getResult();

    //     return $result[0]->Role_id;
    // }
}
