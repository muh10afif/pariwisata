<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class M_hotel extends CI_Model
{
    public function get_hotel($kota)
    {
        $this->db->select('id_hotel,nama_kota,nama_hotel,alamat,lat,long,email,no_hp,status');
        $this->db->from('hotel');
        $this->db->join('kota', 'kota.id_kota = hotel.id_kota');
        $this->db->where('kota.id_kota',$kota);
        return $this->db->get()->result();
    }

    public function get_hotel_prov($id_kota)
    {
        $this->db->select('id_hotel,nama_kota,nama_hotel,alamat,lat,long,email,no_hp,status');
        $this->db->from('hotel');
        $this->db->join('kota', 'kota.id_kota = hotel.id_kota');
        
        if ($id_kota != 0) {
            $this->db->where('kota.id_kota', $id_kota);
        }

        return $this->db->get()->result_array();
    }

    public function simpan($arr)
    {
        return $this->db->insert('hotel', $arr);
    }

    public function hapus($id)
    {
        $this->db->where('id_hotel', $id);
        return $this->db->delete('hotel');
    }
    public function edit($id)
    {
        $this->db->where('id_hotel', $id);
        return $this->db->get('hotel')->row();
    }

    public function update($id, $arr)
    {
        $this->db->where('id_hotel', $id);
        return $this->db->update('hotel', $arr);
    }

    public function get_kota()
    {
        $this->db->select('*');
        $this->db->from('kota');
        $this->db->join('provinsi', 'provinsi.id_provinsi = kota.id_provinsi');
        $this->db->where('nama_provinsi', "JAWA TIMUR");
        return $this->db->get()->result();
    }
    
    public function get_kota_p($id_kota)
    {
        $this->db->select('*');
        $this->db->from('kota');
        $this->db->join('provinsi', 'provinsi.id_provinsi = kota.id_provinsi');
        $this->db->where('nama_provinsi', "JAWA TIMUR");
        $this->db->where('kota.id_kota',$id_kota);
        return $this->db->get()->result();
    }

    public function import($c)
    {
        $this->db->query('ALTER TABLE hotel ADD kota varchar(255);');
        $this->db->insert('hotel', $c);
        $this->db->query('UPDATE hotel SET id_kota=(SELECT id_kota FROM kota WHERE hotel.kota = kota.nama_kota) WHERE kota is not null ;');
        $this->db->query('ALTER TABLE hotel DROP kota');
    }

    // 18-02-2020

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

    var $kolom_order_hotel_kota = [null, 'k.nama_kota', 'tot_hotel'];
    var $kolom_cari_hotel_kota  = ['LOWER(k.nama_kota)'];
    var $order_hotel_kota       = ['k.nama_kota' => 'asc'];

    public function _get_datatables_query_hotel_kota()
    {
        $this->db->select('k.id_kota, k.nama_kota, (SELECT count(id_hotel) as tot_hotel FROM hotel where id_kota = k.id_kota) as tot_hotel');
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
        $this->db->select('k.id_kota, k.nama_kota, (SELECT count(id_hotel) as tot_hotel FROM hotel where id_kota = k.id_kota) as tot_hotel');
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

    // AKhir 18-02-2020
}
