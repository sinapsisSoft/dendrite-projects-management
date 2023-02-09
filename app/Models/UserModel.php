<?php

namespace App\Models;
use CodeIgniter\HTTP\ResponseInterface;

use CodeIgniter\Model;
use Exception;

class UserModel extends Model
{

    protected $table = 'user';
    protected $primaryKey='User_id';
    protected $allowedFields = [
        'User_name', 'User_email', 'User_password', 'Comp_id ', 'Stat_id', 'Role_id'
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


    private function getUpdatedDataWithHashedPassword(array $data): array
    {
        if (isset($data['data']['User_password'])) {
            $plaintextPassword = $data['data']['User_password'];
            $data['data']['User_password'] = password_hash($plaintextPassword, PASSWORD_BCRYPT);
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
}
