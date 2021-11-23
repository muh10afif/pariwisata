<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class M_users extends CI_Model
{
    
    public function get_users_dtw($id_kota)
    {
        $this->db->select('*');
        $this->db->from('m_user as user');
        $this->db->join('dtw', 'user.id_dtw = dtw.id_dtw','inner');

        if ($id_kota != 0) {
            $this->db->where('dtw.id_kota', $id_kota);
        }

        return $this->db->get();
    }

    public function get_users_dtw_prov()
    {
        $this->db->select('*');
        $this->db->from('m_user as user');
        $this->db->join('dtw', 'user.id_dtw = dtw.id_dtw','inner');
        
        return $this->db->get();
    }
    
    public function get_kota()
    {
        $this->db->select('*');
        $this->db->from('kota');
        
        return $this->db->get();
    }
    
    public function get_users_kota()
    {
        $this->db->select('*');
        $this->db->from('m_user as user');
        $this->db->join('kota', 'user.id_kota = kota.id_kota','inner');
        $this->db->where('user.id_pegawai',0);
        
        return $this->db->get();
    }

    public function get_dtw($id_kota)
    {
        $this->db->select('*');
        $this->db->from('dtw');

        if ($id_kota != 0) {
            $this->db->where('id_kota', $id_kota);
        }
        
        return $this->db->get()->result();
    }
    
    public function get_dtw_prov()
    {
        $this->db->select('*');
        $this->db->from('dtw');

        return $this->db->get()->result();
    }

    public function simpan_users($arr)
    {
        return $this->db->insert('m_user', $arr);
    }

    public function hapus_users($id)
    {
        $this->db->where('id_user', $id);
        return $this->db->delete('m_user');
    }

    public function update_users($arr, $id)
    {
        $this->db->where('id_user', $id);
        return $this->db->update('m_user', $arr);
    }

    public function edit_users($id)
    {
        $this->db->where('id_user', $id);
        return $this->db->get('m_user')->row();
    }

    //HOTEL

    public function get_users_hotel($kota)
    {
        $this->db->select('*');
        $this->db->from('m_user');
        $this->db->join('hotel', 'm_user.id_hotel = hotel.id_hotel','inner');

        if ($kota != 0) {
            $this->db->where('hotel.id_kota', $kota);
        }
        
        return $this->db->get();
    }


    public function get_users_hotel_prov()
    {
        $this->db->select('*');
        $this->db->from('m_user');
        $this->db->join('hotel', 'm_user.id_hotel = hotel.id_hotel','inner');
        
        return $this->db->get();
    }

    public function simpan_users_hotel($arr)
    {
        return $this->db->insert('m_user', $arr);
    }

    public function hapus_users_hotel($id)
    {
        $this->db->where('id_user', $id);
        return $this->db->delete('m_user');
    }

    public function edit_users_hotel($id)
    {
        $this->db->where('id_user', $id);
        return $this->db->get('m_user')->row();
    }

    public function update_users_hotel($arr, $id)
    {
        $this->db->where('id_user', $id);
        return $this->db->update('m_user', $arr);
    }

    public function get_hotel($kota)
    {
        $this->db->select('*');
        $this->db->from('hotel');

        if ($kota != 0) {
            $this->db->where('id_kota', $kota);
        }
        
        return $this->db->get()->result();
    }
    
    public function get_hotel_prov()
    {
        $this->db->select('*');
        $this->db->from('hotel');
        
        return $this->db->get()->result();
    }
}
