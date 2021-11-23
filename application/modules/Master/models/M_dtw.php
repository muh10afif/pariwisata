<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class M_dtw extends CI_Model
{

    public function get_dtw($kota)
    {
        $this->db->select('id_dtw,nama_kota,nama_dtw,alamat,lat,long,email,no_hp,status');
        $this->db->from('dtw');
        $this->db->join('kota', 'kota.id_kota = dtw.id_kota');
        $this->db->where('kota.id_kota', $kota);
        
        return $this->db->get()->result();
    }

    public function get_dtw_prov($id_kota)
    {
        $this->db->select('id_dtw,nama_kota,nama_dtw,alamat,lat,long,email,no_hp,status');
        $this->db->from('dtw');
        $this->db->join('kota', 'kota.id_kota = dtw.id_kota');

        if ($id_kota != 0) {
            $this->db->where('kota.id_kota', $id_kota);
        }
        
        return $this->db->get()->result_array();
    }

    public function simpan($arr)
    {
        return $this->db->insert('dtw', $arr);
    }

    public function hapus($id)
    {
        $this->db->where('id_dtw', $id);
        return $this->db->delete('dtw');
    }
    public function edit($id)
    {
        $this->db->where('id_dtw', $id);
        return $this->db->get('dtw')->row();
    }

    public function update($id, $arr)
    {
        $this->db->where('id_dtw', $id);
        return $this->db->update('dtw', $arr);
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
        $this->db->query('ALTER TABLE dtw ADD kota varchar(255);');
        $this->db->insert('dtw', $c);
        $this->db->query('UPDATE dtw SET id_kota=(SELECT id_kota FROM kota WHERE dtw.kota = kota.nama_kota) WHERE kota is not null ;');
        $this->db->query('ALTER TABLE dtw DROP kota');
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

    // Menampilkan list kota dtw
    public function get_data_dtw_kota()
    {
        $this->_get_datatables_query_dtw_kota();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_dtw_kota = [null, 'k.nama_kota', 'tot_dtw'];
    var $kolom_cari_dtw_kota  = ['LOWER(k.nama_kota)'];
    var $order_dtw_kota       = ['k.nama_kota' => 'asc'];

    public function _get_datatables_query_dtw_kota()
    {
        $this->db->select('k.id_kota, k.nama_kota, (SELECT count(id_dtw) as tot_dtw FROM dtw where id_kota = k.id_kota) as tot_dtw');
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
        $this->db->select('k.id_kota, k.nama_kota, (SELECT count(id_dtw) as tot_dtw FROM dtw where id_kota = k.id_kota) as tot_dtw');
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

    // AKhir 18-02-2020
}
