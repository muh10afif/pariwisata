<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class M_dtw extends CI_Model
{
    // 21-02-2020

    public function cari_data_order($tabel, $where, $field, $order)
    {
        $this->db->order_by($field, $order);
        return $this->db->get_where($tabel, $where);
    }

    public function get_data_order($tabel, $field, $order)
    {
        $this->db->order_by($field, $order);
        
        return $this->db->get($tabel);
    }

    // menampilkan tot jumlah rekap dtw
    public function get_dtw_rekap_bulan($bulan, $jenis_w, $id_dtw)
    {
        $this->db->select("id_dtw, (SELECT sum(d.jumlah_pengunjung) as tot_dtw FROM $jenis_w as d where d.id_dtw = dtw.id_dtw and d.status = 1 and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan') as tot_dtw");
        $this->db->from('dtw');
        $this->db->where('id_dtw', $id_dtw);
        
        return $this->db->get();
        
    }

    // menampilkan tot jumlah rekap dtw all
    public function get_dtw_rekap_bulan_all($bulan, $jenis_w, $id_kota)
    {
        $this->db->select('sum(j.jumlah_pengunjung) as tot_dtw');
        $this->db->from('kota as k');
        $this->db->join('dtw as d', 'd.id_kota = k.id_kota', 'inner');
        $this->db->join("$jenis_w as j", 'j.id_dtw = d.id_dtw', 'inner');
        $this->db->where('k.id_kota', $id_kota);
        $this->db->where("DATE_FORMAT(j.add_time, '%Y-%m') = '$bulan'");
        $this->db->where('j.status', 1);
        
        return $this->db->get();
        
    }

    public function get_per_dtw_rekap_bulan_all($bulan, $jenis_w, $id_dtw)
    {
        $this->db->select('sum(j.jumlah_pengunjung) as tot_dtw');
        $this->db->from('dtw as d');
        $this->db->join("$jenis_w as j", 'j.id_dtw = d.id_dtw', 'inner');
        $this->db->where("DATE_FORMAT(j.add_time, '%Y-%m') = '$bulan'");
        $this->db->where('j.status', 1);
        $this->db->where('d.id_dtw', $id_dtw);

        return $this->db->get();
        
    }

    // Akhir 21-02-2020

    // 20-02-2020

    // Menampilkan list rekap kota dtw
    public function get_data_rekap_dtw_kota($bln_awal, $bln_akhir)
    {
        $this->_get_datatables_query_rekap_dtw_kota($bln_awal, $bln_akhir);

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_rekap_dtw_kota = [null, 'k.nama_kota', 'tot_dtw', 'tot_jml_wisnus_dtw', 'tot_jml_wisman_dtw', 'jumlah'];
    var $kolom_cari_rekap_dtw_kota  = ['LOWER(k.nama_kota)'];
    var $order_rekap_dtw_kota       = ['k.nama_kota' => 'asc'];

    public function _get_datatables_query_rekap_dtw_kota($bln_awal, $bln_akhir)
    {
        if ($bln_awal == '' || $bln_akhir == '') {
            $this->db->select('k.nama_kota, k.id_kota, (SELECT count(id_dtw) as tot_dtw FROM dtw as d where id_kota = k.id_kota) as tot_dtw, (SELECT sum(d.jumlah_pengunjung) as tot_jml_wisnus_dtw FROM rekap_wisnus_dtw as d JOIN dtw as o ON o.id_dtw = d.id_dtw JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1) as tot_jml_wisnus_dtw, (SELECT sum(d.jumlah_pengunjung) as tot_jml_wisman_dtw FROM rekap_wisman_dtw as d JOIN dtw as o ON o.id_dtw = d.id_dtw JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1) as tot_jml_wisman_dtw, (SELECT sum(d.jumlah_pengunjung) as tot_jml_wisnus_dtw FROM rekap_wisnus_dtw as d JOIN dtw as o ON o.id_dtw = d.id_dtw JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1) + (SELECT sum(d.jumlah_pengunjung) as tot_jml_wisman_dtw FROM rekap_wisman_dtw as d JOIN dtw as o ON o.id_dtw = d.id_dtw JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1) as jumlah');
            $this->db->from('kota as k');
        } else {

            $bln_awal   = nice_date($bln_awal, 'Y-m');
            $bln_akhir  = nice_date($bln_akhir, 'Y-m');

            $this->db->select("k.nama_kota, k.id_kota, (SELECT count(id_dtw) as tot_dtw FROM dtw as d where id_kota = k.id_kota) as tot_dtw, (SELECT sum(d.jumlah_pengunjung) as tot_jml_wisnus_dtw FROM rekap_wisnus_dtw as d JOIN dtw as o ON o.id_dtw = d.id_dtw JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1 and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$bln_awal' and '$bln_akhir') as tot_jml_wisnus_dtw, (SELECT sum(d.jumlah_pengunjung) as tot_jml_wisman_dtw FROM rekap_wisman_dtw as d JOIN dtw as o ON o.id_dtw = d.id_dtw JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1 and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$bln_awal' and '$bln_akhir') as tot_jml_wisman_dtw, (SELECT sum(d.jumlah_pengunjung) as tot_jml_wisnus_dtw FROM rekap_wisnus_dtw as d JOIN dtw as o ON o.id_dtw = d.id_dtw JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1 and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$bln_awal' and '$bln_akhir') + (SELECT sum(d.jumlah_pengunjung) as tot_jml_wisman_dtw FROM rekap_wisman_dtw as d JOIN dtw as o ON o.id_dtw = d.id_dtw JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1 and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$bln_awal' and '$bln_akhir') as jumlah");
            $this->db->from('kota as k');
        }

        $this->db->where('k.id_provinsi', 35);

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_rekap_dtw_kota;

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

            $kolom_order = $this->kolom_order_rekap_dtw_kota;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_rekap_dtw_kota)) {
            
            $order = $this->order_rekap_dtw_kota;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_rekap_dtw_kota($bln_awal, $bln_akhir)
    {
        if ($bln_awal == '' || $bln_akhir == '') {
            $this->db->select('k.nama_kota, k.id_kota, (SELECT count(id_dtw) as tot_dtw FROM dtw as d where id_kota = k.id_kota) as tot_dtw, (SELECT sum(d.jumlah_pengunjung) as tot_jml_wisnus_dtw FROM rekap_wisnus_dtw as d JOIN dtw as o ON o.id_dtw = d.id_dtw JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1) as tot_jml_wisnus_dtw, (SELECT sum(d.jumlah_pengunjung) as tot_jml_wisman_dtw FROM rekap_wisman_dtw as d JOIN dtw as o ON o.id_dtw = d.id_dtw JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1) as tot_jml_wisman_dtw, (SELECT sum(d.jumlah_pengunjung) as tot_jml_wisnus_dtw FROM rekap_wisnus_dtw as d JOIN dtw as o ON o.id_dtw = d.id_dtw JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1) + (SELECT sum(d.jumlah_pengunjung) as tot_jml_wisman_dtw FROM rekap_wisman_dtw as d JOIN dtw as o ON o.id_dtw = d.id_dtw JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1) as jumlah');
            $this->db->from('kota as k');
        } else {

            $bln_awal   = nice_date($bln_awal, 'Y-m');
            $bln_akhir  = nice_date($bln_akhir, 'Y-m');

            $this->db->select("k.nama_kota, k.id_kota, (SELECT count(id_dtw) as tot_dtw FROM dtw as d where id_kota = k.id_kota) as tot_dtw, (SELECT sum(d.jumlah_pengunjung) as tot_jml_wisnus_dtw FROM rekap_wisnus_dtw as d JOIN dtw as o ON o.id_dtw = d.id_dtw JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1 and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$bln_awal' and '$bln_akhir') as tot_jml_wisnus_dtw, (SELECT sum(d.jumlah_pengunjung) as tot_jml_wisman_dtw FROM rekap_wisman_dtw as d JOIN dtw as o ON o.id_dtw = d.id_dtw JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1 and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$bln_awal' and '$bln_akhir') as tot_jml_wisman_dtw, (SELECT sum(d.jumlah_pengunjung) as tot_jml_wisnus_dtw FROM rekap_wisnus_dtw as d JOIN dtw as o ON o.id_dtw = d.id_dtw JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1 and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$bln_awal' and '$bln_akhir') + (SELECT sum(d.jumlah_pengunjung) as tot_jml_wisman_dtw FROM rekap_wisman_dtw as d JOIN dtw as o ON o.id_dtw = d.id_dtw JOIN kota as t ON t.id_kota = o.id_kota where t.id_kota = k.id_kota and d.status = 1 and DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$bln_awal' and '$bln_akhir') as jumlah");
            $this->db->from('kota as k');
        }

        $this->db->where('k.id_provinsi', 35);

        return $this->db->count_all_results();
    }

    public function jumlah_filter_rekap_dtw_kota($bln_awal, $bln_akhir)
    {
        $this->_get_datatables_query_rekap_dtw_kota($bln_awal, $bln_akhir);

        return $this->db->get()->num_rows();
        
    }

    // Menampilkan list rekap dtw
    public function get_data_rekap_dtw($dt)
    {
        $this->_get_datatables_query_rekap_dtw($dt);

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_rekap_dtw = [null, 'd.nama_dtw', 'tot_jml_wisnus_dtw', 'tot_jml_wisman_dtw', 'jumlah'];
    var $kolom_cari_rekap_dtw  = ['LOWER(d.nama_dtw)'];
    var $order_rekap_dtw       = ['d.nama_dtw' => 'asc'];

    public function _get_datatables_query_rekap_dtw($dt)
    {
        if ($dt['bln_awal'] == '0' && $dt['bln_akhir'] == '0') {

            $this->db->select("d.nama_dtw, d.id_dtw, (SELECT sum(w.jumlah_pengunjung) as tot_jml_wisnus_dtw FROM rekap_wisnus_dtw as w where w.id_dtw = d.id_dtw and w.status = 1) as tot_jml_wisnus_dtw, (SELECT sum(w.jumlah_pengunjung) as tot_jml_wisman_dtw FROM rekap_wisman_dtw as w where w.id_dtw = d.id_dtw and w.status = 1) as tot_jml_wisman_dtw, COALESCE((SELECT sum(w.jumlah_pengunjung) as tot_jml_wisnus_dtw FROM rekap_wisnus_dtw as w where w.id_dtw = d.id_dtw and w.status = 1),0) + COALESCE((SELECT sum(w.jumlah_pengunjung) as tot_jml_wisman_dtw FROM rekap_wisman_dtw as w where w.id_dtw = d.id_dtw and w.status = 1),0) as jumlah");

            $this->db->from('dtw as d');

        } else {

            $bln_awal   = nice_date($dt['bln_awal'], 'Y-m');
            $bln_akhir  = nice_date($dt['bln_akhir'], 'Y-m');

            $this->db->select("d.nama_dtw, d.id_dtw, (SELECT sum(w.jumlah_pengunjung) as tot_jml_wisnus_dtw FROM rekap_wisnus_dtw as w where w.id_dtw = d.id_dtw and w.status = 1 and DATE_FORMAT(w.add_time, '%Y-%m') BETWEEN '$bln_awal' and '$bln_akhir') as tot_jml_wisnus_dtw, (SELECT sum(w.jumlah_pengunjung) as tot_jml_wisman_dtw FROM rekap_wisman_dtw as w where w.id_dtw = d.id_dtw and w.status = 1 and DATE_FORMAT(w.add_time, '%Y-%m') BETWEEN '$bln_awal' and '$bln_akhir') as tot_jml_wisman_dtw, COALESCE((SELECT sum(w.jumlah_pengunjung) as tot_jml_wisnus_dtw FROM rekap_wisnus_dtw as w where w.id_dtw = d.id_dtw and w.status = 1 and DATE_FORMAT(w.add_time, '%Y-%m') BETWEEN '$bln_awal' and '$bln_akhir'),0) + COALESCE((SELECT sum(w.jumlah_pengunjung) as tot_jml_wisman_dtw FROM rekap_wisman_dtw as w where w.id_dtw = d.id_dtw and w.status = 1 and DATE_FORMAT(w.add_time, '%Y-%m') BETWEEN '$bln_awal' and '$bln_akhir'),0) as jumlah");

            $this->db->from('dtw as d');
        }

        $this->db->where('d.id_kota', $dt['id_kota']);
        

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_rekap_dtw;

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

            $kolom_order = $this->kolom_order_rekap_dtw;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_rekap_dtw)) {
            
            $order = $this->order_rekap_dtw;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_rekap_dtw($dt)
    {
        if ($dt['bln_awal'] == '0' && $dt['bln_akhir'] == '0') {

            $this->db->select("d.nama_dtw, d.id_dtw, (SELECT sum(w.jumlah_pengunjung) as tot_jml_wisnus_dtw FROM rekap_wisnus_dtw as w where w.id_dtw = d.id_dtw and w.status = 1) as tot_jml_wisnus_dtw, (SELECT sum(w.jumlah_pengunjung) as tot_jml_wisman_dtw FROM rekap_wisman_dtw as w where w.id_dtw = d.id_dtw and w.status = 1) as tot_jml_wisman_dtw, COALESCE((SELECT sum(w.jumlah_pengunjung) as tot_jml_wisnus_dtw FROM rekap_wisnus_dtw as w where w.id_dtw = d.id_dtw and w.status = 1),0) + COALESCE((SELECT sum(w.jumlah_pengunjung) as tot_jml_wisman_dtw FROM rekap_wisman_dtw as w where w.id_dtw = d.id_dtw and w.status = 1),0) as jumlah");

            $this->db->from('dtw as d');

        } else {

            $bln_awal   = nice_date($dt['bln_awal'], 'Y-m');
            $bln_akhir  = nice_date($dt['bln_akhir'], 'Y-m');

            $this->db->select("d.nama_dtw, d.id_dtw, (SELECT sum(w.jumlah_pengunjung) as tot_jml_wisnus_dtw FROM rekap_wisnus_dtw as w where w.id_dtw = d.id_dtw and w.status = 1 and DATE_FORMAT(w.add_time, '%Y-%m') BETWEEN '$bln_awal' and '$bln_akhir') as tot_jml_wisnus_dtw, (SELECT sum(w.jumlah_pengunjung) as tot_jml_wisman_dtw FROM rekap_wisman_dtw as w where w.id_dtw = d.id_dtw and w.status = 1 and DATE_FORMAT(w.add_time, '%Y-%m') BETWEEN '$bln_awal' and '$bln_akhir') as tot_jml_wisman_dtw, COALESCE((SELECT sum(w.jumlah_pengunjung) as tot_jml_wisnus_dtw FROM rekap_wisnus_dtw as w where w.id_dtw = d.id_dtw and w.status = 1 and DATE_FORMAT(w.add_time, '%Y-%m') BETWEEN '$bln_awal' and '$bln_akhir'),0) + COALESCE((SELECT sum(w.jumlah_pengunjung) as tot_jml_wisman_dtw FROM rekap_wisman_dtw as w where w.id_dtw = d.id_dtw and w.status = 1 and DATE_FORMAT(w.add_time, '%Y-%m') BETWEEN '$bln_awal' and '$bln_akhir'),0) as jumlah");

            $this->db->from('dtw as d');
        }

        $this->db->where('d.id_kota', $dt['id_kota']);

        return $this->db->count_all_results();
    }

    public function jumlah_filter_rekap_dtw($dt)
    {
        $this->_get_datatables_query_rekap_dtw($dt);

        return $this->db->get()->num_rows();
        
    }

    // Akhir 20-02-2020

    // AFIF

    public function cari_data($tabel, $where)
    {
        return $this->db->get_where($tabel, $where);
    }

    public function cari_tot_jumlah($tabel, $id_dtw, $periode)
    {
        $this->db->select('sum(d.jumlah_pengunjung) as tot_jumlah');
        $this->db->from("$tabel as d");
        if ($periode != 'awal') {
            // $this->db->where("DATE_FORMAT(d.add_time, '%Y-%m') = '$periode'");
            $this->db->where("DATE_FORMAT(STR_TO_DATE(d.periode,'%d-%M-%Y'), '%Y-%m') = '$periode'");
        }
        $this->db->where('d.id_dtw', $id_dtw);
        $this->db->where('d.status', 1);
        
        
        return $this->db->get();
        
    }

    public function data_rekap_wisnus_p($id_dtw, $id_periode)
    {
        // SELECT p.nama_provinsi, (select sum(pengunjung_pria) FROM rekap_wisnus_dtw WHERE id_dtw=1 and id_provinsi=p.id_provinsi and periode='15-December-2019')  as tot_pria, (select sum(pengunjung_wanita) FROM rekap_wisnus_dtw WHERE id_dtw=1 and id_provinsi=p.id_provinsi and periode='15-December-2019')  as tot_wanita, (select sum(jumlah_pengunjung) FROM rekap_wisnus_dtw WHERE id_dtw=1 and id_provinsi=p.id_provinsi and periode='15-December-2019')  as tot_jumlah
        // FROM provinsi as p
        // ORDER BY p.nama_provinsi ASC 

        if ($id_periode == '' || $id_periode == 'awal') {
            $this->db->select("p.nama_provinsi, (select sum(pengunjung_pria) FROM rekap_wisnus_dtw WHERE id_dtw=$id_dtw and id_provinsi=p.id_provinsi and status = 1)  as tot_pria, (select sum(pengunjung_wanita) FROM rekap_wisnus_dtw WHERE id_dtw=$id_dtw and id_provinsi=p.id_provinsi and status = 1)  as tot_wanita, (select sum(jumlah_pengunjung) FROM rekap_wisnus_dtw WHERE id_dtw=$id_dtw and id_provinsi=p.id_provinsi and status = 1)  as tot_jumlah");
            
        } else {
            
            $this->db->select("p.nama_provinsi, (select sum(pengunjung_pria) FROM rekap_wisnus_dtw WHERE id_dtw=$id_dtw and id_provinsi=p.id_provinsi and DATE_FORMAT(STR_TO_DATE(periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and status = 1)  as tot_pria, (select sum(pengunjung_wanita) FROM rekap_wisnus_dtw WHERE id_dtw=$id_dtw and id_provinsi=p.id_provinsi and DATE_FORMAT(STR_TO_DATE(periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and status = 1)  as tot_wanita, (select sum(jumlah_pengunjung) FROM rekap_wisnus_dtw WHERE id_dtw=$id_dtw and id_provinsi=p.id_provinsi and DATE_FORMAT(STR_TO_DATE(periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and status = 1)  as tot_jumlah");
        }

        $this->db->from('provinsi as p');
        $this->db->order_by('p.nama_provinsi', 'asc');
        
        return $this->db->get()->result();
        
    }

    public function data_wisman_p($kws, $id_dtw, $id_periode)
    {
        // SELECT n.nama_negara, (select sum(pengunjung_pria) FROM rekap_wisman_dtw WHERE id_dtw=1 and id_negara=n.id_negara and periode='15-December-2019')  as tot_pria, (select sum(pengunjung_wanita) FROM rekap_wisman_dtw WHERE id_dtw=1 and id_negara=n.id_negara and periode='15-December-2019')  as tot_wanita, (select sum(jumlah_pengunjung) FROM rekap_wisman_dtw WHERE id_dtw=1 and id_negara=n.id_negara and periode='15-December-2019')  as tot_jumlah
        // FROM negara as n
        // JOIN kawasan as k ON k.id_kawasan = n.id_kawasan
        // WHERE k.nama_kawasan = 'ASIA'
        // ORDER BY nama_kawasan ASC

        if ($id_periode == '' || $id_periode == 'awal') {
            $this->db->select("n.nama_negara, (select sum(pengunjung_pria) FROM rekap_wisman_dtw WHERE id_dtw=$id_dtw and id_negara=n.id_negara and status = 1)  as tot_pria, (select sum(pengunjung_wanita) FROM rekap_wisman_dtw WHERE id_dtw=$id_dtw and id_negara=n.id_negara and status = 1)  as tot_wanita, (select sum(jumlah_pengunjung) FROM rekap_wisman_dtw WHERE id_dtw=$id_dtw and id_negara=n.id_negara and status = 1)  as tot_jumlah");

        } else {
            $this->db->select("n.nama_negara, (select sum(pengunjung_pria) FROM rekap_wisman_dtw WHERE id_dtw=$id_dtw and id_negara=n.id_negara and DATE_FORMAT(STR_TO_DATE(periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and status = 1)  as tot_pria, (select sum(pengunjung_wanita) FROM rekap_wisman_dtw WHERE id_dtw=$id_dtw and id_negara=n.id_negara and DATE_FORMAT(STR_TO_DATE(periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and status = 1)  as tot_wanita, (select sum(jumlah_pengunjung) FROM rekap_wisman_dtw WHERE id_dtw=$id_dtw and id_negara=n.id_negara and DATE_FORMAT(STR_TO_DATE(periode,'%d-%M-%Y'), '%Y-%m') = '$id_periode' and status = 1)  as tot_jumlah");
        }

        $this->db->from('negara as n');
        $this->db->join('kawasan as k', 'k.id_kawasan = n.id_kawasan', 'inner');
        $this->db->where('k.nama_kawasan', $kws);
        $this->db->order_by('k.nama_kawasan', 'asc');
        
        return $this->db->get()->result();
        
    }

    // AKHIR

    public function get_dtw($id)
    {
        $q = $this->db->query("select * from dtw LEFT join(select sum(wisnus.jumlah_pengunjung)  as total_wisnus,wisnus.id_dtw as id_d from rekap_wisnus_dtw as wisnus GROUP BY wisnus.id_dtw)wisnus ON wisnus.id_d = dtw.id_dtw LEFT join(select sum(wisman.jumlah_pengunjung)  as total_wisman,wisman.id_dtw  as id_d
        from rekap_wisman_dtw as wisman GROUP BY wisman.id_dtw)wisman ON wisman.id_d = dtw.id_dtw WHERE dtw.id_kota=$id");
        return $q->result();
    }

    public function get_dtw_kota($id_kota)
    {
        $q = $this->db->query("select * from dtw LEFT join(select sum(wisnus.jumlah_pengunjung)  as total_wisnus,wisnus.id_dtw as id_d from rekap_wisnus_dtw as wisnus WHERE status = 1 GROUP BY wisnus.id_dtw)wisnus ON wisnus.id_d = dtw.id_dtw LEFT join(select sum(wisman.jumlah_pengunjung)  as total_wisman,wisman.id_dtw  as id_d
        from rekap_wisman_dtw as wisman WHERE status = 1 GROUP BY wisman.id_dtw)wisman ON wisman.id_d = dtw.id_dtw WHERE dtw.id_kota=$id_kota");

        return $q->result();
    }

    public function get_dtw_prov()
    {
        $q = $this->db->query("select * from dtw LEFT join(select sum(wisnus.jumlah_pengunjung)  as total_wisnus,wisnus.id_dtw as id_d from rekap_wisnus_dtw as wisnus WHERE status = 1 GROUP BY wisnus.id_dtw)wisnus ON wisnus.id_d = dtw.id_dtw LEFT join(select sum(wisman.jumlah_pengunjung)  as total_wisman,wisman.id_dtw  as id_d
        from rekap_wisman_dtw as wisman WHERE status = 1 GROUP BY wisman.id_dtw)wisman ON wisman.id_d = dtw.id_dtw");
        return $q->result();
    }

    public function get_by_dtw($id_dtw)
    {
        $q = $this->db->query("select * from dtw LEFT join(select sum(wisnus.jumlah_pengunjung)  as total_wisnus,wisnus.id_dtw as id_d from rekap_wisnus_dtw as wisnus GROUP BY wisnus.id_dtw)wisnus ON wisnus.id_d = dtw.id_dtw LEFT join(select sum(wisman.jumlah_pengunjung)  as total_wisman,wisman.id_dtw  as id_d
        from rekap_wisman_dtw as wisman GROUP BY wisman.id_dtw)wisman ON wisman.id_d = dtw.id_dtw WHERE dtw.id_dtw = $id_dtw");
        return $q->result();
    }

    public function get_dtw_petugas($id_petugas)
    {
        $q = $this->db->query("select * from dtw INNER JOIN penempatan_dtw on(dtw.id_dtw = penempatan_dtw.id_dtw ) LEFT join(select sum(wisnus.jumlah_pengunjung)  as total_wisnus,wisnus.id_dtw as id_d from rekap_wisnus_dtw as wisnus WHERE status = 1 GROUP BY wisnus.id_dtw)wisnus ON wisnus.id_d = dtw.id_dtw LEFT join(select sum(wisman.jumlah_pengunjung)  as total_wisman,wisman.id_dtw  as id_d
        from rekap_wisman_dtw as wisman WHERE status = 1 GROUP BY wisman.id_dtw)wisman ON wisman.id_d = dtw.id_dtw WHERE penempatan_dtw.id_pegawai = $id_petugas");
        
        return $q->result();
    }

    public function get_dtw_list()
    {
        return $this->db->get('dtw')->result();
    }

    public function get_provinsi()
    {
        $this->db->order_by('nama_provinsi', 'ASC');
        return $this->db->get('provinsi')->result();
    }

    public function get_wisnus_rekap_dtw($id)
    {
        $this->db->select('*');
        $this->db->from('rekap_wisnus_dtw as rwd');
        $this->db->join('provinsi as p', 'p.id_provinsi = rwd.id_provinsi');
        $this->db->join('dtw', 'dtw.id_dtw = rwd.id_dtw');
        $this->db->where('rwd.id_dtw', $id);
        
        return $this->db->get()->result();
    }

    public function asia($id)
    {
        $this->db->select('*');
        $this->db->from('rekap_wisman_dtw as rwd');
        $this->db->join('negara', 'negara.id_negara = rwd.id_negara');
        $this->db->join('kawasan', 'kawasan.id_kawasan = negara.id_kawasan');
        $this->db->where('id_dtw', $id);
        $this->db->where('nama_kawasan', 'ASIA');
        return $this->db->get()->result();
    }

    public function afrika($id)
    {
        $this->db->select('*');
        $this->db->from('rekap_wisman_dtw as rwd');
        $this->db->join('negara', 'negara.id_negara = rwd.id_negara');
        $this->db->join('kawasan', 'kawasan.id_kawasan = negara.id_kawasan');
        $this->db->where('id_dtw', $id);
        $this->db->where('nama_kawasan', 'AFRIKA');
        return $this->db->get()->result();
    }

    public function amerika($id)
    {
        $this->db->select('*');
        $this->db->from('rekap_wisman_dtw as rwd');
        $this->db->join('negara', 'negara.id_negara = rwd.id_negara');
        $this->db->join('kawasan', 'kawasan.id_kawasan = negara.id_kawasan');
        $this->db->where('id_dtw', $id);
        $this->db->where('nama_kawasan', 'AMERIKA');
        return $this->db->get()->result();
    }

    public function australia($id)
    {
        $this->db->select('*');
        $this->db->from('rekap_wisman_dtw as rwd');
        $this->db->join('negara', 'negara.id_negara = rwd.id_negara');
        $this->db->join('kawasan', 'kawasan.id_kawasan = negara.id_kawasan');
        $this->db->where('id_dtw', $id);
        $this->db->where('nama_kawasan', 'AUSTRALIA');
        return $this->db->get()->result();
    }

    public function eropa($id)
    {
        $this->db->select('*');
        $this->db->from('rekap_wisman_dtw as rwd');
        $this->db->join('negara', 'negara.id_negara = rwd.id_negara');
        $this->db->join('kawasan', 'kawasan.id_kawasan = negara.id_kawasan');
        $this->db->where('id_dtw', $id);
        $this->db->where('nama_kawasan', 'EROPA');
        return $this->db->get()->result();
    }

    public function get_wisnus_rekap_dtw2($id,$per)
    {
        $this->db->select('*');
        $this->db->from('rekap_wisnus_dtw as rwd');
        $this->db->join('provinsi as p', 'p.id_provinsi = rwd.id_provinsi');
        $this->db->join('dtw', 'dtw.id_dtw = rwd.id_dtw');
        $this->db->where('rwd.id_dtw', $id);
        $this->db->where('periode', $per);
        
        return $this->db->get()->result();
    }

    public function asia2($id,$per)
    {
        $this->db->select('*');
        $this->db->from('rekap_wisman_dtw as rwd');
        $this->db->join('negara', 'negara.id_negara = rwd.id_negara');
        $this->db->join('kawasan', 'kawasan.id_kawasan = negara.id_kawasan');
        $this->db->where('id_dtw', $id);
        $this->db->where('nama_kawasan', 'ASIA');
        $this->db->where('periode', $per);
        return $this->db->get()->result();
    }

    public function afrika2($id,$per)
    {
        $this->db->select('*');
        $this->db->from('rekap_wisman_dtw as rwd');
        $this->db->join('negara', 'negara.id_negara = rwd.id_negara');
        $this->db->join('kawasan', 'kawasan.id_kawasan = negara.id_kawasan');
        $this->db->where('id_dtw', $id);
        $this->db->where('nama_kawasan', 'AFRIKA');
        $this->db->where('periode', $per);
        return $this->db->get()->result();
    }

    public function amerika2($id,$per)
    {
        $this->db->select('*');
        $this->db->from('rekap_wisman_dtw as rwd');
        $this->db->join('negara', 'negara.id_negara = rwd.id_negara');
        $this->db->join('kawasan', 'kawasan.id_kawasan = negara.id_kawasan');
        $this->db->where('id_dtw', $id);
        $this->db->where('nama_kawasan', 'AMERIKA');
        $this->db->where('periode', $per);
        return $this->db->get()->result();
    }

    public function australia2($id,$per)
    {
        $this->db->select('*');
        $this->db->from('rekap_wisman_dtw as rwd');
        $this->db->join('negara', 'negara.id_negara = rwd.id_negara');
        $this->db->join('kawasan', 'kawasan.id_kawasan = negara.id_kawasan');
        $this->db->where('id_dtw', $id);
        $this->db->where('nama_kawasan', 'AUSTRALIA');
        $this->db->where('periode', $per);
        return $this->db->get()->result();
    }

    public function eropa2($id,$per)
    {
        $this->db->select('*');
        $this->db->from('rekap_wisman_dtw as rwd');
        $this->db->join('negara', 'negara.id_negara = rwd.id_negara');
        $this->db->join('kawasan', 'kawasan.id_kawasan = negara.id_kawasan');
        $this->db->where('id_dtw', $id);
        $this->db->where('nama_kawasan', 'EROPA');
        $this->db->where('periode', $per);
        return $this->db->get()->result();
    }

    // public function fil_periode($per,$id)
    // {
    //     $this->db->select('*');
    //     $this->db->from('rekap_wisnus_dtw as rwd');
    //     $this->db->join('provinsi as p', 'p.id_provinsi = rwd.id_provinsi');
    //     $this->db->join('dtw', 'dtw.id_dtw = rwd.id_dtw');
    //     $this->db->where("rwd.periode ='".$per."-01' ");
    //     $this->db->order_by('nama_dtw', 'asc');
    //     return $this->db->get()->result();
    // }
}
