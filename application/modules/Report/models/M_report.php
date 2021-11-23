<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_report extends CI_Model {

    public function get_data_dtw($id_kota)
    {
        $this->db->select('k.id_kota, d.nama_dtw, d.id_dtw, d.*, k.*');
        $this->db->from('dtw as d');
        $this->db->join('kota as k', 'k.id_kota = d.id_kota', 'inner');
        $this->db->order_by('k.nama_kota', 'asc');
        if ($id_kota != 0) {
            $this->db->where('k.id_kota', $id_kota);
        }
        
        return $this->db->get();
           
    }

    public function get_tot_dtw_wisnus_wisman($aksi, $periode, $id_dtw, $id_kota)
    {

        if ($aksi == 'wisnus') {
            $tabel = 'rekap_wisnus_dtw';
        } else {
            $tabel = 'rekap_wisman_dtw';
        }

        $this->db->select('sum(jumlah_pengunjung) as tot_jml_pengunjung');
        $this->db->from("$tabel as r");
        $this->db->join('dtw as d', 'd.id_dtw = r.id_dtw', 'inner');
        $this->db->where('r.status', 1);
        
        if ($id_dtw != 0) {
            $this->db->where('r.id_dtw', $id_dtw);
        }
        if ($id_kota != 0) {
            $this->db->where('d.id_kota', $id_kota);
            
        }
        $this->db->where('periode', $periode);
        
        return $this->db->get();
        
    }

    public function get_data_hotel($id_kota)
    {
        $this->db->select('*');
        $this->db->from('hotel as h');
        $this->db->join('kota as k', 'k.id_kota = h.id_kota', 'inner');
        $this->db->order_by('h.nama_hotel', 'asc');
        if ($id_kota != 0) {
            $this->db->where('k.id_kota', $id_kota);
        }
        
        return $this->db->get();
        
    }

    public function get_tot_hotel_wisnus_wisman($aksi, $periode, $id_hotel, $id_kota)
    {

        if ($aksi == 'wisnus') {
            $tabel = 'rekap_wisnus_hotel';
        } else {
            $tabel = 'rekap_wisman_hotel';
        }

        $this->db->select('sum(jumlah_pengunjung) as tot_jml_pengunjung');
        $this->db->from("$tabel as r");
        $this->db->join('hotel as d', 'd.id_hotel = r.id_hotel', 'inner');
        $this->db->where('r.status', 1);
        
        if ($id_hotel != 0) {
            $this->db->where('r.id_hotel', $id_hotel);
        }
        if ($id_kota != 0) {
            $this->db->where('d.id_kota', $id_kota);
        }
        $this->db->where('periode', $periode);
        
        return $this->db->get();
        
    }

    // 28-02-2020

        // menampilkan data dtw
        public function data_dtw_wisnus_unduh_db($bulan)
        {
            $this->db->select("p.id_provinsi, p.nama_provinsi, d.id_dtw, d.nama_dtw, d.alamat, k.nama_kota, '$bulan' as bulan, 'WISNUS' as kategori_wisatawan,COALESCE((SELECT sum(rd.pengunjung_pria) as tot_pria FROM rekap_wisnus_dtw as rd WHERE rd.id_provinsi = ran.id_provinsi and rd.id_dtw = d.id_dtw and DATE_FORMAT(STR_TO_DATE(rd.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan'),0) as tot_pria, COALESCE((SELECT sum(rd.pengunjung_wanita) as tot_wanita FROM rekap_wisnus_dtw as rd WHERE rd.id_provinsi = ran.id_provinsi and rd.id_dtw = d.id_dtw and DATE_FORMAT(STR_TO_DATE(rd.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan'),0) as tot_wanita, COALESCE((SELECT sum(rd.jumlah_pengunjung) as jumlah FROM rekap_wisnus_dtw as rd WHERE rd.id_provinsi = ran.id_provinsi and rd.id_dtw = d.id_dtw and DATE_FORMAT(STR_TO_DATE(rd.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan'),0) as jumlah");
            $this->db->from('provinsi as p');
            $this->db->join('rekap_wisnus_dtw as ran', 'ran.id_provinsi = p.id_provinsi', 'inner');
            $this->db->join('dtw as d', 'd.id_dtw = ran.id_dtw', 'inner');
            $this->db->join('kota as k', 'k.id_kota = d.id_kota', 'inner');
            $this->db->where('k.id_provinsi', 35);

            $id_kota = $this->session->userdata('userdata')->id_kota;

            $lvl = $this->session->userdata('level');

            if ($lvl == 'kota') {
                $this->db->where('k.id_kota', $id_kota);
            }
            
            $this->db->where('ran.status', 1);

            $this->db->group_by('p.id_provinsi');
            $this->db->group_by('p.nama_provinsi');
            $this->db->group_by('d.id_dtw');
            $this->db->group_by('d.nama_dtw');
            $this->db->group_by('d.alamat');
            $this->db->group_by('k.nama_kota');
            $this->db->order_by('p.nama_provinsi', 'asc');

            return $this->db->get();
            
        }

        // menampilkan data dtw wisman
        public function data_dtw_wisman_unduh_db($bulan)
        {
            $this->db->select("p.id_negara, p.nama_negara, d.id_dtw, d.nama_dtw, d.alamat, k.nama_kota, '$bulan' as bulan, 'WISMAN' as kategori_wisatawan,COALESCE((SELECT sum(rd.pengunjung_pria) as tot_pria FROM rekap_wisman_dtw as rd WHERE rd.id_negara = ran.id_negara and rd.id_dtw = d.id_dtw and DATE_FORMAT(STR_TO_DATE(rd.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan'),0) as tot_pria, COALESCE((SELECT sum(rd.pengunjung_wanita) as tot_wanita FROM rekap_wisman_dtw as rd WHERE rd.id_negara = ran.id_negara and rd.id_dtw = d.id_dtw and DATE_FORMAT(STR_TO_DATE(rd.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan'),0) as tot_wanita, COALESCE((SELECT sum(rd.jumlah_pengunjung) as jumlah FROM rekap_wisman_dtw as rd WHERE rd.id_negara = ran.id_negara and rd.id_dtw = d.id_dtw and DATE_FORMAT(STR_TO_DATE(rd.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan'),0) as jumlah");
            $this->db->from('negara as p');
            $this->db->join('rekap_wisman_dtw as ran', 'ran.id_negara = p.id_negara', 'inner');
            $this->db->join('dtw as d', 'd.id_dtw = ran.id_dtw', 'inner');
            $this->db->join('kota as k', 'k.id_kota = d.id_kota', 'inner');
            $this->db->where('k.id_provinsi', 35);

            $id_kota = $this->session->userdata('userdata')->id_kota;

            $lvl = $this->session->userdata('level');

            if ($lvl == 'kota') {
                $this->db->where('k.id_kota', $id_kota);
            }
            
            $this->db->where('ran.status', 1);

            $this->db->group_by('p.id_negara');
            $this->db->group_by('p.nama_negara');
            $this->db->group_by('d.id_dtw');
            $this->db->group_by('d.nama_dtw');
            $this->db->group_by('d.alamat');
            $this->db->group_by('k.nama_kota');
            $this->db->order_by('p.nama_negara', 'asc');

            return $this->db->get();
            
        }

        // menampilkan data hotel
        public function data_hotel_wisnus_unduh_db($bulan)
        {
            $this->db->select("p.id_provinsi, p.nama_provinsi, d.id_hotel, d.nama_hotel, d.alamat, k.nama_kota, '$bulan' as bulan, 'WISNUS' as kategori_wisatawan,COALESCE((SELECT sum(rd.pengunjung_pria) as tot_pria FROM rekap_wisnus_hotel as rd WHERE rd.id_provinsi = ran.id_provinsi and rd.id_hotel = d.id_hotel and DATE_FORMAT(STR_TO_DATE(rd.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan'),0) as tot_pria, COALESCE((SELECT sum(rd.pengunjung_wanita) as tot_wanita FROM rekap_wisnus_hotel as rd WHERE rd.id_provinsi = ran.id_provinsi and rd.id_hotel = d.id_hotel and DATE_FORMAT(STR_TO_DATE(rd.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan'),0) as tot_wanita, COALESCE((SELECT sum(rd.jumlah_pengunjung) as jumlah FROM rekap_wisnus_hotel as rd WHERE rd.id_provinsi = ran.id_provinsi and rd.id_hotel = d.id_hotel and DATE_FORMAT(STR_TO_DATE(rd.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan'),0) as jumlah");
            $this->db->from('provinsi as p');
            $this->db->join('rekap_wisnus_hotel as ran', 'ran.id_provinsi = p.id_provinsi', 'inner');
            $this->db->join('hotel as d', 'd.id_hotel = ran.id_hotel', 'inner');
            $this->db->join('kota as k', 'k.id_kota = d.id_kota', 'inner');
            $this->db->where('k.id_provinsi', 35);

            $id_kota = $this->session->userdata('userdata')->id_kota;

            $lvl = $this->session->userdata('level');

            if ($lvl == 'kota') {
                $this->db->where('k.id_kota', $id_kota);
            }

            $this->db->where('ran.status', 1);

            $this->db->group_by('p.id_provinsi');
            $this->db->group_by('p.nama_provinsi');
            $this->db->group_by('d.id_hotel');
            $this->db->group_by('d.nama_hotel');
            $this->db->group_by('d.alamat');
            $this->db->group_by('k.nama_kota');
            $this->db->order_by('p.nama_provinsi', 'asc');

            return $this->db->get();
            
        }

        // menampilkan data hotel wisman
        public function data_hotel_wisman_unduh_db($bulan)
        {
            $this->db->select("p.id_negara, p.nama_negara, d.id_hotel, d.nama_hotel, d.alamat, k.nama_kota, '$bulan' as bulan, 'WISMAN' as kategori_wisatawan,COALESCE((SELECT sum(rd.pengunjung_pria) as tot_pria FROM rekap_wisman_hotel as rd WHERE rd.id_negara = ran.id_negara and rd.id_hotel = d.id_hotel and DATE_FORMAT(STR_TO_DATE(rd.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan'),0) as tot_pria, COALESCE((SELECT sum(rd.pengunjung_wanita) as tot_wanita FROM rekap_wisman_hotel as rd WHERE rd.id_negara = ran.id_negara and rd.id_hotel = d.id_hotel and DATE_FORMAT(STR_TO_DATE(rd.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan'),0) as tot_wanita, COALESCE((SELECT sum(rd.jumlah_pengunjung) as jumlah FROM rekap_wisman_hotel as rd WHERE rd.id_negara = ran.id_negara and rd.id_hotel = d.id_hotel and DATE_FORMAT(STR_TO_DATE(rd.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan'),0) as jumlah");
            $this->db->from('negara as p');
            $this->db->join('rekap_wisman_hotel as ran', 'ran.id_negara = p.id_negara', 'inner');
            $this->db->join('hotel as d', 'd.id_hotel = ran.id_hotel', 'inner');
            $this->db->join('kota as k', 'k.id_kota = d.id_kota', 'inner');
            $this->db->where('k.id_provinsi', 35);

            $id_kota = $this->session->userdata('userdata')->id_kota;

            $lvl = $this->session->userdata('level');

            if ($lvl == 'kota') {
                $this->db->where('k.id_kota', $id_kota);
            }

            $this->db->where('ran.status', 1);

            $this->db->group_by('p.id_negara');
            $this->db->group_by('p.nama_negara');
            $this->db->group_by('d.id_hotel');
            $this->db->group_by('d.nama_hotel');
            $this->db->group_by('d.alamat');
            $this->db->group_by('k.nama_kota');
            $this->db->order_by('p.nama_negara', 'asc');

            return $this->db->get();
            
        }

    // Akhir 28-02-2020

    // 03-02-2020

        // menampilkan data dtw
        public function data_dtw_wisnus_unduh_detail($bulan, $id_kota)
        {
            if ($bulan == '') {
                $this->db->select("p.id_provinsi, p.nama_provinsi, d.id_dtw, d.nama_dtw, d.alamat, k.nama_kota, DATE_FORMAT(STR_TO_DATE(ran.periode,'%d-%M-%Y'), '%Y-%m') as bulan, 'WISNUS' as kategori_wisatawan,COALESCE((SELECT sum(rd.pengunjung_pria) as tot_pria FROM rekap_wisnus_dtw as rd WHERE rd.id_provinsi = ran.id_provinsi and rd.id_dtw = d.id_dtw),0) as tot_pria, COALESCE((SELECT sum(rd.pengunjung_wanita) as tot_wanita FROM rekap_wisnus_dtw as rd WHERE rd.id_provinsi = ran.id_provinsi and rd.id_dtw = d.id_dtw),0) as tot_wanita, COALESCE((SELECT sum(rd.jumlah_pengunjung) as jumlah FROM rekap_wisnus_dtw as rd WHERE rd.id_provinsi = ran.id_provinsi and rd.id_dtw = d.id_dtw),0) as jumlah");
            } else {
                $this->db->select("p.id_provinsi, p.nama_provinsi, d.id_dtw, d.nama_dtw, d.alamat, k.nama_kota, '$bulan' as bulan, 'WISNUS' as kategori_wisatawan,COALESCE((SELECT sum(rd.pengunjung_pria) as tot_pria FROM rekap_wisnus_dtw as rd WHERE rd.id_provinsi = ran.id_provinsi and rd.id_dtw = d.id_dtw and DATE_FORMAT(STR_TO_DATE(rd.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan'),0) as tot_pria, COALESCE((SELECT sum(rd.pengunjung_wanita) as tot_wanita FROM rekap_wisnus_dtw as rd WHERE rd.id_provinsi = ran.id_provinsi and rd.id_dtw = d.id_dtw and DATE_FORMAT(STR_TO_DATE(rd.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan'),0) as tot_wanita, COALESCE((SELECT sum(rd.jumlah_pengunjung) as jumlah FROM rekap_wisnus_dtw as rd WHERE rd.id_provinsi = ran.id_provinsi and rd.id_dtw = d.id_dtw and DATE_FORMAT(STR_TO_DATE(rd.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan'),0) as jumlah");
            }
        
            $this->db->from('provinsi as p');
            $this->db->join('rekap_wisnus_dtw as ran', 'ran.id_provinsi = p.id_provinsi', 'inner');
            $this->db->join('dtw as d', 'd.id_dtw = ran.id_dtw', 'inner');
            $this->db->join('kota as k', 'k.id_kota = d.id_kota', 'inner');
            $this->db->where('k.id_provinsi', 35);
            $this->db->where('ran.status', 1);
            $this->db->where('k.id_kota', $id_kota);
            
            $this->db->group_by('p.id_provinsi');
            $this->db->group_by('p.nama_provinsi');
            $this->db->group_by('d.id_dtw');
            $this->db->group_by('d.nama_dtw');
            $this->db->group_by('d.alamat');
            $this->db->group_by('k.nama_kota');
            $this->db->order_by('p.nama_provinsi', 'asc');

            return $this->db->get();
            
        }

        // menampilkan data dtw wisman
        public function data_dtw_wisman_unduh_detail($bulan, $id_kota)
        {
            if ($bulan == '') {
                $this->db->select("p.id_negara, p.nama_negara, d.id_dtw, d.nama_dtw, d.alamat, k.nama_kota, DATE_FORMAT(STR_TO_DATE(ran.periode,'%d-%M-%Y'), '%Y-%m') as bulan, 'WISMAN' as kategori_wisatawan,COALESCE((SELECT sum(rd.pengunjung_pria) as tot_pria FROM rekap_wisman_dtw as rd WHERE rd.id_negara = ran.id_negara and rd.id_dtw = d.id_dtw),0) as tot_pria, COALESCE((SELECT sum(rd.pengunjung_wanita) as tot_wanita FROM rekap_wisman_dtw as rd WHERE rd.id_negara = ran.id_negara and rd.id_dtw = d.id_dtw),0) as tot_wanita, COALESCE((SELECT sum(rd.jumlah_pengunjung) as jumlah FROM rekap_wisman_dtw as rd WHERE rd.id_negara = ran.id_negara and rd.id_dtw = d.id_dtw),0) as jumlah");
            } else {
                $this->db->select("p.id_negara, p.nama_negara, d.id_dtw, d.nama_dtw, d.alamat, k.nama_kota, '$bulan' as bulan, 'WISMAN' as kategori_wisatawan,COALESCE((SELECT sum(rd.pengunjung_pria) as tot_pria FROM rekap_wisman_dtw as rd WHERE rd.id_negara = ran.id_negara and rd.id_dtw = d.id_dtw and DATE_FORMAT(STR_TO_DATE(rd.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan'),0) as tot_pria, COALESCE((SELECT sum(rd.pengunjung_wanita) as tot_wanita FROM rekap_wisman_dtw as rd WHERE rd.id_negara = ran.id_negara and rd.id_dtw = d.id_dtw and DATE_FORMAT(STR_TO_DATE(rd.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan'),0) as tot_wanita, COALESCE((SELECT sum(rd.jumlah_pengunjung) as jumlah FROM rekap_wisman_dtw as rd WHERE rd.id_negara = ran.id_negara and rd.id_dtw = d.id_dtw and DATE_FORMAT(STR_TO_DATE(rd.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan'),0) as jumlah");
            }
            
            $this->db->from('negara as p');
            $this->db->join('rekap_wisman_dtw as ran', 'ran.id_negara = p.id_negara', 'inner');
            $this->db->join('dtw as d', 'd.id_dtw = ran.id_dtw', 'inner');
            $this->db->join('kota as k', 'k.id_kota = d.id_kota', 'inner');
            $this->db->where('k.id_provinsi', 35);
            $this->db->where('ran.status', 1);
            $this->db->where('k.id_kota', $id_kota);

            $this->db->group_by('p.id_negara');
            $this->db->group_by('p.nama_negara');
            $this->db->group_by('d.id_dtw');
            $this->db->group_by('d.nama_dtw');
            $this->db->group_by('d.alamat');
            $this->db->group_by('k.nama_kota');
            $this->db->order_by('p.nama_negara', 'asc');

            return $this->db->get();
            
        }

        // menampilkan data hotel
        public function data_hotel_wisnus_unduh_detail($bulan, $id_kota)
        {
            if ($bulan == '') {
                $this->db->select("p.id_provinsi, p.nama_provinsi, d.id_hotel, d.nama_hotel, d.alamat, k.nama_kota, DATE_FORMAT(STR_TO_DATE(ran.periode,'%d-%M-%Y'), '%Y-%m') as bulan, 'WISNUS' as kategori_wisatawan,COALESCE((SELECT sum(rd.pengunjung_pria) as tot_pria FROM rekap_wisnus_hotel as rd WHERE rd.id_provinsi = ran.id_provinsi and rd.id_hotel = d.id_hotel),0) as tot_pria, COALESCE((SELECT sum(rd.pengunjung_wanita) as tot_wanita FROM rekap_wisnus_hotel as rd WHERE rd.id_provinsi = ran.id_provinsi and rd.id_hotel = d.id_hotel),0) as tot_wanita, COALESCE((SELECT sum(rd.jumlah_pengunjung) as jumlah FROM rekap_wisnus_hotel as rd WHERE rd.id_provinsi = ran.id_provinsi and rd.id_hotel = d.id_hotel),0) as jumlah");
            } else {
                $this->db->select("p.id_provinsi, p.nama_provinsi, d.id_hotel, d.nama_hotel, d.alamat, k.nama_kota, '$bulan' as bulan, 'WISNUS' as kategori_wisatawan,COALESCE((SELECT sum(rd.pengunjung_pria) as tot_pria FROM rekap_wisnus_hotel as rd WHERE rd.id_provinsi = ran.id_provinsi and rd.id_hotel = d.id_hotel and DATE_FORMAT(STR_TO_DATE(rd.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan'),0) as tot_pria, COALESCE((SELECT sum(rd.pengunjung_wanita) as tot_wanita FROM rekap_wisnus_hotel as rd WHERE rd.id_provinsi = ran.id_provinsi and rd.id_hotel = d.id_hotel and DATE_FORMAT(STR_TO_DATE(rd.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan'),0) as tot_wanita, COALESCE((SELECT sum(rd.jumlah_pengunjung) as jumlah FROM rekap_wisnus_hotel as rd WHERE rd.id_provinsi = ran.id_provinsi and rd.id_hotel = d.id_hotel and DATE_FORMAT(STR_TO_DATE(rd.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan'),0) as jumlah");
            }
            
            $this->db->from('provinsi as p');
            $this->db->join('rekap_wisnus_hotel as ran', 'ran.id_provinsi = p.id_provinsi', 'inner');
            $this->db->join('hotel as d', 'd.id_hotel = ran.id_hotel', 'inner');
            $this->db->join('kota as k', 'k.id_kota = d.id_kota', 'inner');
            $this->db->where('k.id_provinsi', 35);
            $this->db->where('ran.status', 1);
            $this->db->where('k.id_kota', $id_kota);

            $this->db->group_by('p.id_provinsi');
            $this->db->group_by('p.nama_provinsi');
            $this->db->group_by('d.id_hotel');
            $this->db->group_by('d.nama_hotel');
            $this->db->group_by('d.alamat');
            $this->db->group_by('k.nama_kota');
            $this->db->order_by('p.nama_provinsi', 'asc');

            return $this->db->get();
            
        }

        // menampilkan data hotel wisman
        public function data_hotel_wisman_unduh_detail($bulan, $id_kota)
        {
            if ($bulan == '') {
                $this->db->select("p.id_negara, p.nama_negara, d.id_hotel, d.nama_hotel, d.alamat, k.nama_kota, DATE_FORMAT(STR_TO_DATE(ran.periode,'%d-%M-%Y'), '%Y-%m') as bulan, 'WISMAN' as kategori_wisatawan,COALESCE((SELECT sum(rd.pengunjung_pria) as tot_pria FROM rekap_wisman_hotel as rd WHERE rd.id_negara = ran.id_negara and rd.id_hotel = d.id_hotel),0) as tot_pria, COALESCE((SELECT sum(rd.pengunjung_wanita) as tot_wanita FROM rekap_wisman_hotel as rd WHERE rd.id_negara = ran.id_negara and rd.id_hotel = d.id_hotel),0) as tot_wanita, COALESCE((SELECT sum(rd.jumlah_pengunjung) as jumlah FROM rekap_wisman_hotel as rd WHERE rd.id_negara = ran.id_negara and rd.id_hotel = d.id_hotel),0) as jumlah");
            } else {
                $this->db->select("p.id_negara, p.nama_negara, d.id_hotel, d.nama_hotel, d.alamat, k.nama_kota, '$bulan' as bulan, 'WISMAN' as kategori_wisatawan,COALESCE((SELECT sum(rd.pengunjung_pria) as tot_pria FROM rekap_wisman_hotel as rd WHERE rd.id_negara = ran.id_negara and rd.id_hotel = d.id_hotel and DATE_FORMAT(STR_TO_DATE(rd.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan'),0) as tot_pria, COALESCE((SELECT sum(rd.pengunjung_wanita) as tot_wanita FROM rekap_wisman_hotel as rd WHERE rd.id_negara = ran.id_negara and rd.id_hotel = d.id_hotel and DATE_FORMAT(STR_TO_DATE(rd.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan'),0) as tot_wanita, COALESCE((SELECT sum(rd.jumlah_pengunjung) as jumlah FROM rekap_wisman_hotel as rd WHERE rd.id_negara = ran.id_negara and rd.id_hotel = d.id_hotel and DATE_FORMAT(STR_TO_DATE(rd.periode,'%d-%M-%Y'), '%Y-%m') = '$bulan'),0) as jumlah");
            }
            
            $this->db->from('negara as p');
            $this->db->join('rekap_wisman_hotel as ran', 'ran.id_negara = p.id_negara', 'inner');
            $this->db->join('hotel as d', 'd.id_hotel = ran.id_hotel', 'inner');
            $this->db->join('kota as k', 'k.id_kota = d.id_kota', 'inner');
            $this->db->where('k.id_provinsi', 35);
            $this->db->where('ran.status', 1);
            $this->db->where('k.id_kota', $id_kota);

            $this->db->group_by('p.id_negara');
            $this->db->group_by('p.nama_negara');
            $this->db->group_by('d.id_hotel');
            $this->db->group_by('d.nama_hotel');
            $this->db->group_by('d.alamat');
            $this->db->group_by('k.nama_kota');
            $this->db->order_by('p.nama_negara', 'asc');

            return $this->db->get();
            
        }

    // Akhir 03-02-2020

}

/* End of file M_report.php */
