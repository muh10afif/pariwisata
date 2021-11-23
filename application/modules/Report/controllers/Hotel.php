<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Hotel extends MY_Controller {

    // 24-02-2020

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_hotel'));
        $this->cek_login_lib->belum_login();
    }

    public function index()
    {
        $data = ['userdata' => $this->userdata,
                 'Menu'     => "Report",
                 'Page'     => "Report Detail Hotel"
                ];
        
        $id_kota = $this->userdata->id_kota;

        if ($id_kota) {
            $this->template->views('V_hotel_kota', $data);
        } else {
            $this->template->views('V_hotel', $data);
        }
    }

    // level provinsi

    // menampilkan list kota
    public function tampil_kota()
    {
        $list = $this->M_hotel->get_data_hotel();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $id_kota = $o['id_kota'];

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = $o['nama_kota'];
            $tbody[]    = ($o['tot_jml_wisnus_hotel'] == '') ? 0 : $o['tot_jml_wisnus_hotel'];
            $tbody[]    = ($o['tot_jml_wisman_hotel'] == '') ? 0 : $o['tot_jml_wisman_hotel'];
            $tbody[]    = ($o['jumlah'] == '') ? 0 : $o['jumlah'];
            $tbody[]    = "<div align='center'><button type='button' class='btn btn-sm btn-success mr-3 det' data-id='".$id_kota."'>Lihat</button></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_hotel->jumlah_semua_hotel(),
                    "recordsFiltered"  => $this->M_hotel->jumlah_filter_hotel(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // menampilkan jumlah pria wanita, provinsi dan negara
    public function get_detail_kota_hotel()
    {
        $id_kota    = $this->input->post('id');
        $periode    = $this->input->post('periode');

        if ($periode == '') {
            $periode    = 'awal';
        } else {
            $periode    = $this->input->post('periode');
        }

        $cari = $this->M_hotel->cari_data('kota', array('id_kota' => $id_kota))->row_array();

        $nm     = strtolower($cari['nama_kota']);
        $nama   = ucwords($nm);

        // mencari total jumlah pengunjung
        $jml_ws = $this->M_hotel->cari_tot_jumlah('rekap_wisnus_hotel', $id_kota, $periode)->row_array();
        $jml_wn = $this->M_hotel->cari_tot_jumlah('rekap_wisman_hotel', $id_kota, $periode)->row_array();

        $js = $jml_ws['tot_jumlah'];
        $jn = $jml_wn['tot_jumlah'];
        
        $data = ['wisnus'       => $this->M_hotel->data_rekap_wisnus_p($id_kota, $periode),
                 'asia'         => $this->M_hotel->data_wisman_p('ASIA', $id_kota, $periode),
                 'afrika'       => $this->M_hotel->data_wisman_p('AFRIKA', $id_kota, $periode),
                 'amerika'      => $this->M_hotel->data_wisman_p('AMERIKA', $id_kota, $periode),
                 'australia'    => $this->M_hotel->data_wisman_p('AUSTRALIA', $id_kota, $periode),
                 'eropa'        => $this->M_hotel->data_wisman_p('EROPA', $id_kota, $periode),
                 'jml_ws'       => $js,
                 'jml_wn'       => $jn,
                 'nama_kota'    => $nama
                ];

        echo json_encode($data);  
    }

    // Akhir level provinsi

    // level kota 

    // menampilkan hotel
    public function tampil_hotel()
    {
        $id_kota = $this->userdata->id_kota;

        $list = $this->M_hotel->get_data_hotel_kota($id_kota);

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $id_hotel = $o['id_hotel'];

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = $o['nama_hotel'];
            $tbody[]    = ($o['tot_jml_wisnus_hotel'] == '') ? 0 : $o['tot_jml_wisnus_hotel'];
            $tbody[]    = ($o['tot_jml_wisman_hotel'] == '') ? 0 : $o['tot_jml_wisman_hotel'];
            $tbody[]    = ($o['jumlah'] == '') ? 0 : $o['jumlah'];
            $tbody[]    = "<div align='center'><button type='button' class='btn btn-sm btn-success mr-3 det' data-id='".$id_hotel."'>Lihat</button></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_hotel->jumlah_semua_hotel_kota($id_kota),
                    "recordsFiltered"  => $this->M_hotel->jumlah_filter_hotel_kota($id_kota),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // menampilkan jumlah pria wanita, provinsi dan negara
    public function get_detail_jml_hotel()
    {
        $id_hotel   = $this->input->post('id');
        $periode    = $this->input->post('periode');

        if ($periode == '') {
            $periode    = 'awal';
        } else {
            $periode    = $this->input->post('periode');
        }

        $cari = $this->M_hotel->cari_data('hotel', array('id_hotel' => $id_hotel))->row_array();

        $nm     = strtolower($cari['nama_hotel']);
        $nama   = ucwords($nm);

        // mencari total jumlah pengunjung
        $jml_ws = $this->M_hotel->cari_tot_jumlah_hotel('rekap_wisnus_hotel', $id_hotel, $periode)->row_array();
        $jml_wn = $this->M_hotel->cari_tot_jumlah_hotel('rekap_wisman_hotel', $id_hotel, $periode)->row_array();

        $js = $jml_ws['tot_jumlah'];
        $jn = $jml_wn['tot_jumlah'];
        
        $data = ['wisnus'       => $this->M_hotel->data_rekap_wisnus_p_hotel($id_hotel, $periode),
                 'asia'         => $this->M_hotel->data_wisman_p_hotel('ASIA', $id_hotel, $periode),
                 'afrika'       => $this->M_hotel->data_wisman_p_hotel('AFRIKA', $id_hotel, $periode),
                 'amerika'      => $this->M_hotel->data_wisman_p_hotel('AMERIKA', $id_hotel, $periode),
                 'australia'    => $this->M_hotel->data_wisman_p_hotel('AUSTRALIA', $id_hotel, $periode),
                 'eropa'        => $this->M_hotel->data_wisman_p_hotel('EROPA', $id_hotel, $periode),
                 'jml_ws'       => $js,
                 'jml_wn'       => $jn,
                 'nama_hotel'   => $nama
                ];

        echo json_encode($data);  
    }

    // Akhir level kota

    // Akhir 24-02-2020

}

/* End of file Hotel.php */
