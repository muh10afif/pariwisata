<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Kota extends MY_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_kota'));
        $this->cek_login_lib->belum_login();
    }

    public function index()
    {
        if (!empty($this->userdata)) {

            $data = ['userdata'     => $this->userdata,
                     'Menu'         => 'Kelola-Users',
                     'Page'         => 'User Kota',
                     'kota'         => $this->M_kota->get_nama_kota_user()->result_array()
                    ];

            $this->template->views('V_kota', $data);

        }
    }

    // menampilkan list user kota
    public function tampil_user_kota()
    {
        $list = $this->M_kota->get_data_user_kota();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = $o['nama_kota'];
            $tbody[]    = $o['username'];
            $tbody[]    = "<button type='button' class='btn btn-sm btn-success mr-3 edit-kota' data-id='".$o['id_user']."'>Edit</button><button type='button' class='btn btn-sm btn-danger hapus-kota' data-id='".$o['id_user']."'>Hapus</button>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_kota->jumlah_semua_user_kota(),
                    "recordsFiltered"  => $this->M_kota->jumlah_filter_user_kota(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi proses simpan data user kota
    public function simpan_data_user_kota()
    {
        $aksi       = $this->input->post('aksi');
        $id_kota    = $this->input->post('kota');
        $id_user    = $this->input->post('id_user');
        $username   = $this->input->post('username');
        $password   = $this->input->post('password');

        if ($password != '') {
            $data = ['username'     => $username,
                    'password'     => password_hash($password, PASSWORD_DEFAULT),
                    'id_kota'      => $id_kota,
                    'id_pegawai'   => 0,
                    'id_dtw'       => 0,
                    'id_hotel'     => 0
                    ];
        } else {
            $data = ['username'    => $username,
                    'id_kota'      => $id_kota,
                    'id_pegawai'   => 0,
                    'id_dtw'       => 0,
                    'id_hotel'     => 0
                    ];
        }

        

        if ($aksi == 'Tambah') {
            $this->M_kota->input_data('m_user', $data);
        } elseif ($aksi == 'Ubah') {
            $this->M_kota->ubah_data('m_user', $data, array('id_user' => $id_user));
        } elseif ($aksi == 'Hapus') {
            $this->M_kota->hapus_data('m_user', array('id_user' => $id_user));
        }

        // menampilkan option buat list kota
        $list = $this->M_kota->get_nama_kota_user()->result_array();

        $option = "<option value=' '>-- Pilih Kota --</option>";

        foreach ($list as $l) {
            $option .= "<option value='".$l['id_kota']."'>".$l['nama_kota']."</option>";
        }

        echo json_encode(['status'  => TRUE, 'aksi' => $aksi, 'list_kota' => $option]);
    }

    // ambil data user kota
    public function ambil_data_user_kota($id_user)
    {
        $data = $this->M_kota->cari_data('m_user', array("id_user" => $id_user))->row_array();

        $list = $this->M_kota->cari_data('kota', array('id_kota' => $data['id_kota']))->row_array();

        $option = "<option value='".$list['id_kota']."'>".$list['nama_kota']."</option>";

        // menampilkan option buat list kota
        $list = $this->M_kota->get_nama_kota_user()->result_array();

        foreach ($list as $l) {
            $option .= "<option value='".$l['id_kota']."'>".$l['nama_kota']."</option>";
        }

        array_push($data, array('nama_kota' => $option));

        echo json_encode($data);
    }

    // ambil list kota
    public function ambil_list_kota()
    {
        // menampilkan option buat list kota
        $list = $this->M_kota->get_nama_kota_user()->result_array();

        $option = "<option value=' '>-- Pilih Kota --</option>";

        foreach ($list as $l) {
            $option .= "<option value='".$l['id_kota']."'>".$l['nama_kota']."</option>";
        }

        echo json_encode(['status'  => TRUE, 'list_kota' => $option]);
    }

}

/* End of file Kota.php */
