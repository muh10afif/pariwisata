<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_Spinner extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function GetKawasan()
    {
        $query = "SELECT * FROM kawasan ORDER BY id_kawasan ASC";
		return $this->db->query($query)->result_array();
    }

    function GetNegara($kawasan)
    {
        $query = "SELECT a.* FROM negara a INNER JOIN kawasan b ON b.id_kawasan = a.id_kawasan WHERE a.id_kawasan = '$kawasan' ORDER BY a.id_negara ASC";
		return $this->db->query($query)->result_array();
    }

    function GetProvinsi($data)
    {
        $listID = array();
        if($data != null)
        {
            foreach($data as $row)
            {
                $id = $row['id_provinsi'];
                array_push($listID,$id);
                //$query = "SELECT * FROM provinsi WHERE id_provinsi NOT BETWEEN $id AND 100 ORDER BY id_provinsi ASC";
                
            }
            $this->db->select('*');
            $this->db->from('provinsi');
            $this->db->where_not_in('id_provinsi', $listID);
            $this->db->order_by('id_provinsi', 'ASC');
            return $this->db->get()->result_array();
        }
        else
        {
            $this->db->select('*');
            $this->db->from('provinsi');
            $this->db->order_by('id_provinsi', 'ASC');
            return $this->db->get()->result_array();
        }
    }
}