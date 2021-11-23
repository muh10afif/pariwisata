<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_Kelolaan extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function Kelolaan_DTW($id_pegawai)
    {
        //$ok = false;
        
        try
        {
            $this->db->select('a.status,b.nama_dtw,b.id_dtw,b.alamat,b.email,b.no_hp,b.lat,b.long, b.status as stat');
            $this->db->from('penempatan_dtw a');
            $this->db->join('dtw b', 'b.id_dtw = a.id_dtw', 'inner');
            $this->db->where('a.id_pegawai', $id_pegawai);
            
            return $this->db->get()->result_array();
        }
        catch (Exception $e) 
        {
            //$ok = false;
            return 0;
        }
    }
    
    function Kelolaan_Hotel($id_pegawai)
    {
        //$ok = false;
        
        try
        {
            $this->db->select('a.status,b.nama_hotel,b.id_hotel,b.alamat,b.email,b.no_hp,b.lat,b.long, b.status as stat');
            $this->db->from('penempatan_hotel a');
            $this->db->join('hotel b', 'b.id_hotel = a.id_hotel', 'inner');
            $this->db->where('a.id_pegawai', $id_pegawai);
            
            return $this->db->get()->result_array();
        }
        catch (Exception $e) 
        {
            //$ok = false;
            return 0;
        }
    }
}