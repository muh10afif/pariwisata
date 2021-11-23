<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_master extends CI_Model {
    
    public function get_data_mesin_belum()
    {
        $this->db->select('id_mesin');
        $this->db->from('kelola_mesin');
        $sub = $this->db->get_compiled_select();
        
        $this->db->select('m.id_mesin, m.nama_mesin');
        $this->db->from('mesin as m');
        $this->db->where("m.id_mesin NOT IN ($sub)", NULL, FALSE);
        
        return $this->db->get();
    }

    // menampilkan list data jenis reminder
    public function get_data_jenis_reminder()
    {
        $this->db->order_by('add_time', 'desc');
        return $this->db->get('jenis_task');
        
    }

    public function get_data_mesin_atm()
    {
        $this->db->order_by('add_time', 'desc');

        return $this->db->get('mesin');
    }

    public function get_data_karyawan()
    {
        $this->db->order_by('add_time', 'desc');
        
        return $this->db->get('karyawan');
    }

    public function jenis_task()
    {
        $this->db->order_by('add_time', 'desc');
        
        return $this->db->get('jenis_task');
    }

    public function list_pegawai()
    {
        $this->db->order_by('add_time', 'desc');
        
        return $this->db->get('karyawan');
    }

    // input data
    public function input_data($tabel, $data)
    {
       return $this->db->insert($tabel, $data);
    }
    
    // proses ubah data
    public function ubah_data($tabel, $data, $where)
    {
        $this->db->where($where);
        return $this->db->update($tabel, $data);
    }

    // proses hapus data
    public function hapus_data($tabel, $where)
    {
        $this->db->where($where);
        return $this->db->delete($tabel);
    }

    // mencari karyawan
    public function data_edit($tabel, $where)
    {
        return $this->db->get_where($tabel, $where)->row_array();
    }

    // menampilkan pengguna
    public function get_data_pengguna()
    {
        $this->db->from('pengguna as p');
        $this->db->join('karyawan as k', 'k.id_karyawan = p.id_karyawan', 'left');
        $this->db->where_not_in('p.level',1);

        return $this->db->get();
    }

    // menampilkan karyawan
    public function get_karyawan_pengguna()
    {
        $this->db->select('id_karyawan');
        $this->db->from('pengguna');
        $this->db->where('id_karyawan !=', null);
        
        $sub = $this->db->get_compiled_select();

        $this->db->select('k.nama_karyawan, k.id_karyawan');
        $this->db->from('karyawan as k');
        $this->db->where("k.id_karyawan NOT IN ($sub)", NULL, FALSE);
        
        return $this->db->get();
        
    }

    // menampilkan edit pengguna
    public function data_edit_pengguna($where)
    {
        $this->db->select('k.id_karyawan, p.level, p.username, p.password, p.id_pengguna, k.nama_karyawan');
        $this->db->from('pengguna as p');
        $this->db->join('karyawan as k', 'k.id_karyawan = p.id_karyawan', 'inner');
        $this->db->where($where);
        
        return $this->db->get()->row_array();
        
    }

}

/* End of file M_master.php */
