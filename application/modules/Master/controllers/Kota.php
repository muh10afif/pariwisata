<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kota extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_kota');
        $this->cek_login_lib->belum_login();
    }

    // 19-02-2020

        public function index()
        {
            $data['userdata']   = $this->userdata;
            $data['Menu']       = "Master";
            $data['Page']       = "Master Kota";
            $data['provinsi']   = $this->M_kota->get_data_order('provinsi', 'nama_provinsi', 'asc')->result_array();

            $this->template->views('V_kota', $data);
        }

        // menampilkan list kota 
        public function tampil_data_kota()
        {
            $list = $this->M_kota->get_data_kota();

            $data = array();

            $no   = $this->input->post('start');

            foreach ($list as $o) {
                $no++;
                $tbody = array();

                $tbody[]    = "<div align='center'>".$no.".</div>";
                $tbody[]    = $o['nama_kota'];
                $tbody[]    = $o['nama_provinsi'];
                $tbody[]    = "<button type='button' class='btn btn-sm btn-success mr-3 edit-kota' data-id='".$o['id_kota']."'>Edit</button><button type='button' class='btn btn-sm btn-danger hapus-kota' data-id='".$o['id_kota']."'>Hapus</button>";
                $data[]     = $tbody;
            }

            $output = [ "draw"             => $_POST['draw'],
                        "recordsTotal"     => $this->M_kota->jumlah_semua_kota(),
                        "recordsFiltered"  => $this->M_kota->jumlah_filter_kota(),   
                        "data"             => $data
                    ];

            echo json_encode($output);
        }

        // aksi proses simpan data kota
        public function simpan_data_kota()
        {
            $aksi       = $this->input->post('aksi');
            $id_kota    = $this->input->post('id_kota');
            $kota       = $this->input->post('kota');
            $provinsi   = 35;

            $data = ['nama_kota'    => $kota,
                    'id_provinsi'  => $provinsi
                    ];

            if ($aksi == 'Tambah') {
                $this->M_kota->input_data('kota', $data);
            } elseif ($aksi == 'Ubah') {
                $this->M_kota->ubah_data('kota', $data, array('id_kota' => $id_kota));
            } elseif ($aksi == 'Hapus') {
                $this->M_kota->hapus_data('kota', array('id_kota' => $id_kota));
            }

            echo json_encode($aksi);
        }

        // ambil data kota
        public function ambil_data_kota($id_kota)
        {
            $data = $this->M_kota->cari_data('kota', array("id_kota" => $id_kota))->row_array();

            echo json_encode($data);
        }

    // Akhir 19-02-2020

    public function tes()
    {
        $data = $this->M_kota->get_kota()->result_array();

        print_r(count($data));
    }

    // menampilkan data master kota dengan json
    public function tampil_kota()
    {   
        $data_kota = $this->M_kota->get_kota()->result_array();

        $no =1;
        foreach ($data_kota as $value) {

            $tbody = array();
            $tbody[] = "<div align='center'>".$no++.".</div>";
            $tbody[] = $value['nama_kota'];
            $tbody[] = "<button  class='btn btn-info btn-sm add' data='".$value['id_kota']."'>Buat User</button>";
            $data[]  = $tbody; 
        }

        if ($data_kota) {
            echo json_encode(array('data'=> $data));
        }else{
            echo json_encode(array('data'=>0));
        }
    }

    public function fil_prov()
    {
        $data = $this->M_kota->fil_prov($this->input->post('id_prov'));
        echo json_encode($data);
    }
    
    public function buat_user()
    {
        $data = $this->M_kota->get_kota();
        echo json_encode($data);
    }

    public function simpan_users_kota()
    {
        $arr  = array(
            'id_hotel'=> "0",
            'id_pegawai'=>"0",
            'id_kota'=>$this->input->post('id_kota'),
            'id_dtw'=>"0",
            'foto'=>" ",
            'username'=>$this->input->post('username') ,
            'password'=> password_hash($this->input->post('password'), PASSWORD_DEFAULT) ,
            //'status' => $this->input->post('status')
        );
        $data = $this->M_kota->simpan_users_kota($arr);
        echo json_encode($data);
    }
}
