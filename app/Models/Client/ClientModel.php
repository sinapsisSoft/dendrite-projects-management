<?php

namespace App\Models\Client;

use CodeIgniter\Model;

class ClientModel extends Model
{

    protected $table = 'client';
    protected $primaryKey = 'Client_id';
    protected $allowedFields = [
    'Client_id', 
    'Client_name', 
    'Client_identification', 
    'Client_email', 
    'Client_phone', 
    'Client_address', 
    'DocType_id', 
    'Comp_id', 
    'Stat_id', 
    'Country_id'];
    protected $updatedField = 'updated_at';

    function sp_select_all_clients($detailsclientId){

        $query = "CALL sp_select_all_clients($detailsclientId)";
        $result = $this->db->query($query)->getResult();
        return $result;
    }

    function sp_select_country_client($clientId){
        $query = "CALL sp_select_country_client($clientId)";
        $result = $this->db->query($query)->getResult();
        return $result;
    }
}

