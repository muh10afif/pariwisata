<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_hotel extends CI_Model {

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

    // Menampilkan list kota hotel
    public function get_data_hotel_kota()
    {
        $this->_get_datatables_query_hotel_kota();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_hotel_kota = [null, 'k.nama_kota', 'tot_hotel', 'tot_user'];
    var $kolom_cari_hotel_kota  = ['LOWER(k.nama_kota)'];
    var $order_hotel_kota       = ['k.nama_kota' => 'asc'];

    public function _get_datatables_query_hotel_kota()
    {
        $this->db->select('k.id_kota, k.nama_kota, (SELECT count(id_hotel) as tot_hotel FROM hotel where id_kota = k.id_kota) as tot_hotel, (SELECT count(m_user.id_user) as tot_user FROM m_user join hotel ON hotel.id_hotel = m_user.id_hotel where hotel.id_kota = k.id_kota) as tot_user');
        $this->db->from('kota as k');
        $this->db->where('k.id_provinsi', 35);

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_hotel_kota;

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

            $kolom_order = $this->kolom_order_hotel_kota;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_hotel_kota)) {
            
            $order = $this->order_hotel_kota;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_hotel_kota()
    {
        $this->db->select('k.id_kota, k.nama_kota, (SELECT count(id_hotel) as tot_hotel FROM hotel where id_kota = k.id_kota) as tot_hotel, (SELECT count(m_user.id_user) as tot_user FROM m_user join hotel ON hotel.id_hotel = m_user.id_hotel where hotel.id_kota = k.id_kota) as tot_user');
        $this->db->from('kota as k');
        $this->db->where('k.id_provinsi', 35);

        return $this->db->count_all_results();
    }

    public function jumlah_filter_hotel_kota()
    {
        $this->_get_datatables_query_hotel_kota();

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

    var $kolom_order_detail_hotel = [null, 'd.nama_hotel', 'u.username', 'd.alamat'];
    var $kolom_cari_detail_hotel  = ['LOWER(d.nama_hotel)','LOWER(u.username)', 'LOWER(d.alamat)'];
    var $order_detail_hotel       = ['d.nama_hotel' => 'asc'];

    public function _get_datatables_query_detail_hotel($id_kota)
    {
        $this->db->select('u.username, d.nama_hotel, d.id_hotel, u.id_user, d.alamat, u.id_user');
        $this->db->from('m_user as u');
        $this->db->join('hotel as d', 'd.id_hotel = u.id_hotel', 'inner');
        $this->db->where('d.id_kota', $id_kota);
        
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
        $this->db->select('u.username, d.nama_hotel, d.id_hotel, u.id_user, d.alamat, u.id_user');
        $this->db->from('m_user as u');
        $this->db->join('hotel as d', 'd.id_hotel = u.id_hotel', 'inner');
        $this->db->where('d.id_kota', $id_kota);

        return $this->db->count_all_results();
    }

    public function jumlah_filter_detail_hotel($id_kota)
    {
        $this->_get_datatables_query_detail_hotel($id_kota);

        return $this->db->get()->num_rows();
        
    }

    // menampilkan list hotel yang belum punya user 
    public function get_nama_hotel_user($id_kota)
    {
        $this->db->select('*');
        $this->db->from('m_user as u');
        $this->db->join('hotel as d', 'd.id_hotel = u.id_hotel', 'inner');
        
        $a = $this->db->get()->result();

        $ay = array();
        foreach ($a as $b) {
            $ay[] = $b->id_hotel;
        }

        $im = implode(',',$ay);
        $id = explode(',',$im); 

        $this->db->select('d.nama_hotel, d.id_hotel');
        $this->db->from('hotel as d');
        $this->db->where('d.id_kota', $id_kota);
        $this->db->where_not_in('d.id_hotel', $id);

        $this->db->order_by('d.nama_hotel', 'asc');
        
        return $this->db->get();
        
    }

    // Akhir 19-02-2020

}

/* End of file M_hotel.php */
