<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_dtw_hotel extends CI_Model {

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

    // Master dtw_hotel
    public function get_data_dtw_hotel()
    {
        $this->_get_datatables_query_dtw_hotel();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_dtw_hotel = [null, 'k.nama_kota', 'tot_dtw', 'tot_hotel'];
    var $kolom_cari_dtw_hotel  = ['LOWER(k.nama_kota)'];
    var $order_dtw_hotel       = ['k.nama_kota' => 'asc'];

    public function _get_datatables_query_dtw_hotel()
    {
        $this->db->select('k.id_kota, k.nama_kota, (SELECT count(id_dtw) as tot_dtw FROM dtw where id_kota = k.id_kota) as tot_dtw, (SELECT count(id_hotel) as tot_hotel FROM hotel where id_kota = k.id_kota) as tot_hotel');
        $this->db->from('kota as k');

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_dtw_hotel;

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

            $kolom_order = $this->kolom_order_dtw_hotel;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_dtw_hotel)) {
            
            $order = $this->order_dtw_hotel;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_dtw_hotel()
    {
        $this->db->select('k.id_kota, k.nama_kota, (SELECT count(id_dtw) as tot_dtw FROM dtw where id_kota = k.id_kota) as tot_dtw, (SELECT count(id_hotel) as tot_hotel FROM hotel where id_kota = k.id_kota) as tot_hotel');
        $this->db->from('kota as k');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_dtw_hotel()
    {
        $this->_get_datatables_query_dtw_hotel();

        return $this->db->get()->num_rows();
        
    }

    public function get_data_detail_dtw_hotel($id_kota, $aksi)
    {
        $this->_get_datatables_query_detail_dtw_hotel($id_kota, $aksi);

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_detail_dtw_hotel = [null, 'nama', 'alamat', 'lat', 'long', 'email', 'no_hp', 'status'];
    var $kolom_cari_detail_dtw_hotel  = ['LOWER(alamat)', 'CAST(lat as VARCHAR)', 'CAST(long as VARCHAR)', 'LOWER(email)', 'LOWER(no_hp)', 'CAST(status as VARCHAR)'];
    var $order_detail_dtw_hotel       = ['nama' => 'asc'];

    public function _get_datatables_query_detail_dtw_hotel($id_kota, $aksi)
    {
        if ($aksi == 'dtw') {
            $this->db->select("$aksi.*, nama_dtw as nama");
        } else {
            $this->db->select("$aksi.*, nama_hotel as nama");
        }
        
        $this->db->from($aksi);
        $this->db->where('id_kota', $id_kota);

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_detail_dtw_hotel;

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

            $kolom_order = $this->kolom_order_detail_dtw_hotel;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_detail_dtw_hotel)) {
            
            $order = $this->order_detail_dtw_hotel;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_detail_dtw_hotel($id_kota, $aksi)
    {
        if ($aksi == 'dtw') {
            $this->db->select("$aksi.*, nama_dtw as nama");
        } else {
            $this->db->select("$aksi.*, nama_hotel as nama");
        }
        
        $this->db->from($aksi);
        $this->db->where('id_kota', $id_kota);

        return $this->db->count_all_results();
    }

    public function jumlah_filter_detail_dtw_hotel($id_kota, $aksi)
    {
        $this->_get_datatables_query_detail_dtw_hotel($id_kota, $aksi);

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

    var $kolom_order_detail_dtw = [null, 'nama_dtw', 'alamat', 'lat', 'long', 'email', 'no_hp', 'status'];
    var $kolom_cari_detail_dtw  = ['LOWER(nama_dtw)','LOWER(alamat)', 'lat', 'long', 'email', 'no_hp', 'status'];
    var $order_detail_dtw       = ['nama_dtw' => 'asc'];

    public function _get_datatables_query_detail_dtw($id_kota)
    {
        $this->db->from('dtw');
        $this->db->where('id_kota', $id_kota);
        
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
        $this->db->from('dtw');
        $this->db->where('id_kota', $id_kota);

        return $this->db->count_all_results();
    }

    public function jumlah_filter_detail_dtw($id_kota)
    {
        $this->_get_datatables_query_detail_dtw($id_kota);

        return $this->db->get()->num_rows();
        
    }

    // menampilkan list hotel

    public function get_data_detail_hotel($id_kota)
    {
        $this->_get_datatables_query_detail_hotel($id_kota);

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_detail_hotel = [null, 'nama_hotel', 'alamat', 'lat', 'long', 'email', 'no_hp', 'status'];
    var $kolom_cari_detail_hotel  = ['LOWER(nama_hotel)','LOWER(alamat)', 'lat', 'long', 'email', 'no_hp', 'status'];
    var $order_detail_hotel       = ['nama_hotel' => 'asc'];

    public function _get_datatables_query_detail_hotel($id_kota)
    {
        $this->db->from('hotel');
        $this->db->where('id_kota', $id_kota);
        
        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_detail_hotel;

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

            $kolom_order = $this->kolom_order_detail_hotel;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_detail_hotel)) {
            
            $order = $this->order_detail_hotel;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_detail_hotel($id_kota)
    {
        $this->db->from('hotel');
        $this->db->where('id_kota', $id_kota);

        return $this->db->count_all_results();
    }

    public function jumlah_filter_detail_hotel($id_kota)
    {
        $this->_get_datatables_query_detail_hotel($id_kota);

        return $this->db->get()->num_rows();
        
    }

}

/* End of file M_dtw_hotel.php */
