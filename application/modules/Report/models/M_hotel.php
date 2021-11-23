<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_hotel extends CI_Model {

    // 24-02-2020

    public function cari_data($tabel, $cari)
    {
        return $this->db->get_where($tabel, $cari);  
    }

    public function get_data_hotel()
    {
        $this->_get_datatables_query_hotel();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_hotel = [null, 'k.nama_kota', 'tot_jml_wisnus_hotel', 'tot_jml_wisman_hotel', 'jumlah'];
    var $kolom_cari_hotel  = ['LOWER(k.nama_kota)'];
    var $order_hotel       = ['k.nama_kota' => 'asc'];

    public function _get_datatables_query_hotel()
    {
        $this->db->select('k.nama_kota, k.id_kota, (SELECT sum(d.jumlah_pengunjung) as tot_jml_wisnus_hotel FROM rekap_wisnus_hotel as d JOIN hotel as o ON o.id_hotel = d.id_hotel JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1) as tot_jml_wisnus_hotel, (SELECT sum(d.jumlah_pengunjung) as tot_jml_wisman_hotel FROM rekap_wisman_hotel as d JOIN hotel as o ON o.id_hotel = d.id_hotel JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1) as tot_jml_wisman_hotel, COALESCE((SELECT sum(d.jumlah_pengunjung) as tot_jml_wisnus_hotel FROM rekap_wisnus_hotel as d JOIN hotel as o ON o.id_hotel = d.id_hotel JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1),0) + COALESCE((SELECT sum(d.jumlah_pengunjung) as tot_jml_wisman_hotel FROM rekap_wisman_hotel as d JOIN hotel as o ON o.id_hotel = d.id_hotel JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1),0) as jumlah');
        $this->db->from('kota as k');
        $this->db->where('k.id_provinsi', 35);

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_hotel;

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

            $kolom_order = $this->kolom_order_hotel;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_hotel)) {
            
            $order = $this->order_hotel;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_hotel()
    {
        $this->db->select('k.nama_kota, k.id_kota, (SELECT sum(d.jumlah_pengunjung) as tot_jml_wisnus_hotel FROM rekap_wisnus_hotel as d JOIN hotel as o ON o.id_hotel = d.id_hotel JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1) as tot_jml_wisnus_hotel, (SELECT sum(d.jumlah_pengunjung) as tot_jml_wisman_hotel FROM rekap_wisman_hotel as d JOIN hotel as o ON o.id_hotel = d.id_hotel JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1) as tot_jml_wisman_hotel, COALESCE((SELECT sum(d.jumlah_pengunjung) as tot_jml_wisnus_hotel FROM rekap_wisnus_hotel as d JOIN hotel as o ON o.id_hotel = d.id_hotel JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1),0) + COALESCE((SELECT sum(d.jumlah_pengunjung) as tot_jml_wisman_hotel FROM rekap_wisman_hotel as d JOIN hotel as o ON o.id_hotel = d.id_hotel JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1),0) as jumlah');
        $this->db->from('kota as k');
        $this->db->where('k.id_provinsi', 35);

        return $this->db->count_all_results();
    }

    public function jumlah_filter_hotel()
    {
        $this->_get_datatables_query_hotel();

        return $this->db->get()->num_rows();
        
    }

    // filter kota menurut hotel nya
    public function cari_tot_jumlah($tabel, $id_kota, $periode)
    {
        $this->db->select('sum(d.jumlah_pengunjung) as tot_jumlah');
        $this->db->from("$tabel as d");
        $this->db->join('hotel as t', 't.id_hotel = d.id_hotel', 'inner');
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
            (SELECT sum(d.pengunjung_pria) as tot_pria FROM rekap_wisnus_hotel as d JOIN hotel as t ON t.id_hotel = d.id_hotel WHERE d.id_provinsi = p.id_provinsi and t.id_kota = '$id_kota' and d.status = 1) as tot_pria, 
            (SELECT sum(d.pengunjung_wanita) as tot_wanita FROM rekap_wisnus_hotel as d  JOIN hotel as t ON t.id_hotel = d.id_hotel WHERE d.id_provinsi = p.id_provinsi and t.id_kota = '$id_kota' and d.status = 1) as tot_wanita,
            (SELECT sum(d.pengunjung_pria) as tot_pria FROM rekap_wisnus_hotel as d JOIN hotel as t ON t.id_hotel = d.id_hotel WHERE d.id_provinsi = p.id_provinsi and t.id_kota = '$id_kota' and d.status = 1) +
            (SELECT sum(d.pengunjung_wanita) as tot_wanita FROM rekap_wisnus_hotel as d JOIN hotel as t ON t.id_hotel = d.id_hotel WHERE d.id_provinsi = p.id_provinsi and t.id_kota = '$id_kota' and d.status = 1) as tot_jumlah");
            
        } else {
            
            $this->db->select("p.nama_provinsi, 
            (SELECT sum(d.pengunjung_pria) as tot_pria FROM rekap_wisnus_hotel as d JOIN hotel as t ON t.id_hotel = d.id_hotel WHERE d.id_provinsi = p.id_provinsi and t.id_kota = '$id_kota' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1) as tot_pria, 
            (SELECT sum(d.pengunjung_wanita) as tot_wanita FROM rekap_wisnus_hotel as d  JOIN hotel as t ON t.id_hotel = d.id_hotel WHERE d.id_provinsi = p.id_provinsi and t.id_kota = '$id_kota' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1) as tot_wanita,
            (SELECT sum(d.pengunjung_pria) as tot_pria FROM rekap_wisnus_hotel as d JOIN hotel as t ON t.id_hotel = d.id_hotel WHERE d.id_provinsi = p.id_provinsi and t.id_kota = '$id_kota' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1) +
            (SELECT sum(d.pengunjung_wanita) as tot_wanita FROM rekap_wisnus_hotel as d JOIN hotel as t ON t.id_hotel = d.id_hotel WHERE d.id_provinsi = p.id_provinsi and t.id_kota = '$id_kota' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1) as tot_jumlah");
        }

        $this->db->from('provinsi as p');
        $this->db->order_by('p.nama_provinsi', 'asc');
        
        return $this->db->get()->result();
        
    }

    public function data_wisman_p($kws, $id_kota, $id_periode)
    {
        if ($id_periode == '' || $id_periode == 'awal') {
            $this->db->select("n.nama_negara,
            (select sum(d.pengunjung_pria) FROM rekap_wisman_hotel as d JOIN hotel as t ON t.id_hotel = d.id_hotel WHERE d.id_negara=n.id_negara and t.id_kota = '$id_kota' and d.status = 1) as tot_pria, 
            (select sum(d.pengunjung_wanita) FROM rekap_wisman_hotel as d JOIN hotel as t ON t.id_hotel = d.id_hotel WHERE d.id_negara=n.id_negara and t.id_kota = '$id_kota' and d.status = 1) as tot_wanita, 
            (select sum(d.jumlah_pengunjung) FROM rekap_wisman_hotel as d JOIN hotel as t ON t.id_hotel = d.id_hotel WHERE d.id_negara=n.id_negara and t.id_kota = '$id_kota' and d.status = 1) as tot_jumlah");

        } else {
            $this->db->select("n.nama_negara,
            (select sum(d.pengunjung_pria) FROM rekap_wisman_hotel as d JOIN hotel as t ON t.id_hotel = d.id_hotel WHERE d.id_negara=n.id_negara and t.id_kota = '$id_kota' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1)  as tot_pria, 
            (select sum(d.pengunjung_wanita) FROM rekap_wisman_hotel as d JOIN hotel as t ON t.id_hotel = d.id_hotel WHERE d.id_negara=n.id_negara and t.id_kota = '$id_kota' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1)  as tot_wanita, 
            (select sum(d.jumlah_pengunjung) FROM rekap_wisman_hotel as d JOIN hotel as t ON t.id_hotel = d.id_hotel WHERE d.id_negara=n.id_negara and t.id_kota = '$id_kota' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1)  as tot_jumlah");
        }

        $this->db->from('negara as n');
        $this->db->join('kawasan as k', 'k.id_kawasan = n.id_kawasan', 'inner');
        $this->db->where('k.nama_kawasan', $kws);
        $this->db->order_by('k.nama_kawasan', 'asc');
        
        return $this->db->get()->result();
        
    }

    public function get_data_hotel_kota($id_kota)
    {
        $this->_get_datatables_query_hotel_kota($id_kota);

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_hotel_kota = [null, 'd.nama_hotel', 'tot_jml_wisnus_hotel', 'tot_jml_wisman_hotel', 'jumlah'];
    var $kolom_cari_hotel_kota  = ['LOWER(d.nama_hotel)'];
    var $order_hotel_kota       = ['d.nama_hotel' => 'asc'];

    public function _get_datatables_query_hotel_kota($id_kota)
    {
        $this->db->select('d.nama_hotel, d.id_hotel, (SELECT sum(j.jumlah_pengunjung) as tot_jml_wisnus_hotel FROM rekap_wisnus_hotel as j where j.id_hotel = d.id_hotel and d.status = 1) as tot_jml_wisnus_hotel, (SELECT sum(j.jumlah_pengunjung) as tot_jml_wisman_hotel FROM rekap_wisman_hotel as j where j.id_hotel = d.id_hotel and d.status = 1) as tot_jml_wisman_hotel, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_jml_wisnus_hotel FROM rekap_wisnus_hotel as j where j.id_hotel = d.id_hotel and d.status = 1),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_jml_wisman_hotel FROM rekap_wisman_hotel as j where j.id_hotel = d.id_hotel and d.status = 1),0) as jumlah');
        $this->db->from('hotel as d');
        $this->db->where('d.id_kota', $id_kota);
    
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

    public function jumlah_semua_hotel_kota($id_kota)
    {
        $this->db->select('d.nama_hotel, d.id_hotel, (SELECT sum(j.jumlah_pengunjung) as tot_jml_wisnus_hotel FROM rekap_wisnus_hotel as j where j.id_hotel = d.id_hotel and d.status = 1) as tot_jml_wisnus_hotel, (SELECT sum(j.jumlah_pengunjung) as tot_jml_wisman_hotel FROM rekap_wisman_hotel as j where j.id_hotel = d.id_hotel and d.status = 1) as tot_jml_wisman_hotel, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_jml_wisnus_hotel FROM rekap_wisnus_hotel as j where j.id_hotel = d.id_hotel and d.status = 1),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_jml_wisman_hotel FROM rekap_wisman_hotel as j where j.id_hotel = d.id_hotel and d.status = 1),0) as jumlah');
        $this->db->from('hotel as d');
        $this->db->where('d.id_kota', $id_kota);

        return $this->db->count_all_results();
    }

    public function jumlah_filter_hotel_kota($id_kota)
    {
        $this->_get_datatables_query_hotel_kota($id_kota);

        return $this->db->get()->num_rows();
        
    }

    // filter kota menurut hotel nya
    public function cari_tot_jumlah_hotel($tabel, $id_hotel, $periode)
    {
        $this->db->select('sum(d.jumlah_pengunjung) as tot_jumlah');
        $this->db->from("$tabel as d");
        $this->db->where('d.id_hotel', $id_hotel);
        $this->db->where('d.status', 1);

        if ($periode != 'awal') {
            $this->db->where("DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$periode'");
        }

        return $this->db->get();
    }

    public function data_rekap_wisnus_p_hotel($id_hotel, $id_periode)
    {
        if ($id_periode == '' || $id_periode == 'awal') {
            $this->db->select("p.nama_provinsi, 
            (SELECT sum(d.pengunjung_pria) as tot_pria FROM rekap_wisnus_hotel as d WHERE d.id_provinsi = p.id_provinsi and d.id_hotel = '$id_hotel' and d.status = 1) as tot_pria, 
            (SELECT sum(d.pengunjung_wanita) as tot_wanita FROM rekap_wisnus_hotel as d WHERE d.id_provinsi = p.id_provinsi and d.id_hotel = '$id_hotel' and d.status = 1) as tot_wanita,
            (SELECT sum(d.pengunjung_pria) as tot_pria FROM rekap_wisnus_hotel as d WHERE d.id_provinsi = p.id_provinsi and d.id_hotel = '$id_hotel' and d.status = 1) +
            (SELECT sum(d.pengunjung_wanita) as tot_wanita FROM rekap_wisnus_hotel as d WHERE d.id_provinsi = p.id_provinsi and d.id_hotel = '$id_hotel' and d.status = 1) as tot_jumlah");
            
        } else {
            
            $this->db->select("p.nama_provinsi, 
            (SELECT sum(d.pengunjung_pria) as tot_pria FROM rekap_wisnus_hotel as d WHERE d.id_provinsi = p.id_provinsi and d.id_hotel = '$id_hotel' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1) as tot_pria, 
            (SELECT sum(d.pengunjung_wanita) as tot_wanita FROM rekap_wisnus_hotel as d WHERE d.id_provinsi = p.id_provinsi and d.id_hotel = '$id_hotel' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1) as tot_wanita,
            (SELECT sum(d.pengunjung_pria) as tot_pria FROM rekap_wisnus_hotel as d WHERE d.id_provinsi = p.id_provinsi and d.id_hotel = '$id_hotel' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1) +
            (SELECT sum(d.pengunjung_wanita) as tot_wanita FROM rekap_wisnus_hotel as d WHERE d.id_provinsi = p.id_provinsi and d.id_hotel = '$id_hotel' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1) as tot_jumlah");
        }

        $this->db->from('provinsi as p');
        $this->db->order_by('p.nama_provinsi', 'asc');
        
        return $this->db->get()->result();
        
    }

    public function data_wisman_p_hotel($kws, $id_hotel, $id_periode)
    {
        if ($id_periode == '' || $id_periode == 'awal') {
            $this->db->select("n.nama_negara,
            (select sum(d.pengunjung_pria) FROM rekap_wisman_hotel as d WHERE d.id_negara=n.id_negara and d.id_hotel = '$id_hotel' and d.status = 1) as tot_pria, 
            (select sum(d.pengunjung_wanita) FROM rekap_wisman_hotel as d WHERE d.id_negara=n.id_negara and d.id_hotel = '$id_hotel' and d.status = 1) as tot_wanita, 
            (select sum(d.jumlah_pengunjung) FROM rekap_wisman_hotel as d WHERE d.id_negara=n.id_negara and d.id_hotel = '$id_hotel' and d.status = 1) as tot_jumlah");

        } else {
            $this->db->select("n.nama_negara,
            (select sum(d.pengunjung_pria) FROM rekap_wisman_hotel as d WHERE d.id_negara=n.id_negara and d.id_hotel = '$id_hotel' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1)  as tot_pria, 
            (select sum(d.pengunjung_wanita) FROM rekap_wisman_hotel as d WHERE d.id_negara=n.id_negara and d.id_hotel = '$id_hotel' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1)  as tot_wanita, 
            (select sum(d.jumlah_pengunjung) FROM rekap_wisman_hotel as d WHERE d.id_negara=n.id_negara and d.id_hotel = '$id_hotel' and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and d.status = 1)  as tot_jumlah");
        }

        $this->db->from('negara as n');
        $this->db->join('kawasan as k', 'k.id_kawasan = n.id_kawasan', 'inner');
        $this->db->where('k.nama_kawasan', $kws);
        $this->db->order_by('k.nama_kawasan', 'asc');
        
        return $this->db->get()->result();
        
    }

    // Akhir 24-02-2020

}

/* End of file M_hotel.php */
