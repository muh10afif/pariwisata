<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class M_petugas extends CI_Model
{
    public function get_petugas($id_kota)
    {
        $this->db->select('*');
        $this->db->from('petugas');
        $this->db->join('m_user', 'm_user.id_pegawai = petugas.id_petugas', 'inner');
        $this->db->where('m_user.id_kota', $id_kota);
        
        return $this->db->get()->result();
    }

    public function simpan($arr,$user)
    {
        $this->db->insert('petugas', $arr);
        $id =  $this->db->insert_id();
        return $this->db->insert('m_user', array('username'=>$user['username'],'password'=>$user['sha'],'id_pegawai'=>$id,'id_dtw'=>"0",'id_hotel'=>"0",'id_kota'=>$user['id_kota']));
    }

    public function hapus($id)
    {
        $this->db->where('id_petugas', $id);
        return $this->db->delete('petugas');
    }
    public function edit($id)
    {
        $this->db->select('petugas.nama_petugas,petugas.nik,petugas.email,petugas.no_telp,petugas.alamat,petugas.status,user.username,user.password');
        $this->db->from('petugas');
        $this->db->join('m_user as user', 'user.id_pegawai = petugas.id_petugas');
        $this->db->where('petugas.id_petugas', $id);

        return $this->db->get()->row();
    }

    public function update($id, $arr)
    {
        $this->db->where('id_petugas', $id);
        return $this->db->update('petugas', $arr);
    }

    
}
