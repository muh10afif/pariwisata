<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_kota extends CI_Model {

    // 19-02-2020

    public function cari_data($tabel, $where)
    {
        return $this->db->get_where($tabel, $where);
    }

    public function get_data_order($tabel, $field, $order)
    {
        $this->db->order_by($field, $order);
        
        return $this->db->get($tabel);
    }

    public function input_data($tabel, $data)
    {
        $this->db->insert($tabel, $data);
    }

    public function ubah_data($tabel, $data, $where)
    {
        return $this->db->update($tabel, $data, $where);
    }

    public function hapus_data($tabel, $where)
    {
        $this->db->delete($tabel, $where);
    }

    // Menampilkan list kota dtw
    public function get_data_user_kota()
    {
        $this->_get_datatables_query_user_kota();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_dtw_kota = [null, 'k.nama_kota', 'u.username'];
    var $kolom_cari_dtw_kota  = ['LOWER(k.nama_kota)', 'LOWER(u.username)'];
    var $order_dtw_kota       = ['k.nama_kota' => 'asc'];

    public function _get_datatables_query_user_kota()
    {
        $this->db->select('k.nama_kota, u.username, u.id_user');
        $this->db->from('m_user as u');
        $this->db->join('kota as k', 'k.id_kota = u.id_kota', 'inner');
        $this->db->where('u.id_pegawai', 0);
        $this->db->where('k.id_provinsi', 35);

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_dtw_kota;

        foreach ($kolom_cari as $cari) {
            if ($input_cari) {
                if ($b === 0) {
                    $this->db->group_start();
                    $this->db->like($cari, $input_cari);
                } else {
                    $this->db->or_like($cari, $input_cari);
                }

                if ((count($kolom_cari) - 1) == $b ) {
                    $this->db->group_end();
                }
            }

            $b++;
        }

        if (isset($_POST['order'])) {

            $kolom_order = $this->kolom_order_dtw_kota;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_dtw_kota)) {
            
            $order = $this->order_dtw_kota;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_user_kota()
    {
        $this->db->select('k.nama_kota, u.username, u.id_user');
        $this->db->from('m_user as u');
        $this->db->join('kota as k', 'k.id_kota = u.id_kota', 'inner');
        $this->db->where('u.id_pegawai', 0);
        $this->db->where('k.id_provinsi', 35);

        return $this->db->count_all_results();
    }

    public function jumlah_filter_user_kota()
    {
        $this->_get_datatables_query_user_kota();

        return $this->db->get()->num_rows();
        
    }

    // menampilkan list kota yang belum punya user 
    public function get_nama_kota_user()
    {
        $this->db->select('*');
        $this->db->from('m_user as u');
        $this->db->join('kota as k', 'k.id_kota = u.id_kota', 'inner');
        $this->db->where('u.id_pegawai', 0);
        
        $a = $this->db->get()->result();

        $ay = array();
        foreach ($a as $b) {
            $ay[] = $b->id_kota;
        }

        $im      = implode(',',$ay);
        $id_kota = explode(',',$im); 

        $this->db->select('id_kota, nama_kota');
        $this->db->from('kota');
        $this->db->where('id_provinsi', 35);
        $this->db->where_not_in('id_kota', $id_kota);
        
        return $this->db->get();
        
    }

    // Akhir 19-02-2020

}

/* End of file M_kota.php */
