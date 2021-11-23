<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hotel extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_hotel');
    }

    // 20-02-2020

    public function index()
    {
        if (!empty($this->userdata)) {
            $data['userdata']   = $this->userdata;
            $data['Menu']       = "Rekap";
            $data['Page']       = "Rekap Hotel";
            $data['provinsi']   = $this->M_hotel->get_provinsi();
            $data['hotel']      = $this->M_hotel->get_hotel_list();

            $id_kota = $this->userdata->id_kota;

            if ($id_kota != 0) {
        
                redirect("Rekap/Hotel/tampil_detail_rekap_hotel_kota/$id_kota",'refresh');
                
            } else {
                $this->template->views('V_hotel', $data);
            }

        }
    }

    // menampilkan list kota rekap hotel 
    public function tampil_rekap_hotel_kota()
    {
        $bln_awal   = $this->input->post('bln_awal');
        $bln_akhir  = $this->input->post('bln_akhir');
        
        $list = $this->M_hotel->get_data_rekap_hotel_kota($bln_awal, $bln_akhir);

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = $o['nama_kota'];
            $tbody[]    = $o['tot_hotel'];
            $tbody[]    = ($o['tot_jml_wisnus_hotel'] == '') ? 0 : $o['tot_jml_wisnus_hotel'];
            $tbody[]    = ($o['tot_jml_wisman_hotel'] == '') ? 0 : $o['tot_jml_wisman_hotel'];;
            $tbody[]    = ($o['jumlah'] == '') ? 0 : $o['jumlah'];
            $tbody[]    = "<div align='center'><button type='button' class='btn btn-sm btn-rose mr-3 detail-rekap' data-id='".$o['id_kota']."'>Detail</button></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_hotel->jumlah_semua_rekap_hotel_kota($bln_awal, $bln_akhir),
                    "recordsFiltered"  => $this->M_hotel->jumlah_filter_rekap_hotel_kota($bln_awal, $bln_akhir),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // menampilkan halaman detail rekap kota 
    public function tampil_detail_rekap_hotel_kota($id_kota, $bln_awal = 0, $bln_akhir = 0)
    {
        $cari = $this->M_hotel->cari_data('kota', array('id_kota' => $id_kota))->row_array();

        $data = ['userdata'     => $this->userdata,
                 'Menu'         => "Rekap",
                 'Page'         => "Rekap Hotel",
                 'nama_kota'    => strtolower($cari['nama_kota']),
                 'id_sess_kota' => $this->userdata->id_kota,
                 'id_kota'      => $id_kota,
                 'bln_awal'     => $bln_awal,
                 'bln_akhir'    => $bln_akhir
                ];

        $this->template->views('V_detail_rekap_hotel_kota', $data);
        
    }

    // menampilkan list hotel
    public function tampil_list_hotel()
    {
        $dt = [ 'id_kota'   => $this->input->post('id_kota'),
                'bln_awal'  => $this->input->post('bln_awal'),
                'bln_akhir' => $this->input->post('bln_akhir')
              ];

        $list = $this->M_hotel->get_data_rekap_hotel($dt);

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = $o['nama_hotel'];
            $tbody[]    = ($o['tot_jml_wisnus_hotel'] == '') ? 0 : $o['tot_jml_wisnus_hotel'];
            $tbody[]    = ($o['tot_jml_wisman_hotel'] == '') ? 0 : $o['tot_jml_wisman_hotel'];;
            $tbody[]    = ($o['jumlah'] == '') ? 0 : $o['jumlah'];
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_hotel->jumlah_semua_rekap_hotel($dt),
                    "recordsFiltered"  => $this->M_hotel->jumlah_filter_rekap_hotel($dt),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // menampilkan lihat detail - perbaikan 21-02-2020
    public function tampil_lihat_detail($kondisi = 'lihat')
    {
        $bln_awal       = $this->input->post('bln_awal');
        $bln_akhir      = $this->input->post('bln_akhir');
        $id_kota        = $this->input->post('id_kota');
        $jns_wisatawan  = $this->input->post('jenis_wisatawan');
        
        $bulan_awal		= nice_date($bln_awal, 'Y-m');
        $bulan_akhir 	= nice_date($bln_akhir, 'Y-m');

        $from   = $bulan_awal."-01";
        $from   = date('Y-m-d', strtotime("-1 day", strtotime($from)));
        $to     = $bulan_akhir."-01";

        $ar = array();
        $i=1;
        while (strtotime($from)<strtotime($to)){
            $from = mktime(0,0,0,date('m',strtotime($from)),date("d",strtotime($from))+1,date("Y",strtotime($from)));
            $from=date("Y-m-d", $from);
            array_push($ar, nice_date($from, 'Y-m'));

            $i++;
        }

        $bulan = array_unique($ar);

        $nm_kota = $this->M_hotel->cari_data('kota', array('id_kota' => $id_kota))->row_array();

        $data = ['bulan'        => $bulan,
                 'bln_awal'     => $bln_awal,
                 'bln_akhir'    => $bln_akhir,
                 'jenis_w'      => $jns_wisatawan,
                 'id_kota'      => $id_kota,
                 'kondisi'      => $kondisi,
                 'nama_kota'    => strtolower($nm_kota['nama_kota']),
                 'hotel'        => $this->M_hotel->cari_data_order('hotel', array('id_kota' => $id_kota), 'nama_hotel', 'asc')->result_array(),
                 'jenis_report' => $jns_wisatawan
                ];

        if ($kondisi == 'lihat') {
            $this->load->view('V_lihat_detail_hotel', $data);
        } else {
            $this->template->excel("V_lihat_detail_hotel", $data);
        }
        
    }
    
    // Akhir 20-02-2020

    // 21-02-2020

    // menampilkan lihat detail all
    public function tampil_lihat_detail_all($jenis, $kondisi = 'lihat', $bln_awal = 0, $bln_akhir = 0)
    {

        if ($kondisi == 'unduh') {
            $bln_awal       = $this->input->post('bln_awal');
            $bln_akhir      = $this->input->post('bln_akhir');
            $jenis          = $this->input->post('jenis_report');
        }

        $bulan_awal		= nice_date($bln_awal, 'Y-m');
        $bulan_akhir 	= nice_date($bln_akhir, 'Y-m');

        $from   = $bulan_awal."-01";
        $from   = date('Y-m-d', strtotime("-1 day", strtotime($from)));
        $to     = $bulan_akhir."-01";

        $ar = array();
        $i=1;
        while (strtotime($from)<strtotime($to)){
            $from = mktime(0,0,0,date('m',strtotime($from)),date("d",strtotime($from))+1,date("Y",strtotime($from)));
            $from=date("Y-m-d", $from);
            array_push($ar, nice_date($from, 'Y-m'));

            $i++;
        }

        $bulan = array_unique($ar);

        if ($jenis == 'wisnus') {
            $jenis2 = 'rekap_wisnus_hotel';
        } else {
            $jenis2 = 'rekap_wisman_hotel';
        }

        $data = ['bulan'        => $bulan,
                 'bln_awal'     => $bln_awal,
                 'bln_akhir'    => $bln_akhir,
                 'kondisi'      => $kondisi,
                 'jenis_report' => $jenis2,
                 'jenis'        => $jenis,
                 'kota'         => $this->M_hotel->cari_data('kota', array('id_provinsi' => 35))->result_array()
                ];

        if ($kondisi == 'lihat') {
            $this->load->view("V_lihat_detail_all_hotel", $data);
        } else {
            $this->template->excel("V_lihat_detail_all_hotel", $data);
        }
        
    }

    // Akhir 21-02-2020

    // A F I F //

    public function rekap_hotel()
    {
        $id_hotel = $this->userdata->id_hotel;

        $nm_hotel = $this->M_hotel->cari_data('hotel', array('id_hotel' => $id_hotel))->row_array();

        $data = [ 'userdata'    => $this->userdata,
                  'Menu'        => "Rekap_hotel",
                  'Page'        => "",
                  'provinsi'    => $this->M_hotel->get_provinsi(),
                  'hotel'       => $this->M_hotel->get_hotel_list(),
                  'id_hotel'    => $id_hotel,
                  'nama_hotel'  => $nm_hotel['nama_hotel']
                ];

        $this->template->views('V_hotel_ad', $data);
    }

    public function get_wisnus_p_hotel()
    {
        $id_hotel   = $this->input->post('id');
        $periode    = nice_date($this->input->post('periode'), 'Y-m');

        if ($periode == '') {
            $periode    = 'awal';
        } else {
            $periode    = $this->input->post('periode');
        }

        // mencari total jumlah pengunjung
        $jml_ws = $this->M_hotel->cari_tot_jumlah('rekap_wisnus_hotel', $id_hotel, $periode)->row_array();
        $jml_wn = $this->M_hotel->cari_tot_jumlah('rekap_wisman_hotel', $id_hotel, $periode)->row_array();

        $js = $jml_ws['tot_jumlah'];
        $jn = $jml_wn['tot_jumlah'];

        $data = ['wisnus'       => $this->M_hotel->data_rekap_wisnus_p($id_hotel, $periode),
                 'asia'         => $this->M_hotel->data_wisman_p('ASIA', $id_hotel, $periode),
                 'afrika'       => $this->M_hotel->data_wisman_p('AFRIKA', $id_hotel, $periode),
                 'amerika'      => $this->M_hotel->data_wisman_p('AMERIKA', $id_hotel, $periode),
                 'australia'    => $this->M_hotel->data_wisman_p('AUSTRALIA', $id_hotel, $periode),
                 'eropa'        => $this->M_hotel->data_wisman_p('EROPA', $id_hotel, $periode),
                 'jml_ws'       => $js,
                 'jml_wn'       => $jn,
                 'periode'      => nice_date($periode, 'F-Y')
                ];

        echo json_encode($data);  
    }


    // AKHIR //

    // mengambil data awal rekap data
    public function json_all()
    {
        $id_hotel     = $this->userdata->id_hotel;
        $id_hotel   = $this->userdata->id_hotel;
        $id_kota    = $this->userdata->id_kota;
        $id_petugas = $this->userdata->id_pegawai;

        if ($id_petugas != 0) {
            $data = $this->M_hotel->get_hotel_petugas($id_petugas);
        } elseif ($id_kota != 0) {
            $data = $this->M_hotel->get_hotel_kota($id_kota);
        } elseif ($id_petugas == 0 && $id_hotel == 0 && $id_hotel == 0 && $id_kota == 0) {
            $data = $this->M_hotel->get_hotel_prov();
        } 

        echo json_encode($data);
    }

    public function json_prov()
    {
        $data = $this->M_hotel->get_hotel_prov();
        echo json_encode($data);
    }

    public function json()
    {
        $id_kota = $this->input->get('id');
        $data = $this->M_hotel->get_hotel($id_kota);
        echo json_encode($data);
    }

    public function json_hotel()
    {
        $id_hotel = $this->input->get('id');
        $data = $this->M_hotel->get_by_hotel($id_hotel);
        echo json_encode($data);
    }

    public function json_pegawai()
    {
        $id_petugas = $this->input->get('id');
        $data = $this->M_hotel->get_by_petugas($id_petugas);
        echo json_encode($data);
    }

    public function get_wisnus()
    {   
        $id = $this->input->post('id');
        $data['asia'] = $this->M_hotel->asia($id);
        $data['afrika'] = $this->M_hotel->afrika($id);
        $data['amerika'] = $this->M_hotel->amerika($id);
        $data['australia'] = $this->M_hotel->australia($id);
        $data['eropa'] = $this->M_hotel->eropa($id);
        $data['wisnus'] = $this->M_hotel->get_wisnus_rekap_hotel($id);
        echo json_encode($data);
    }

    public function fil_periode()
    {
        $per = $this->input->post('per');
        $id = $this->input->post('id_hotel');
        $data['asia'] = $this->M_hotel->asia2($id,$per);
        $data['afrika'] = $this->M_hotel->afrika2($id,$per);
        $data['amerika'] = $this->M_hotel->amerika2($id,$per);
        $data['australia'] = $this->M_hotel->australia2($id,$per);
        $data['eropa'] = $this->M_hotel->eropa2($id,$per);
        $data['wisnus'] = $this->M_hotel->get_wisnus_rekap_hotel2($id,$per);
        echo json_encode($data);
    }
    
    
}
