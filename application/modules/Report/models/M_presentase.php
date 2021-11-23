<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_presentase extends CI_Model {

    // 26-02-2020

    public function cari_data($tabel, $where)
    {
        return $this->db->get_where($tabel, $where);
    }

    public function get_data_order($tabel, $field, $order)
    {
        $this->db->order_by($field, $order);
        
        return $this->db->get($tabel);
    }

    public function data_perbandingan_provinsi($bln_skrg, $bln, $thn_skrg, $thn, $aksi)
    {
        $jml = $this->db->get('provinsi')->num_rows();

        $thn_skrg_a = $thn_skrg."-01";
        $thn_skrg_k = $thn_skrg."-12";

        $thn_a = $thn."-01";
        $thn_k = $thn."-12";

        $id_kota = $this->session->userdata('userdata')->id_kota;

        $lvl = $this->session->userdata('level');

        if ($lvl == 'kota') {
            $where = "and k.id_kota = '$id_kota'";
        } else {
            $where = "";
        }

        $tot_jumlah_bulan_awal   = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 $where and j.id_provinsi = p.id_provinsi and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '$bln' and j.status = 1),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 $where and j.id_provinsi = p.id_provinsi and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '$bln' and j.status = 1),0)";

        $tot_jumlah_bulan_akhir = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 $where and j.id_provinsi = p.id_provinsi and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '$bln_skrg' and j.status = 1),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 $where and j.id_provinsi = p.id_provinsi and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '$bln_skrg' and j.status = 1),0)";

        $tot_jumlah_tahun_awal = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 $where and j.id_provinsi = p.id_provinsi and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$thn_a' and '$thn_k'),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 $where and j.id_provinsi = p.id_provinsi and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$thn_a' and '$thn_k'),0)";

        $tot_jumlah_tahun_akhir = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 $where and j.id_provinsi = p.id_provinsi and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$thn_skrg_a' and '$thn_skrg_k'),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 $where and j.id_provinsi = p.id_provinsi and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$thn_skrg_a' and '$thn_skrg_k'),0)";

        $this->db->select("p.nama_provinsi, 
        ($tot_jumlah_bulan_awal) as tot_jumlah_bulan_awal, 
        ($tot_jumlah_bulan_akhir) as tot_jumlah_bulan_akhir, 
        ($tot_jumlah_tahun_awal) as tot_jumlah_tahun_awal, 
        ($tot_jumlah_tahun_akhir) as tot_jumlah_tahun_akhir, 
        COALESCE(FORMAT((((CAST($tot_jumlah_bulan_akhir as SIGNED) - CAST($tot_jumlah_bulan_awal as SIGNED)) / CAST($tot_jumlah_bulan_awal as SIGNED)) * 100),2),0) as m_on_m, 
        COALESCE(FORMAT((((CAST($tot_jumlah_tahun_akhir as SIGNED) - CAST($tot_jumlah_tahun_awal as SIGNED)) / CAST($tot_jumlah_tahun_awal as SIGNED)) * 100),2),0) as y_on_y");

        $this->db->from('provinsi as p');
        $this->db->order_by('tot_jumlah_tahun_akhir', 'desc');

        if ($aksi == 'lainnya') {
            $this->db->limit($jml, 10);
        } else {
            $this->db->limit(10);
        }

        return $this->db->get();

    }

    public function tes()
    {
        $tot_jumlah_bulan_awal   = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and j.id_provinsi = p.id_provinsi and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '2019-12' and j.status = 1),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and j.id_provinsi = p.id_provinsi and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '2019-12' and j.status = 1),0)";

        $tot_jumlah_bulan_akhir = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and j.id_provinsi = p.id_provinsi and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '2020-01' and j.status = 1),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and j.id_provinsi = p.id_provinsi and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '2020-01' and j.status = 1),0)";

        $tot_jumlah_tahun_awal = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and j.id_provinsi = p.id_provinsi and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '2019-01' and '2019-12'),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and j.id_provinsi = p.id_provinsi and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '2019-01' and '2019-01'),0)";

        $tot_jumlah_tahun_akhir = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and j.id_provinsi = p.id_provinsi and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '2020-01' and '2020-12'),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and j.id_provinsi = p.id_provinsi and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '2020-01' and '2020-12'),0)";

        $this->db->select("p.nama_provinsi, 
        ($tot_jumlah_bulan_awal) as tot_jumlah_bulan_awal, 
        ($tot_jumlah_bulan_akhir) as tot_jumlah_bulan_akhir, 
        ($tot_jumlah_tahun_awal) as tot_jumlah_tahun_awal, 
        ($tot_jumlah_tahun_akhir) as tot_jumlah_tahun_akhir, 
        COALESCE(FORMAT((((CAST($tot_jumlah_bulan_akhir as SIGNED) - CAST($tot_jumlah_bulan_awal as SIGNED)) / CAST($tot_jumlah_bulan_awal as SIGNED)) * 100),2),0) as m_on_m, 
        COALESCE(FORMAT((((CAST($tot_jumlah_tahun_akhir as SIGNED) - CAST($tot_jumlah_tahun_awal as SIGNED)) / CAST($tot_jumlah_tahun_awal as SIGNED)) * 100),2),0) as y_on_y");

        $this->db->from('provinsi as p');
        $this->db->order_by('tot_jumlah_tahun_akhir', 'desc');
        $this->db->limit(10);
        
        return $this->db->get();
        
    }

    // Akhir 26-02-2020

    // 27-02-2020

        public function data_perbandingan_negara($bln_skrg, $bln, $thn_skrg, $thn, $aksi)
        {
            $jml = $this->db->get('negara')->num_rows();
            
            $thn_skrg_a = $thn_skrg."-01";
            $thn_skrg_k = $thn_skrg."-12";

            $thn_a = $thn."-01";
            $thn_k = $thn."-12";

            $tot_jumlah_bulan_awal   = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and j.id_negara = p.id_negara and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '$bln' and j.status = 1),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and j.id_negara = p.id_negara and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '$bln' and j.status = 1),0)";

            $tot_jumlah_bulan_akhir = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and j.id_negara = p.id_negara and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '$bln_skrg' and j.status = 1),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and j.id_negara = p.id_negara and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '$bln_skrg' and j.status = 1),0)";

            $tot_jumlah_tahun_awal = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and j.id_negara = p.id_negara and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$thn_a' and '$thn_k'),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and j.id_negara = p.id_negara and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$thn_a' and '$thn_k'),0)";

            $tot_jumlah_tahun_akhir = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and j.id_negara = p.id_negara and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$thn_skrg_a' and '$thn_skrg_k'),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and j.id_negara = p.id_negara and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$thn_skrg_a' and '$thn_skrg_k'),0)";

            $this->db->select("p.nama_negara, 
            ($tot_jumlah_bulan_awal) as tot_jumlah_bulan_awal, 
            ($tot_jumlah_bulan_akhir) as tot_jumlah_bulan_akhir, 
            ($tot_jumlah_tahun_awal) as tot_jumlah_tahun_awal, 
            ($tot_jumlah_tahun_akhir) as tot_jumlah_tahun_akhir, 
            COALESCE(FORMAT((((CAST($tot_jumlah_bulan_akhir as SIGNED) - CAST($tot_jumlah_bulan_awal as SIGNED)) / CAST($tot_jumlah_bulan_awal as SIGNED)) * 100),2),0) as m_on_m, 
            COALESCE(FORMAT((((CAST($tot_jumlah_tahun_akhir as SIGNED) - CAST($tot_jumlah_tahun_awal as SIGNED)) / CAST($tot_jumlah_tahun_awal as SIGNED)) * 100),2),0) as y_on_y");

            $this->db->from('negara as p');
            $this->db->order_by('tot_jumlah_tahun_akhir', 'desc');
            
            if ($aksi == 'lainnya') {
                $this->db->limit($jml, 10);
            } else {
                $this->db->limit(10);
            }
            
            return $this->db->get();

        }

        // menampilkan perbandingan provinsi filter
        public function data_perbandingan_provinsi_filter($data)
        {
            $id_kota      = $data['id_kota'];
            $jenis_data   = $data['jenis_data'];
            $bulan_awal   = date('Y-m', strtotime($data['bulan_awal']));
            $bulan_akhir  = date('Y-m', strtotime($data['bulan_akhir']));
            $id_dtw_hotel = $data['id_dtw_hotel'];

            // cek tahun bulan awal dan akhir 
            $bl_awal    = date('Y', strtotime($bulan_awal));
            $bl_akhir   = date('Y', strtotime($bulan_akhir));
 
            if ($data['bulan_awal'] != '') {
                if ($bl_awal == $bl_akhir) {
                    $bulan_awal_thn2   = date('Y', strtotime("-1 years", strtotime($bulan_akhir)));
                    $bulan_akhir_thn2  = date('Y', strtotime($bulan_akhir));
                } else {
                    $bulan_awal_thn2   = date('Y', strtotime($bulan_awal));
                    $bulan_akhir_thn2  = date('Y', strtotime($bulan_akhir));
                }
            } else {
                $bulan_akhir = date("Y-m", now('Asia/Jakarta'));
                $bulan_awal  = date('Y-m', strtotime("-1 month", strtotime($bulan_akhir)));

                $bulan_akhir_thn2   = date("Y", now('Asia/Jakarta'));
                $bulan_awal_thn2    = date('Y', strtotime("-1 years", strtotime($bulan_akhir_thn2)));
            }

            $jml = $this->db->get('provinsi')->num_rows();

            $bulan_akhir_thn_a = $bulan_akhir_thn2."-01";
            $bulan_akhir_thn_k = $bulan_akhir_thn2."-12";

            $bulan_awal_thn_a = $bulan_awal_thn2."-01";
            $bulan_awal_thn_k = $bulan_awal_thn2."-12";

            if ($id_kota != '-') {
                $where_kota = "and k.id_kota = '$id_kota'";
            } else {
                $where_kota = "";
            }

            if ($id_dtw_hotel != 'all') {
                $where_dtw_hotel = "and d.id_$jenis_data = '$id_dtw_hotel'";
            } else {
                $where_dtw_hotel = "";
            }

            if ($jenis_data == 'dtw') {
                $tot_jumlah_bulan_awal   = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_provinsi = p.id_provinsi and k.id_provinsi = 35 $where_kota $where_dtw_hotel and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan_awal' and j.status = 1),0)";
            } elseif ($jenis_data == 'hotel') {
                $tot_jumlah_bulan_awal   = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_provinsi = p.id_provinsi and k.id_provinsi = 35 $where_kota $where_dtw_hotel and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan_awal' and j.status = 1),0)";
            } else {
                $tot_jumlah_bulan_awal   = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_provinsi = p.id_provinsi and k.id_provinsi = 35 $where_kota and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan_awal' and j.status = 1),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_provinsi = p.id_provinsi and k.id_provinsi = 35 $where_kota and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan_awal' and j.status = 1),0)";
            }

            if ($jenis_data == 'dtw') {
                $tot_jumlah_bulan_akhir   = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_provinsi = p.id_provinsi and k.id_provinsi = 35 $where_kota $where_dtw_hotel and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan_akhir' and j.status = 1),0)";
            } elseif ($jenis_data == 'hotel') {
                $tot_jumlah_bulan_akhir   = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_provinsi = p.id_provinsi and k.id_provinsi = 35 $where_kota $where_dtw_hotel and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan_akhir' and j.status = 1),0)";
            } else {
                $tot_jumlah_bulan_akhir   = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_provinsi = p.id_provinsi and k.id_provinsi = 35 $where_kota and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan_akhir' and j.status = 1),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_provinsi = p.id_provinsi and k.id_provinsi = 35 $where_kota and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan_akhir' and j.status = 1),0)";
            }

            if ($jenis_data == 'dtw') {
                $tot_jumlah_tahun_awal   = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_provinsi = p.id_provinsi and k.id_provinsi = 35 $where_kota $where_dtw_hotel and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$bulan_awal_thn_a' and '$bulan_awal_thn_k'),0)";
            } elseif ($jenis_data == 'hotel') {
                $tot_jumlah_tahun_awal   = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_provinsi = p.id_provinsi and k.id_provinsi = 35 $where_kota $where_dtw_hotel and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$bulan_awal_thn_a' and '$bulan_awal_thn_k'),0)";
            } else {
                $tot_jumlah_tahun_awal = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_provinsi = p.id_provinsi and k.id_provinsi = 35 $where_kota and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$bulan_awal_thn_a' and '$bulan_awal_thn_k'),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_provinsi = p.id_provinsi and k.id_provinsi = 35 $where_kota and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$bulan_awal_thn_a' and '$bulan_awal_thn_k'),0)";
            }

            if ($jenis_data == 'dtw') {
                $tot_jumlah_tahun_akhir   = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_provinsi = p.id_provinsi and k.id_provinsi = 35 $where_kota $where_dtw_hotel and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$bulan_akhir_thn_a' and '$bulan_akhir_thn_k'),0)";
            } elseif ($jenis_data == 'hotel') {
                $tot_jumlah_tahun_akhir   = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_provinsi = p.id_provinsi and k.id_provinsi = 35 $where_kota $where_dtw_hotel and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$bulan_akhir_thn_a' and '$bulan_akhir_thn_k'),0)";
            } else {
                $tot_jumlah_tahun_akhir = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_provinsi = p.id_provinsi and k.id_provinsi = 35 $where_kota and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$bulan_akhir_thn_a' and '$bulan_akhir_thn_k'),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_provinsi = p.id_provinsi and k.id_provinsi = 35 $where_kota and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$bulan_akhir_thn_a' and '$bulan_akhir_thn_k'),0)";
            }

            $this->db->select("p.nama_provinsi, 
            ($tot_jumlah_bulan_awal) as tot_jumlah_bulan_awal, 
            ($tot_jumlah_bulan_akhir) as tot_jumlah_bulan_akhir, 
            ($tot_jumlah_tahun_awal) as tot_jumlah_tahun_awal, 
            ($tot_jumlah_tahun_akhir) as tot_jumlah_tahun_akhir, 
            COALESCE(FORMAT((((CAST($tot_jumlah_bulan_akhir as SIGNED) - CAST($tot_jumlah_bulan_awal as SIGNED)) / CAST($tot_jumlah_bulan_awal as SIGNED)) * 100),2),0) as m_on_m, 
            COALESCE(FORMAT((((CAST($tot_jumlah_tahun_akhir as SIGNED) - CAST($tot_jumlah_tahun_awal as SIGNED)) / CAST($tot_jumlah_tahun_awal as SIGNED)) * 100),2),0) as y_on_y");

            $this->db->from('provinsi as p');
            $this->db->order_by('tot_jumlah_tahun_akhir', 'desc');

            if ($data['aksi'] == 'lainnya') {
                $this->db->limit($jml, 10);
            } else {
                $this->db->limit(10);
            }

            return $this->db->get();
        }

        // menampilkan perbandingan negara filter
        public function data_perbandingan_negara_filter($data)
        {
            $id_kota      = $data['id_kota'];
            $jenis_data   = $data['jenis_data'];
            $bulan_awal   = date('Y-m', strtotime($data['bulan_awal']));
            $bulan_akhir  = date('Y-m', strtotime($data['bulan_akhir']));
            $id_dtw_hotel = $data['id_dtw_hotel'];

            // cek tahun bulan awal dan akhir 
            $bl_awal    = date('Y', strtotime($bulan_awal));
            $bl_akhir   = date('Y', strtotime($bulan_akhir));

            if ($data['bulan_awal'] != '') {
                if ($bl_awal == $bl_akhir) {
                    $bulan_awal_thn2   = date('Y', strtotime("-1 years", strtotime($bulan_akhir)));
                    $bulan_akhir_thn2  = date('Y', strtotime($bulan_akhir));
                } else {
                    $bulan_awal_thn2   = date('Y', strtotime($bulan_awal));
                    $bulan_akhir_thn2  = date('Y', strtotime($bulan_akhir));
                }
            } else {
                $bulan_akhir = date("Y-m", now('Asia/Jakarta'));
                $bulan_awal      = date('Y-m', strtotime("-1 month", strtotime($bulan_akhir)));

                $bulan_akhir_thn2   = date("Y", now('Asia/Jakarta'));
                $bulan_awal_thn2     = date('Y', strtotime("-1 years", strtotime($bulan_akhir_thn2)));
            }

            $jml = $this->db->get('negara')->num_rows();

            $bulan_akhir_thn_a = $bulan_akhir_thn2."-01";
            $bulan_akhir_thn_k = $bulan_akhir_thn2."-12";

            $bulan_awal_thn_a = $bulan_awal_thn2."-01";
            $bulan_awal_thn_k = $bulan_awal_thn2."-12";

            if ($id_kota != '-') {
                $where_kota = "and k.id_kota = '$id_kota'";
            } else {
                $where_kota = "";
            }

            if ($id_dtw_hotel != 'all') {
                $where_dtw_hotel = "and d.id_$jenis_data = '$id_dtw_hotel'";
            } else {
                $where_dtw_hotel = "";
            }

            if ($jenis_data == 'dtw') {
                $tot_jumlah_bulan_awal   = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_negara = p.id_negara and k.id_provinsi = 35 $where_kota $where_dtw_hotel and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan_awal' and j.status = 1),0)";
            } elseif ($jenis_data == 'hotel') {
                $tot_jumlah_bulan_awal   = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_negara = p.id_negara and k.id_provinsi = 35 $where_kota $where_dtw_hotel and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan_awal' and j.status = 1),0)";
            } else {
                $tot_jumlah_bulan_awal   = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_negara = p.id_negara and k.id_provinsi = 35 $where_kota and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan_awal' and j.status = 1),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_negara = p.id_negara and k.id_provinsi = 35 $where_kota and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan_awal' and j.status = 1),0)";
            }

            if ($jenis_data == 'dtw') {
                $tot_jumlah_bulan_akhir   = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_negara = p.id_negara and k.id_provinsi = 35 $where_kota $where_dtw_hotel and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan_akhir' and j.status = 1),0)";
            } elseif ($jenis_data == 'hotel') {
                $tot_jumlah_bulan_akhir   = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_negara = p.id_negara and k.id_provinsi = 35 $where_kota $where_dtw_hotel and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan_akhir' and j.status = 1),0)";
            } else {
                $tot_jumlah_bulan_akhir   = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_negara = p.id_negara and k.id_provinsi = 35 $where_kota and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan_akhir' and j.status = 1),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_negara = p.id_negara and k.id_provinsi = 35 $where_kota and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan_akhir' and j.status = 1),0)";
            }

            if ($jenis_data == 'dtw') {
                $tot_jumlah_tahun_awal   = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_negara = p.id_negara and k.id_provinsi = 35 $where_kota $where_dtw_hotel and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$bulan_awal_thn_a' and '$bulan_awal_thn_k'),0)";
            } elseif ($jenis_data == 'hotel') {
                $tot_jumlah_tahun_awal   = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_negara = p.id_negara and k.id_provinsi = 35 $where_kota $where_dtw_hotel and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$bulan_awal_thn_a' and '$bulan_awal_thn_k'),0)";
            } else {
                $tot_jumlah_tahun_awal = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_negara = p.id_negara and k.id_provinsi = 35 $where_kota and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$bulan_awal_thn_a' and '$bulan_awal_thn_k'),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_negara = p.id_negara and k.id_provinsi = 35 $where_kota and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$bulan_awal_thn_a' and '$bulan_awal_thn_k'),0)";
            }

            if ($jenis_data == 'dtw') {
                $tot_jumlah_tahun_akhir   = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_negara = p.id_negara and k.id_provinsi = 35 $where_kota $where_dtw_hotel and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$bulan_akhir_thn_a' and '$bulan_akhir_thn_k'),0)";
            } elseif ($jenis_data == 'hotel') {
                $tot_jumlah_tahun_akhir   = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_negara = p.id_negara and k.id_provinsi = 35 $where_kota $where_dtw_hotel and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$bulan_akhir_thn_a' and '$bulan_akhir_thn_k'),0)";
            } else {
                $tot_jumlah_tahun_akhir = "COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_negara = p.id_negara and k.id_provinsi = 35 $where_kota and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$bulan_akhir_thn_a' and '$bulan_akhir_thn_k'),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_negara = p.id_negara and k.id_provinsi = 35 $where_kota and j.status = 1 and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m') BETWEEN '$bulan_akhir_thn_a' and '$bulan_akhir_thn_k'),0)";
            }

            $this->db->select("p.nama_negara, 
            ($tot_jumlah_bulan_awal) as tot_jumlah_bulan_awal, 
            ($tot_jumlah_bulan_akhir) as tot_jumlah_bulan_akhir, 
            ($tot_jumlah_tahun_awal) as tot_jumlah_tahun_awal, 
            ($tot_jumlah_tahun_akhir) as tot_jumlah_tahun_akhir, 
            COALESCE(FORMAT((((CAST($tot_jumlah_bulan_akhir as SIGNED) - CAST($tot_jumlah_bulan_awal as SIGNED)) / CAST($tot_jumlah_bulan_awal as SIGNED)) * 100),2),0) as m_on_m, 
            COALESCE(FORMAT((((CAST($tot_jumlah_tahun_akhir as SIGNED) - CAST($tot_jumlah_tahun_awal as SIGNED)) / CAST($tot_jumlah_tahun_awal as SIGNED)) * 100),2),0) as y_on_y");

            $this->db->from('negara as p');
            $this->db->order_by('tot_jumlah_tahun_akhir', 'desc');

            if ($data['aksi'] == 'lainnya') {
                $this->db->limit($jml, 10);
            } else {
                $this->db->limit(10);
            }

            return $this->db->get();
        }

    // Akhir 27-02-2020

}

/* End of file M_presentase.php */
