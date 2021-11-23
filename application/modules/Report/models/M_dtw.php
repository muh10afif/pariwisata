<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_dtw extends CI_Model {

    // 24-02-2020

    public function cari_data($tabel, $cari)
    {
        return $this->db->get_where($tabel, $cari);  
    }

    public function get_data_dtw()
    {
        $this->_get_datatables_query_dtw();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_dtw = [null, 'k.nama_kota', 'tot_jml_wisnus_dtw', 'tot_jml_wisman_dtw', 'jumlah'];
    var $kolom_cari_dtw  = ['LOWER(k.nama_kota)'];
    var $order_dtw       = ['k.nama_kota' => 'asc'];

    public function _get_datatables_query_dtw()
    {
        $this->db->select('k.nama_kota, k.id_kota, (SELECT sum(d.jumlah_pengunjung) as tot_jml_wisnus_dtw FROM rekap_wisnus_dtw as d JOIN dtw as o ON o.id_dtw = d.id_dtw JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1) as tot_jml_wisnus_dtw, (SELECT sum(d.jumlah_pengunjung) as tot_jml_wisman_dtw FROM rekap_wisman_dtw as d JOIN dtw as o ON o.id_dtw = d.id_dtw JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1) as tot_jml_wisman_dtw, COALESCE((SELECT sum(d.jumlah_pengunjung) as tot_jml_wisnus_dtw FROM rekap_wisnus_dtw as d JOIN dtw as o ON o.id_dtw = d.id_dtw JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1),0) + COALESCE((SELECT sum(d.jumlah_pengunjung) as tot_jml_wisman_dtw FROM rekap_wisman_dtw as d JOIN dtw as o ON o.id_dtw = d.id_dtw JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1),0) as jumlah');
        $this->db->from('kota as k');
        $this->db->where('k.id_provinsi', 35);

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_dtw;

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

            $kolom_order = $this->kolom_order_dtw;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_dtw)) {
            
            $order = $this->order_dtw;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_dtw()
    {
        $this->db->select('k.nama_kota, k.id_kota, (SELECT sum(d.jumlah_pengunjung) as tot_jml_wisnus_dtw FROM rekap_wisnus_dtw as d JOIN dtw as o ON o.id_dtw = d.id_dtw JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1) as tot_jml_wisnus_dtw, (SELECT sum(d.jumlah_pengunjung) as tot_jml_wisman_dtw FROM rekap_wisman_dtw as d JOIN dtw as o ON o.id_dtw = d.id_dtw JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1) as tot_jml_wisman_dtw, COALESCE((SELECT sum(d.jumlah_pengunjung) as tot_jml_wisnus_dtw FROM rekap_wisnus_dtw as d JOIN dtw as o ON o.id_dtw = d.id_dtw JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1),0) + COALESCE((SELECT sum(d.jumlah_pengunjung) as tot_jml_wisman_dtw FROM rekap_wisman_dtw as d JOIN dtw as o ON o.id_dtw = d.id_dtw JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1),0) as jumlah');
        $this->db->from('kota as k');
        $this->db->where('k.id_provinsi', 35);

        return $this->db->count_all_results();
    }

    public function jumlah_filter_dtw()
    {
        $this->_get_datatables_query_dtw();

        return $this->db->get()->num_rows();
        
    }

    public function get_data_dtw_kota($id_kota)
    {
        $this->_get_datatables_query_dtw_kota($id_kota);

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_dtw_kota = [null, 'd.nama_dtw', 'tot_jml_wisnus_dtw', 'tot_jml_wisman_dtw', 'jumlah'];
    var $kolom_cari_dtw_kota  = ['LOWER(d.nama_dtw)'];
    var $order_dtw_kota       = ['d.nama_dtw' => 'asc'];

    public function _get_datatables_query_dtw_kota($id_kota)
    {
        $this->db->select('d.nama_dtw, d.id_dtw, (SELECT sum(j.jumlah_pengunjung) as tot_jml_wisnus_dtw FROM rekap_wisnus_dtw as j where j.id_dtw = d.id_dtw and d.status = 1) as tot_jml_wisnus_dtw, (SELECT sum(j.jumlah_pengunjung) as tot_jml_wisman_dtw FROM rekap_wisman_dtw as j where j.id_dtw = d.id_dtw and d.status = 1) as tot_jml_wisman_dtw, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_jml_wisnus_dtw FROM rekap_wisnus_dtw as j where j.id_dtw = d.id_dtw and d.status = 1),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_jml_wisman_dtw FROM rekap_wisman_dtw as j where j.id_dtw = d.id_dtw and d.status = 1),0) as jumlah');
        $this->db->from('dtw as d');
        $this->db->where('d.id_kota', $id_kota);
    
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

    public function jumlah_semua_dtw_kota($id_kota)
    {
        $this->db->select('d.nama_dtw, d.id_dtw, (SELECT sum(j.jumlah_pengunjung) as tot_jml_wisnus_dtw FROM rekap_wisnus_dtw as j where j.id_dtw = d.id_dtw and d.status = 1) as tot_jml_wisnus_dtw, (SELECT sum(j.jumlah_pengunjung) as tot_jml_wisman_dtw FROM rekap_wisman_dtw as j where j.id_dtw = d.id_dtw and d.status = 1) as tot_jml_wisman_dtw, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_jml_wisnus_dtw FROM rekap_wisnus_dtw as j where j.id_dtw = d.id_dtw and d.status = 1),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_jml_wisman_dtw FROM rekap_wisman_dtw as j where j.id_dtw = d.id_dtw and d.status = 1),0) as jumlah');
        $this->db->from('dtw as d');
        $this->db->where('d.id_kota', $id_kota);

        return $this->db->count_all_results();
    }

    public function jumlah_filter_dtw_kota($id_kota)
    {
        $this->_get_datatables_query_dtw_kota($id_kota);

        return $this->db->get()->num_rows();
        
    }

    // filter kota menurut dtw nya
    public function cari_tot_jumlah($tabel, $id_kota, $periode)
    {
        $this->db->select('sum(d.jumlah_pengunjung) as tot_jumlah');
        $this->db->from("$tabel as d");
        $this->db->join('dtw as t', 't.id_dtw = d.id_dtw', 'inner');
        $this->db->where('t.id_kota', $id_kota);
        $this->db->where('d.status', 1);

        if ($periode != 'awal') {
            $this->db->where("DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$periode'");
        }

        return $this->db->get();
    }

    public function data_rekap_wisnus_p($id_kota, $id_periode)
    {
        if ($id_periode == '' || $id_periode == 'awal') {
            $this->db->select("p.nama_provinsi, 
            (SELECT sum(d.pengunjung_pria) as tot_pria FROM rekap_wisnus_dtw as d JOIN dtw as t ON t.id_dtw = d.id_dtw WHERE d.id_provinsi = p.id_provinsi and t.id_kota = '$id_kota' and d.status = 1) as tot_pria, 
            (SELECT sum(d.pengunjung_wanita) as tot_wanita FROM rekap_wisnus_dtw as d  JOIN dtw as t ON t.id_dtw = d.id_dtw WHERE d.id_provinsi = p.id_provinsi and t.id_kota = '$id_kota' and d.status = 1) as tot_wanita,
            (SELECT sum(d.pengunjung_pria) as tot_pria FROM rekap_wisnus_dtw as d JOIN dtw as t ON t.id_dtw = d.id_dtw WHERE d.id_provinsi = p.id_provinsi and t.id_kota = '$id_kota' and d.status = 1) +
            (SELECT sum(d.pengunjung_wanita) as tot_wanita FROM rekap_wisnus_dtw as d JOIN dtw as t ON t.id_dtw = d.id_dtw WHERE d.id_provinsi = p.id_provinsi and t.id_kota = '$id_kota' and d.status = 1) as tot_jumlah");
            
        } else {
            
            $this->db->select("p.nama_provinsi, 
            (SELECT sum(d.pengunjung_pria) as tot_pria FROM rekap_wisnus_dtw as d JOIN dtw as t ON t.id_dtw = d.id_dtw WHERE d.id_provinsi = p.id_provinsi and t.id_kota = '$id_kota' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1) as tot_pria, 
            (SELECT sum(d.pengunjung_wanita) as tot_wanita FROM rekap_wisnus_dtw as d  JOIN dtw as t ON t.id_dtw = d.id_dtw WHERE d.id_provinsi = p.id_provinsi and t.id_kota = '$id_kota' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1) as tot_wanita,
            (SELECT sum(d.pengunjung_pria) as tot_pria FROM rekap_wisnus_dtw as d JOIN dtw as t ON t.id_dtw = d.id_dtw WHERE d.id_provinsi = p.id_provinsi and t.id_kota = '$id_kota' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1) +
            (SELECT sum(d.pengunjung_wanita) as tot_wanita FROM rekap_wisnus_dtw as d JOIN dtw as t ON t.id_dtw = d.id_dtw WHERE d.id_provinsi = p.id_provinsi and t.id_kota = '$id_kota' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1) as tot_jumlah");
        }

        $this->db->from('provinsi as p');
        $this->db->order_by('p.nama_provinsi', 'asc');
        
        return $this->db->get()->result();
        
    }

    public function data_wisman_p($kws, $id_kota, $id_periode)
    {
        if ($id_periode == '' || $id_periode == 'awal') {
            $this->db->select("n.nama_negara,
            (select sum(d.pengunjung_pria) FROM rekap_wisman_dtw as d JOIN dtw as t ON t.id_dtw = d.id_dtw WHERE d.id_negara=n.id_negara and t.id_kota = '$id_kota' and d.status = 1) as tot_pria, 
            (select sum(d.pengunjung_wanita) FROM rekap_wisman_dtw as d JOIN dtw as t ON t.id_dtw = d.id_dtw WHERE d.id_negara=n.id_negara and t.id_kota = '$id_kota' and d.status = 1) as tot_wanita, 
            (select sum(d.jumlah_pengunjung) FROM rekap_wisman_dtw as d JOIN dtw as t ON t.id_dtw = d.id_dtw WHERE d.id_negara=n.id_negara and t.id_kota = '$id_kota' and d.status = 1) as tot_jumlah");

        } else {
            $this->db->select("n.nama_negara,
            (select sum(d.pengunjung_pria) FROM rekap_wisman_dtw as d JOIN dtw as t ON t.id_dtw = d.id_dtw WHERE d.id_negara=n.id_negara and t.id_kota = '$id_kota' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1)  as tot_pria, 
            (select sum(d.pengunjung_wanita) FROM rekap_wisman_dtw as d JOIN dtw as t ON t.id_dtw = d.id_dtw WHERE d.id_negara=n.id_negara and t.id_kota = '$id_kota' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1)  as tot_wanita, 
            (select sum(d.jumlah_pengunjung) FROM rekap_wisman_dtw as d JOIN dtw as t ON t.id_dtw = d.id_dtw WHERE d.id_negara=n.id_negara and t.id_kota = '$id_kota' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1)  as tot_jumlah");
        }

        $this->db->from('negara as n');
        $this->db->join('kawasan as k', 'k.id_kawasan = n.id_kawasan', 'inner');
        $this->db->where('k.nama_kawasan', $kws);
        $this->db->order_by('k.nama_kawasan', 'asc');
        
        return $this->db->get()->result();
        
    }

    // filter kota menurut dtw nya
    public function cari_tot_jumlah_dtw($tabel, $id_dtw, $periode)
    {
        $this->db->select('sum(d.jumlah_pengunjung) as tot_jumlah');
        $this->db->from("$tabel as d");
        $this->db->where('d.id_dtw', $id_dtw);
        $this->db->where('d.status', 1);

        if ($periode != 'awal') {
            $this->db->where("DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$periode'");
        }

        return $this->db->get();
    }

    public function data_rekap_wisnus_p_dtw($id_dtw, $id_periode)
    {
        if ($id_periode == '' || $id_periode == 'awal') {
            $this->db->select("p.nama_provinsi, 
            (SELECT sum(d.pengunjung_pria) as tot_pria FROM rekap_wisnus_dtw as d WHERE d.id_provinsi = p.id_provinsi and d.id_dtw = '$id_dtw' and d.status = 1) as tot_pria, 
            (SELECT sum(d.pengunjung_wanita) as tot_wanita FROM rekap_wisnus_dtw as d WHERE d.id_provinsi = p.id_provinsi and d.id_dtw = '$id_dtw' and d.status = 1) as tot_wanita,
            (SELECT sum(d.pengunjung_pria) as tot_pria FROM rekap_wisnus_dtw as d WHERE d.id_provinsi = p.id_provinsi and d.id_dtw = '$id_dtw' and d.status = 1) +
            (SELECT sum(d.pengunjung_wanita) as tot_wanita FROM rekap_wisnus_dtw as d WHERE d.id_provinsi = p.id_provinsi and d.id_dtw = '$id_dtw' and d.status = 1) as tot_jumlah");
            
        } else {
            
            $this->db->select("p.nama_provinsi, 
            (SELECT sum(d.pengunjung_pria) as tot_pria FROM rekap_wisnus_dtw as d WHERE d.id_provinsi = p.id_provinsi and d.id_dtw = '$id_dtw' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1) as tot_pria, 
            (SELECT sum(d.pengunjung_wanita) as tot_wanita FROM rekap_wisnus_dtw as d WHERE d.id_provinsi = p.id_provinsi and d.id_dtw = '$id_dtw' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1) as tot_wanita,
            (SELECT sum(d.pengunjung_pria) as tot_pria FROM rekap_wisnus_dtw as d WHERE d.id_provinsi = p.id_provinsi and d.id_dtw = '$id_dtw' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1) +
            (SELECT sum(d.pengunjung_wanita) as tot_wanita FROM rekap_wisnus_dtw as d WHERE d.id_provinsi = p.id_provinsi and d.id_dtw = '$id_dtw' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1) as tot_jumlah");
        }

        $this->db->from('provinsi as p');
        $this->db->order_by('p.nama_provinsi', 'asc');
        
        return $this->db->get()->result();
        
    }

    public function data_wisman_p_dtw($kws, $id_dtw, $id_periode)
    {
        if ($id_periode == '' || $id_periode == 'awal') {
            $this->db->select("n.nama_negara,
            (select sum(d.pengunjung_pria) FROM rekap_wisman_dtw as d WHERE d.id_negara=n.id_negara and d.id_dtw = '$id_dtw' and d.status = 1) as tot_pria, 
            (select sum(d.pengunjung_wanita) FROM rekap_wisman_dtw as d WHERE d.id_negara=n.id_negara and d.id_dtw = '$id_dtw' and d.status = 1) as tot_wanita, 
            (select sum(d.jumlah_pengunjung) FROM rekap_wisman_dtw as d WHERE d.id_negara=n.id_negara and d.id_dtw = '$id_dtw' and d.status = 1) as tot_jumlah");

        } else {
            $this->db->select("n.nama_negara,
            (select sum(d.pengunjung_pria) FROM rekap_wisman_dtw as d WHERE d.id_negara=n.id_negara and d.id_dtw = '$id_dtw' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1)  as tot_pria, 
            (select sum(d.pengunjung_wanita) FROM rekap_wisman_dtw as d WHERE d.id_negara=n.id_negara and d.id_dtw = '$id_dtw' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1)  as tot_wanita, 
            (select sum(d.jumlah_pengunjung) FROM rekap_wisman_dtw as d WHERE d.id_negara=n.id_negara and d.id_dtw = '$id_dtw' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1)  as tot_jumlah");
        }

        $this->db->from('negara as n');
        $this->db->join('kawasan as k', 'k.id_kawasan = n.id_kawasan', 'inner');
        $this->db->where('k.nama_kawasan', $kws);
        $this->db->order_by('k.nama_kawasan', 'asc');
        
        return $this->db->get()->result();
        
    }

    // Akhir 24-02-2020

}

/* End of file M_dtw.php */
