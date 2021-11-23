<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Dtw extends MY_Controller {

    // 24-02-2020
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_dtw'));
        $this->cek_login_lib->belum_login();
    }

    // level provinsi

    public function index()
    {
        $data = ['userdata' => $this->userdata,
                 'Menu'     => "Report",
                 'Page'     => "Report Detail DTW"
                ];

        $id_kota = $this->userdata->id_kota;

        if ($id_kota) {
            $this->template->views('V_dtw_kota', $data);
        } else {
            $this->template->views('V_dtw', $data);
        }
        
    }

    // menampilkan list kota
    public function tampil_kota()
    {
        $list = $this->M_dtw->get_data_dtw();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $id_kota = $o['id_kota'];

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = $o['nama_kota'];
            $tbody[]    = ($o['tot_jml_wisnus_dtw'] == '') ? 0 : $o['tot_jml_wisnus_dtw'];
            $tbody[]    = ($o['tot_jml_wisman_dtw'] == '') ? 0 : $o['tot_jml_wisman_dtw'];
            $tbody[]    = ($o['jumlah'] == '') ? 0 : $o['jumlah'];
            $tbody[]    = "<div align='center'><button type='button' class='btn btn-sm btn-success mr-3 det' data-id='".$id_kota."'>Lihat</button></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_dtw->jumlah_semua_dtw(),
                    "recordsFiltered"  => $this->M_dtw->jumlah_filter_dtw(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // menampilkan jumlah pria wanita, provinsi dan negara
    public function get_detail_kota_dtw()
    {
        $id_kota    = $this->input->post('id');
        $periode    = $this->input->post('periode');

        if ($periode == '') {
            $periode    = 'awal';
        } else {
            $periode    = $this->input->post('periode');
        }

        $cari = $this->M_dtw->cari_data('kota', array('id_kota' => $id_kota))->row_array();

        $nm     = strtolower($cari['nama_kota']);
        $nama   = ucwords($nm);

        // mencari total jumlah pengunjung
        $jml_ws = $this->M_dtw->cari_tot_jumlah('rekap_wisnus_dtw', $id_kota, $periode)->row_array();
        $jml_wn = $this->M_dtw->cari_tot_jumlah('rekap_wisman_dtw', $id_kota, $periode)->row_array();

        $js = $jml_ws['tot_jumlah'];
        $jn = $jml_wn['tot_jumlah'];
        
        $data = ['wisnus'       => $this->M_dtw->data_rekap_wisnus_p($id_kota, $periode),
                 'asia'         => $this->M_dtw->data_wisman_p('ASIA', $id_kota, $periode),
                 'afrika'       => $this->M_dtw->data_wisman_p('AFRIKA', $id_kota, $periode),
                 'amerika'      => $this->M_dtw->data_wisman_p('AMERIKA', $id_kota, $periode),
                 'australia'    => $this->M_dtw->data_wisman_p('AUSTRALIA', $id_kota, $periode),
                 'eropa'        => $this->M_dtw->data_wisman_p('EROPA', $id_kota, $periode),
                 'jml_ws'       => $js,
                 'jml_wn'       => $jn,
                 'nama_kota'    => $nama
                ];

        echo json_encode($data);  
    }

    // Akhir level provinsi

    // level kota 

    // menampilkan dtw
    public function tampil_dtw()
    {
        $id_kota = $this->userdata->id_kota;

        $list = $this->M_dtw->get_data_dtw_kota($id_kota);

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $id_dtw = $o['id_dtw'];

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = $o['nama_dtw'];
            $tbody[]    = ($o['tot_jml_wisnus_dtw'] == '') ? 0 : $o['tot_jml_wisnus_dtw'];
            $tbody[]    = ($o['tot_jml_wisman_dtw'] == '') ? 0 : $o['tot_jml_wisman_dtw'];
            $tbody[]    = ($o['jumlah'] == '') ? 0 : $o['jumlah'];
            $tbody[]    = "<div align='center'><button type='button' class='btn btn-sm btn-success mr-3 det' data-id='".$id_dtw."'>Lihat</button></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_dtw->jumlah_semua_dtw_kota($id_kota),
                    "recordsFiltered"  => $this->M_dtw->jumlah_filter_dtw_kota($id_kota),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // menampilkan jumlah pria wanita, provinsi dan negara
    public function get_detail_jml_dtw()
    {
        $id_dtw     = $this->input->post('id');
        $periode    = $this->input->post('periode');

        if ($periode == '') {
            $periode    = 'awal';
        } else {
            $periode    = $this->input->post('periode');
        }

        $cari = $this->M_dtw->cari_data('dtw', array('id_dtw' => $id_dtw))->row_array();

        $nm     = strtolower($cari['nama_dtw']);
        $nama   = ucwords($nm);

        // mencari total jumlah pengunjung
        $jml_ws = $this->M_dtw->cari_tot_jumlah_dtw('rekap_wisnus_dtw', $id_dtw, $periode)->row_array();
        $jml_wn = $this->M_dtw->cari_tot_jumlah_dtw('rekap_wisman_dtw', $id_dtw, $periode)->row_array();

        $js = $jml_ws['tot_jumlah'];
        $jn = $jml_wn['tot_jumlah'];
        
        $data = ['wisnus'       => $this->M_dtw->data_rekap_wisnus_p_dtw($id_dtw, $periode),
                 'asia'         => $this->M_dtw->data_wisman_p_dtw('ASIA', $id_dtw, $periode),
                 'afrika'       => $this->M_dtw->data_wisman_p_dtw('AFRIKA', $id_dtw, $periode),
                 'amerika'      => $this->M_dtw->data_wisman_p_dtw('AMERIKA', $id_dtw, $periode),
                 'australia'    => $this->M_dtw->data_wisman_p_dtw('AUSTRALIA', $id_dtw, $periode),
                 'eropa'        => $this->M_dtw->data_wisman_p_dtw('EROPA', $id_dtw, $periode),
                 'jml_ws'       => $js,
                 'jml_wn'       => $jn,
                 'nama_dtw'     => $nama
                ];

        echo json_encode($data);  
    }

    // Akhir level kota

    // Akhir 24-02-2020

}

/* End of file Dtw.php */
