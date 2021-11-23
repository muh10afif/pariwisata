<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Dtw_hotel_kota extends MY_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_dtw_hotel'));
    }
    
    public function index()
    {
        $data = ['userdata'     => $this->userdata, 
                 'Menu'         => "Master",
                 'Page'         => "Master DTW Hotel"
                ];

        $this->template->views('V_dtw_hotel', $data);
    }

    public function tampil_data_dtw_hotel()
    {
        $list = $this->M_dtw_hotel->get_data_dtw_hotel();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $id_kota = $o['id_kota'];

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = $o['nama_kota'];
            $tbody[]    = $o['tot_dtw'];
            $tbody[]    = $o['tot_hotel'];
            $tbody[]    = "<div align='center'><a href='".base_url("master/dtw_hotel_kota/tampil_detail_kota_dtw_hotel/$id_kota")."'><button type='button' class='btn btn-sm btn-rose mr-3'>Tambah Data</button></a></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_dtw_hotel->jumlah_semua_dtw_hotel(),
                    "recordsFiltered"  => $this->M_dtw_hotel->jumlah_filter_dtw_hotel(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // menampilkan halaman detail kota dtw hotel
    public function tampil_detail_kota_dtw_hotel($id_kota)
    {
        $data = ['userdata'     => $this->userdata, 
                 'Menu'         => "Master",
                 'Page'         => "Master DTW Hotel",
                 'dtw'          => $this->M_dtw_hotel->cari_data('dtw', array('id_kota' => $id_kota))->result_array(),
                 'hotel'        => $this->M_dtw_hotel->cari_data('hotel', array('id_kota' => $id_kota))->result_array(),
                 'id_kota'      => $id_kota
                ];

        $this->template->views('V_detail_kota_dtw_hotel', $data);
    }

    public function tampil_list_dtw()
    {
        $id_kota = $this->input->post('id_kota');

        $list = $this->M_dtw_hotel->get_data_detail_dtw($id_kota);

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            if ($o['status'] == 1) {
                $st = "<span class='badge badge-success'>Aktif</span>";
            } else {
                $st = "<span class='badge badge-dark'>Tidak Aktif</span>";
            }

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = $o['nama_dtw'];
            $tbody[]    = $o['alamat'];
            $tbody[]    = $o['lat'];
            $tbody[]    = $o['long'];
            $tbody[]    = $o['email'];
            $tbody[]    = $o['no_hp'];
            $tbody[]    = "<div align='center'>".$st."</div>";
            $tbody[]    = "<button type='button' class='btn btn-sm btn-success mr-3 edit-dtw' data-id='".$o['id_dtw']."'>Edit</button><button type='button' class='btn btn-sm btn-danger hapus-dtw' data-id='".$o['id_dtw']."'>Hapus</button>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_dtw_hotel->jumlah_semua_detail_dtw($id_kota),
                    "recordsFiltered"  => $this->M_dtw_hotel->jumlah_filter_detail_dtw($id_kota),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    public function tampil_list_hotel()
    {
        $id_kota = $this->input->post('id_kota');

        $list = $this->M_dtw_hotel->get_data_detail_hotel($id_kota);

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            if ($o['status'] == 1) {
                $st = "<span class='badge badge-success'>Aktif</span>";
            } else {
                $st = "<span class='badge badge-dark'>Tidak Aktif</span>";
            }

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = $o['nama_hotel'];
            $tbody[]    = $o['alamat'];
            $tbody[]    = $o['lat'];
            $tbody[]    = $o['long'];
            $tbody[]    = $o['email'];
            $tbody[]    = $o['no_hp'];
            $tbody[]    = "<div align='center'>".$st."</div>";
            $tbody[]    = "<button type='button' class='btn btn-sm btn-success mr-3 edit-dtw' data-id='".$o['id_kota']."'>Edit</button><button type='button' class='btn btn-sm btn-danger hapus-dtw' data-id='".$o['id_kota']."'>Hapus</button>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_dtw_hotel->jumlah_semua_detail_hotel($id_kota),
                    "recordsFiltered"  => $this->M_dtw_hotel->jumlah_filter_detail_hotel($id_kota),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // menampilkan list datatables 
    public function tampil_list_dtw_hotel()
    {
        $id_kota = $this->input->post('id_kota');
        $aksi    = $this->input->post('aksi');
        
        $list = $this->M_dtw_hotel->get_data_detail_dtw_hotel($id_kota, $aksi);

        $data = array();

        $no   = $this->input->post('start');

        if ($aksi == 'dtw') {
            foreach ($list as $o) {
                $no++;
                $tbody = array();

                if ($o['status'] == 1) {
                    $st = "<span class='badge badge-success'>Aktif</span>";
                } else {
                    $st = "<span class='badge badge-dark'>Tidak Aktif</span>";
                }

                $tbody[]    = "<div align='center'>".$no.".</div>";
                $tbody[]    = $o['nama'];
                $tbody[]    = $o['alamat'];
                $tbody[]    = $o['lat'];
                $tbody[]    = $o['long'];
                $tbody[]    = $o['email'];
                $tbody[]    = $o['no_hp'];
                $tbody[]    = "<div align='center'>".$st."</div>";
                $tbody[]    = "<button type='button' class='btn btn-sm btn-success mr-3 edit-dtw' data-id='".$o['id_dtw']."'>Edit</button><button type='button' class='btn btn-sm btn-danger hapus-dtw' data-id='".$o['id_dtw']."'>Hapus</button>";
                $data[]     = $tbody;
            }
        } else {
            foreach ($list as $o) {
                $no++;
                $tbody = array();

                if ($o['status'] == 1) {
                    $st = "<span class='badge badge-success'>Aktif</span>";
                } else {
                    $st = "<span class='badge badge-dark'>Tidak Aktif</span>";
                }

                $tbody[]    = "<div align='center'>".$no.".</div>";
                $tbody[]    = $o['nama'];
                $tbody[]    = $o['alamat'];
                $tbody[]    = $o['lat'];
                $tbody[]    = $o['long'];
                $tbody[]    = $o['email'];
                $tbody[]    = $o['no_hp'];
                $tbody[]    = "<div align='center'>".$st."</div>";
                $tbody[]    = "<button type='button' class='btn btn-sm btn-success mr-3 edit-dtw' data-id='".$o['id_hotel']."'>Edit</button><button type='button' class='btn btn-sm btn-danger hapus-dtw' data-id='".$o['id_hotel']."'>Hapus</button>";
                $data[]     = $tbody;
            }
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_dtw_hotel->jumlah_semua_detail_dtw_hotel($id_kota, $aksi),
                    "recordsFiltered"  => $this->M_dtw_hotel->jumlah_filter_detail_dtw_hotel($id_kota, $aksi),   
                    "data"             => $data
                ];

        echo json_encode($output);
        
    }

    // proses simpan data
    public function simpan_data_dtw_hotel()
    {
        $aksi       = $this->input->post('aksi');
        $jenis      = $this->input->post('jenis');
        $nama       = $this->input->post('nama');
        $lat        = $this->input->post('lat');
        $long       = $this->input->post('long');
        $alamat     = $this->input->post('alamat');
        $email      = $this->input->post('email');
        $no_hp      = $this->input->post('no_hp');
        $status     = $this->input->post('status');
        $id_kota    = $this->input->post('id_kota');
        $id         = $this->input->post('id');

        if ($jenis == 'dtw') {
            $nm     = 'nama_dtw';
            $f_id   = 'id_dtw';
        } else {
            $nm     = 'nama_hotel';
            $f_id   = 'id_hotel';
        }

        $data = [$nm       => $nama,
                'alamat'   => $alamat,
                'lat'      => $lat,
                'long'     => $long,
                'email'    => $email,
                'no_hp'    => $no_hp,
                'status'   => $status,
                'id_kota'  => $id_kota
                ];

        if ($aksi == 'Tambah') {
            $this->M_dtw_hotel->input_data($jenis, $data);
        } elseif ($aksi == 'Ubah') {
            $this->M_dtw_hotel->ubah_data($jenis, $data, array($f_id => $id));
        } elseif ($aksi == 'Hapus') {
            $this->M_dtw_hotel->hapus_data($jenis, array($f_id => $id));
        }

        echo json_encode($aksi);
        
    }

    // ambil data dtw hotel
    public function ambil_data_dtw_hotel($jenis, $id)
    {
        $data = $this->M_dtw_hotel->cari_data($jenis, array("id_$jenis" => $id))->row_array();

        echo json_encode($data);
    }

}

/* End of file Dtw_hotel_kota.php */
