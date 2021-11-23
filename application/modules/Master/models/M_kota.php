<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class M_kota extends CI_Model
{
    public function get_kota()
    {
        $this->db->from('kota');
        
        return $this->db->get();
        
    }
    
    public function get_provinsi()
    {
        return $this->db->get('provinsi')->result();
        
    }
    
    public function simpan_users_kota($arr)
    {
        return $this->db->insert('m_user', $arr);
    }

    public function fil_prov($id)
    {
        if($id == NULL){
            return $this->db->get_where('kota',array('id_provinsi'=>'35'))->result();
        }else{
            return $this->db->get_where('kota',array('id_provinsi'=>$id))->result();    
        }
        
    }

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

    // Menampilkan list kota
    public function get_data_kota()
    {
        $this->_get_datatables_query_kota();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_orderkota = [null, 'k.nama_kota', 'p.nama_provinsi'];
    var $kolom_carikota  = ['LOWER(k.nama_kota)', 'LOWER(p.nama_provinsi)'];
    var $orderkota       = ['k.nama_kota' => 'asc'];

    public function _get_datatables_query_kota()
    {
        $this->db->select('k.nama_kota, k.id_kota, p.nama_provinsi');
        $this->db->from('kota as k');
        $this->db->join('provinsi as p', 'p.id_provinsi = k.id_provinsi', 'inner');
        $this->db->where('k.id_provinsi', 35);
    
        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_carikota;

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

            $kolom_order = $this->kolom_orderkota;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->orderkota)) {
            
            $order = $this->orderkota;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_kota()
    {
        $this->db->select('k.nama_kota, k.id_kota, p.nama_provinsi');
        $this->db->from('kota as k');
        $this->db->join('provinsi as p', 'p.id_provinsi = k.id_provinsi', 'inner');
        $this->db->where('k.id_provinsi', 35);

        return $this->db->count_all_results();
    }

    public function jumlah_filter_kota()
    {
        $this->_get_datatables_query_kota();

        return $this->db->get()->num_rows();
        
    }

    // AKhir 19-02-2020

}