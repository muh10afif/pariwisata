<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Dtw extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_dtw'));
        $this->cek_login_lib->belum_login();
    }

    // 19-02-2020

    public function index()
    {
        $data = ['userdata'     => $this->userdata,
                 'Menu'         => 'Kelola-Users',
                 'Page'         => 'User DTW'
                ];

        $id_kota = $this->userdata->id_kota;

        if ($id_kota != 0) {
    
            redirect("Users/Dtw/tampil_detail_kota_dtw/$id_kota",'refresh');
            
        } else {
            $this->template->views('V_dtw', $data);
        }
    }

    // menampilkan list kota dtw 
    public function tampil_kota_dtw()
    {
        $list = $this->M_dtw->get_data_dtw_kota();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $id_kota = $o['id_kota'];

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = $o['nama_kota'];
            $tbody[]    = $o['tot_dtw'];
            $tbody[]    = $o['tot_user'];
            $tbody[]    = "<div align='center'><a href='".base_url("Users/Dtw/tampil_detail_kota_dtw/$id_kota")."'><button type='button' class='btn btn-sm btn-rose mr-3'>Tambah Data</button></a></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_dtw->jumlah_semua_dtw_kota(),
                    "recordsFiltered"  => $this->M_dtw->jumlah_filter_dtw_kota(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // menampilkan halaman detail kota dtw hotel
    public function tampil_detail_kota_dtw($id_kota)
    {
        $cari = $this->M_dtw->cari_data('kota', array('id_kota' => $id_kota))->row_array();

        $data = ['userdata'     => $this->userdata, 
                 'Menu'         => 'Kelola-Users',
                 'Page'         => 'User DTW',
                 'dtw'          => $this->M_dtw->get_nama_dtw_user($id_kota)->result_array(),
                 'id_kota'      => $id_kota,
                 'id_sess_kota' => $this->userdata->id_kota,
                 'nama_kota'    => strtolower($cari['nama_kota'])
                ];

        $this->template->views('V_detail_user_dtw', $data);
    }

    // menampilkan list dtw
    public function tampil_list_dtw()
    {
        $id_kota = $this->input->post('id_kota');

        $list = $this->M_dtw->get_data_detail_dtw($id_kota);

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = $o['nama_dtw'];
            $tbody[]    = $o['username'];
            $tbody[]    = $o['alamat'];
            $tbody[]    = "<button type='button' class='btn btn-sm btn-success mr-3 edit-dtw' data-id='".$o['id_user']."'>Edit</button><button type='button' class='btn btn-sm btn-danger hapus-dtw' data-id='".$o['id_user']."'>Hapus</button>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_dtw->jumlah_semua_detail_dtw($id_kota),
                    "recordsFiltered"  => $this->M_dtw->jumlah_filter_detail_dtw($id_kota),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi proses simpan data user dtw
    public function simpan_data_user_dtw()
    {
        $aksi       = $this->input->post('aksi');
        $id_dtw     = $this->input->post('dtw');
        $id_kota    = $this->input->post('id_kota');
        $id_user    = $this->input->post('id_user');
        $username   = $this->input->post('username');
        $password   = $this->input->post('password');

        if ($password != '') {
            $data = ['username'     => $username,
                    'password'      => password_hash($password, PASSWORD_DEFAULT),
                    'id_dtw'        => $id_dtw,
                    'id_pegawai'    => 0,
                    'id_kota'       => 0,
                    'id_hotel'      => 0
                    ];
        } else {
            $data = ['username'    => $username,
                     'id_dtw'        => $id_dtw,
                     'id_pegawai'    => 0,
                     'id_kota'       => 0,
                     'id_hotel'      => 0
                    ];
        }

        if ($aksi == 'Tambah') {
            $this->M_dtw->input_data('m_user', $data);
        } elseif ($aksi == 'Ubah') {
            $this->M_dtw->ubah_data('m_user', $data, array('id_user' => $id_user));
        } elseif ($aksi == 'Hapus') {
            $this->M_dtw->hapus_data('m_user', array('id_user' => $id_user));
        }

        // menampilkan option buat list dtw
        $list = $this->M_dtw->get_nama_dtw_user($id_kota)->result_array();

        $option = "<option value=' '>-- Pilih DTW --</option>";

        foreach ($list as $l) {
            $option .= "<option value='".$l['id_dtw']."'>".$l['nama_dtw']."</option>";
        }

        echo json_encode(['status'  => TRUE, 'aksi' => $aksi, 'list_dtw' => $option, 'jml_dtw' => count($list)]);
    }

    // ambil data user dtw
    public function ambil_data_user_dtw($id_user)
    {
        $id_kota  = $this->input->post('id_kota');
        
        $data = $this->M_dtw->cari_data('m_user', array("id_user" => $id_user))->row_array();

        $list = $this->M_dtw->cari_data('dtw', array('id_dtw' => $data['id_dtw']))->row_array();

        $option = "<option value='".$list['id_dtw']."'>".$list['nama_dtw']."</option>";

        // menampilkan option buat list dtw
        $list = $this->M_dtw->get_nama_dtw_user($id_kota)->result_array();

        foreach ($list as $l) {
            $option .= "<option value='".$l['id_dtw']."'>".$l['nama_dtw']."</option>";
        }

        array_push($data, array('nama_dtw' => $option, 'jml_dtw' => count($list)));

        echo json_encode($data);
    }

    // ambil list dtw
    public function ambil_list_dtw($id_kota)
    {
        // menampilkan option buat list dtw
        $list = $this->M_dtw->get_nama_dtw_user($id_kota)->result_array();

        $option = "<option value=' '>-- Pilih DTW --</option>";

        foreach ($list as $l) {
            $option .= "<option value='".$l['id_dtw']."'>".$l['nama_dtw']."</option>";
        }

        echo json_encode(['status'  => TRUE, 'list_dtw' => $option, 'jml_dtw' => count($list)]);
    }

    // Akhir 19-02-2020

}

/* End of file Dtw.php */
