<?php

namespace App\Models\Petitions;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;
use Exception;

class PetitionsModel extends Model
{

    protected $table = 'user';
    protected $primaryKey = 'User_id';
    protected $allowedFields = [
        'User_id',
        'User_name',
        'User_email',
        'User_password',
        'Comp_id',
        'Stat_id',
        'Role_id',
        'updated_at'
    ];

    protected $updatedField = 'updated_at';
    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    protected function beforeInsert(array $data): array
    {
        return $this->getUpdatedDataWithHashedPassword($data);
    }

    protected function beforeUpdate(array $data): array
    {
        return $this->getUpdatedDataWithHashedPassword($data);
    }


    function sp_select_all_users()
    {
        $query = "CALL sp_select_all_users()";
        $result = $this->db->query($query)->getResult();
        return $result;
    }

    function sp_select_all_users_collaborator()
    {
        $query = "CALL sp_select_all_users_collaborator()";
        $result = $this->db->query($query)->getResult();
        return $result;
    }

    function sp_select_all_users_comercial()
    {
        $query = "CALL sp_select_all_users_comercial()";
        $result = $this->db->query($query)->getResult();
        return $result;
    }

    function sp_select_user_detail($userId)
    {
        $query = "CALL sp_select_user_detail(" . $userId .")";
        $result = $this->db->query($query)->getResult();
        return $result;
    }

    private function getUpdatedDataWithHashedPassword(array $data): array
    {
        if (isset($data['data']['User_password'])) {
           // $plaintextPassword = $data['data']['User_password'];
           // $data['data']['User_password'] = password_hash($plaintextPassword, PASSWORD_DEFAULT);
        }

        return $data;
    }


    public function findUserByEmailAddress(string $emailAddress)
    {
        $user = $this->asArray()->where(['User_email' => $emailAddress])->first();

        if (!$user) {
            throw new Exception('User does not exist for specified email address');
        }
        return $user;
    }

    public function findUserByEmailPassword(string $emailAddress, string $password)
    {
        $this->select('User_id');
        $this->where('User_email', $emailAddress);
        $user = $this->where('User_password', $password)->first();

        if (!$user) {

            return ResponseInterface::HTTP_NO_CONTENT;
        }
        return $user;
    }
    
    public function getUserBy(string $column, string $value)
    {
        return $this->where($column, $value)->first();
    }

    public function sp_select_user_modules(int $userId)
    {
        $query = "CALL sp_select_user_modules($userId)";
        $result = $this->db->query($query)->getResult();
        return $result;
    }

    public function sp_select_role_module_permit(int $userId, string $moduleName)
    {
        $query = "CALL sp_select_role_module_permit($userId,'$moduleName')";
        $result = $this->db->query($query)->getResult();
        return $result;
    }
    public function sp_select_user_role(int $userId)
    {
        $query = "CALL sp_select_user_role($userId)";
        $result = $this->db->query($query)->getResult();
    
        return $result[0]->Role_id;
    }
    /*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:20/08/2022
*Description:This functions create hash password  
*/
public function hash($password)
{
    return password_hash($password,PASSWORD_DEFAULT);
     
}

    /*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:20/08/2022
*Description:This functions validate hash password  
*/
public function verifyHash($password,$hash)
{
   if(password_verify($password,$hash))
   {
       return TRUE;
   }
   else{
       return FALSE;
   }
}

}