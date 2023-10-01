<?php

namespace App\Models\Report;

use CodeIgniter\Model;

class ReportModel extends Model
{

  function sp_select_commercial_info_table($iniDate, $finDate, $user)
  {
    $query = "CALL sp_select_commercial_info_table('" . $iniDate . "','" . $finDate . "'," . $user . ")";
    $result = $this->db->query($query)->getResult();
    return $result;
  }

  function sp_select_commercial_info_chart1($iniDate, $finDate, $user)
  {
    $query = "CALL sp_select_commercial_info_chart1('" . $iniDate . "','" . $finDate . "'," . $user . ")";
    $result = $this->db->query($query)->getResult();
    return $result;
  }

  function sp_select_commercial_info_chart2($iniDate, $finDate, $user)
  {
    $query = "CALL sp_select_commercial_info_chart2('" . $iniDate . "','" . $finDate . "'," . $user . ")";
    $result = $this->db->query($query)->getResult();
    return $result;
  }

  function sp_select_commercial_info_chart3($iniDate, $finDate, $user)
  {
    $query = "CALL sp_select_commercial_info_chart3('" . $iniDate . "','" . $finDate . "'," . $user . ")";
    $result = $this->db->query($query)->getResult();
    return $result;
  }
}