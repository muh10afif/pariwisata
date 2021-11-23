<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_dtw extends CI_Model {

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
    public function get_data_dtw_kota()
    {
        $this->_get_datatables_query_dtw_kota();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_dtw_kota = [null, 'k.nama_kota', 'tot_dtw', 'tot_user'];
    var $kolom_cari_dtw_kota  = ['LOWER(k.nama_kota)'];
    var $order_dtw_kota       = ['k.nama_kota' => 'asc'];

    public function _get_datatables_query_dtw_kota()
    {
        $this->db->select('k.id_kota, k.nama_kota, (SELECT count(id_dtw) as tot_dtw FROM dtw where id_kota = k.id_kota) as tot_dtw, (SELECT count(m_user.id_user) as tot_user FROM m_user join dtw ON dtw.id_dtw = m_user.id_dtw where dtw.id_kota = k.id_kota) as tot_user');
        $this->db->from('kota as k');
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

    public function jumlah_semua_dtw_kota()
    {
        $this->db->select('k.id_kota, k.nama_kota, (SELECT count(id_dtw) as tot_dtw FROM dtw where id_kota = k.id_kota) as tot_dtw, (SELECT count(m_user.id_user) as tot_user FROM m_user join dtw ON dtw.id_dtw = m_user.id_dtw where dtw.id_kota = k.id_kota) as tot_user');
        $this->db->from('kota as k');
        $this->db->where('k.id_provinsi', 35);

        return $this->db->count_all_results();
    }

    public function jumlah_filter_dtw_kota()
    {
        $this->_get_datatables_query_dtw_kota();

        return $this->db->get()->num_rows();
        
    }

    // menampilkan list dtw
    public function get_data_detail_dtw($id_kota)
    {
        $this->_get_datatables_query_detail_dtw($id_kota);

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_detail_dtw = [null, 'd.nama_dtw', 'u.username', 'd.alamat'];
    var $kolom_cari_detail_dtw  = ['LOWER(d.nama_dtw)','LOWER(u.username)', 'LOWER(d.alamat)'];
    var $order_detail_dtw       = ['d.nama_dtw' => 'asc'];

    public function _get_datatables_query_detail_dtw($id_kota)
    {
        $this->db->select('u.username, d.nama_dtw, d.id_dtw, u.id_user, d.alamat, u.id_user');
        $this->db->from('m_user as u');
        $this->db->join('dtw as d', 'd.id_dtw = u.id_dtw', 'inner');
        $this->db->where('d.id_kota', $id_kota);
        
        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_detail_dtw;

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

            $kolom_order = $this->kolom_order_detail_dtw;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_detail_dtw)) {
            
            $order = $this->order_detail_dtw;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_detail_dtw($id_kota)
    {
        $this->db->select('u.username, d.nama_dtw, d.id_dtw, u.id_user, d.alamat, u.id_user');
        $this->db->from('m_user as u');
        $this->db->join('dtw as d', 'd.id_dtw = u.id_dtw', 'inner');
        $this->db->where('d.id_kota', $id_kota);

        return $this->db->count_all_results();
    }

    public function jumlah_filter_detail_dtw($id_kota)
    {
        $this->_get_datatables_query_detail_dtw($id_kota);

        return $this->db->get()->num_rows();
        
    }

    // menampilkan list dtw yang belum punya user 
    public function get_nama_dtw_user($id_kota)
    {
        $this->db->select('*');
        $this->db->from('m_user as u');
        $this->db->join('dtw as d', 'd.id_dtw = u.id_dtw', 'inner');
        
        $a = $this->db->get()->result();

        $ay = array();
        foreach ($a as $b) {
            $ay[] = $b->id_dtw;
        }

        $im = implode(',',$ay);
        $id = explode(',',$im); 

        $this->db->select('d.nama_dtw, d.id_dtw');
        $this->db->from('dtw as d');
        $this->db->where('d.id_kota', $id_kota);
        $this->db->where_not_in('d.id_dtw', $id);

        $this->db->order_by('d.nama_dtw', 'asc');
        
        return $this->db->get();
        
    }

    // Akhir 19-02-2020

}

/* End of file M_dtw.php */
