<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Hotel extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_hotel'));
        $this->cek_login_lib->belum_login();
    }

    // 19-02-2020

    public function index()
    {
        $data = ['userdata'     => $this->userdata,
                 'Menu'         => 'Kelola-Users',
                 'Page'         => 'User Hotel'
                ];

        $id_kota = $this->userdata->id_kota;

        if ($id_kota != 0) {
    
            redirect("Users/Hotel/tampil_detail_kota_hotel/$id_kota",'refresh');
            
        } else {
            $this->template->views('V_hotel', $data);
        }
    }

    // menampilkan list kota hotel 
    public function tampil_kota_hotel()
    {
        $list = $this->M_hotel->get_data_hotel_kota();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $id_kota = $o['id_kota'];

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = $o['nama_kota'];
            $tbody[]    = $o['tot_hotel'];
            $tbody[]    = $o['tot_user'];
            $tbody[]    = "<div align='center'><a href='".base_url("Users/Hotel/tampil_detail_kota_hotel/$id_kota")."'><button type='button' class='btn btn-sm btn-rose mr-3'>Tambah Data</button></a></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_hotel->jumlah_semua_hotel_kota(),
                    "recordsFiltered"  => $this->M_hotel->jumlah_filter_hotel_kota(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // menampilkan halaman detail kota hotel hotel
    public function tampil_detail_kota_hotel($id_kota)
    {
        $cari = $this->M_hotel->cari_data('kota', array('id_kota' => $id_kota))->row_array();

        $data = ['userdata'     => $this->userdata, 
                 'Menu'         => 'Kelola-Users',
                 'Page'         => 'User Hotel',
                 'hotel'        => $this->M_hotel->get_nama_hotel_user($id_kota)->result_array(),
                 'id_kota'      => $id_kota,
                 'id_sess_kota' => $this->userdata->id_kota,
                 'nama_kota'    => strtolower($cari['nama_kota'])
                ];

        $this->template->views('V_detail_user_hotel', $data);
    }

    // menampilkan list hotel
    public function tampil_list_hotel()
    {
        $id_kota = $this->input->post('id_kota');

        $list = $this->M_hotel->get_data_detail_hotel($id_kota);

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = $o['nama_hotel'];
            $tbody[]    = $o['username'];
            $tbody[]    = $o['alamat'];
            $tbody[]    = "<button type='button' class='btn btn-sm btn-success mr-3 edit-hotel' data-id='".$o['id_user']."'>Edit</button><button type='button' class='btn btn-sm btn-danger hapus-hotel' data-id='".$o['id_user']."'>Hapus</button>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_hotel->jumlah_semua_detail_hotel($id_kota),
                    "recordsFiltered"  => $this->M_hotel->jumlah_filter_detail_hotel($id_kota),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi proses simpan data user hotel
    public function simpan_data_user_hotel()
    {
        $aksi       = $this->input->post('aksi');
        $id_hotel   = $this->input->post('hotel');
        $id_kota    = $this->input->post('id_kota');
        $id_user    = $this->input->post('id_user');
        $username   = $this->input->post('username');
        $password   = $this->input->post('password');

        if ($password != '') {
            $data = ['username'     => $username,
                    'password'      => password_hash($password, PASSWORD_DEFAULT),
                    'id_hotel'      => $id_hotel,
                    'id_pegawai'    => 0,
                    'id_kota'       => 0,
                    'id_dtw'        => 0
                    ];
        } else {
            $data = ['username'      => $username,
                     'id_hotel'      => $id_hotel,
                     'id_pegawai'    => 0,
                     'id_kota'       => 0,
                     'id_dtw'        => 0
                    ];
        }

        if ($aksi == 'Tambah') {
            $this->M_hotel->input_data('m_user', $data);
        } elseif ($aksi == 'Ubah') {
            $this->M_hotel->ubah_data('m_user', $data, array('id_user' => $id_user));
        } elseif ($aksi == 'Hapus') {
            $this->M_hotel->hapus_data('m_user', array('id_user' => $id_user));
        }

        // menampilkan option buat list hotel
        $list = $this->M_hotel->get_nama_hotel_user($id_kota)->result_array();

        $option = "<option value=' '>-- Pilih Hotel --</option>";

        foreach ($list as $l) {
            $option .= "<option value='".$l['id_hotel']."'>".$l['nama_hotel']."</option>";
        }

        echo json_encode(['status'  => TRUE, 'aksi' => $aksi, 'list_hotel' => $option, 'jml_hotel' => count($list)]);
    }

    // ambil data user hotel
    public function ambil_data_user_hotel($id_user)
    {
        $id_kota  = $this->input->post('id_kota');
        
        $data = $this->M_hotel->cari_data('m_user', array("id_user" => $id_user))->row_array();

        $list = $this->M_hotel->cari_data('hotel', array('id_hotel' => $data['id_hotel']))->row_array();

        $option = "<option value='".$list['id_hotel']."'>".$list['nama_hotel']."</option>";

        // menampilkan option buat list hotel
        $list = $this->M_hotel->get_nama_hotel_user($id_kota)->result_array();

        foreach ($list as $l) {
            $option .= "<option value='".$l['id_hotel']."'>".$l['nama_hotel']."</option>";
        }

        array_push($data, array('nama_hotel' => $option, 'jml_hotel' => count($list)));

        echo json_encode($data);
    }

    // ambil list hotel
    public function ambil_list_hotel($id_kota)
    {
        // menampilkan option buat list hotel
        $list = $this->M_hotel->get_nama_hotel_user($id_kota)->result_array();

        $option = "<option value=' '>-- Pilih Hotel --</option>";

        foreach ($list as $l) {
            $option .= "<option value='".$l['id_hotel']."'>".$l['nama_hotel']."</option>";
        }

        echo json_encode(['status'  => TRUE, 'list_hotel' => $option, 'jml_hotel' => count($list)]);
    }

    // Akhir 19-02-2020

}

/* End of file Hotel.php */
