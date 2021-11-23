<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hotel extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_hotel');
    }


    public function index()
    {
        if (!empty($this->userdata)) {
            $data['userdata'] = $this->userdata;
            $data['Menu'] = "Master";
            $data['Page'] = "Master Hotel";
            if ($this->userdata->id_dtw == 0 AND $this->userdata->id_hotel == "0" AND $this->userdata->id_pegawai == "0" AND $this->userdata->id_kota != "0")
            {
                $data['kota'] = $this->M_hotel->get_kota_p($this->userdata->id_kota);
            }
            else{
                $data['kota'] = $this->M_hotel->get_kota();
            }

            $id_kota = $this->userdata->id_kota;

            if ($id_kota != 0) {
        
                redirect("Master/Hotel/tampil_detail_kota_hotel/$id_kota",'refresh');
                
            } else {
                $this->template->views('V_hotel', $data);
            }

        }
    }

    // 18-02-2020

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
            $tbody[]    = "<div align='center'><a href='".base_url("Master/Hotel/tampil_detail_kota_hotel/$id_kota")."'><button type='button' class='btn btn-sm btn-rose mr-3'>Tambah Data</button></a></div>";
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
                 'Menu'         => "Master",
                 'Page'         => "Master Hotel",
                 'hotel'        => $this->M_hotel->cari_data('hotel', array('id_kota' => $id_kota))->result_array(),
                 'id_kota'      => $id_kota,
                 'id_sess_kota' => $this->userdata->id_kota,
                 'nama_kota'    => strtolower($cari['nama_kota'])
                ];

        $this->template->views('V_detail_hotel_kota', $data);
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
            $tbody[]    = "<button type='button' class='btn btn-sm btn-success mr-3 edit-hotel' data-id='".$o['id_hotel']."'>Edit</button><button type='button' class='btn btn-sm btn-danger hapus-hotel' data-id='".$o['id_hotel']."'>Hapus</button>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_hotel->jumlah_semua_detail_hotel($id_kota),
                    "recordsFiltered"  => $this->M_hotel->jumlah_filter_detail_hotel($id_kota),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi proses simpan data hotel
    public function simpan_data_hotel()
    {
        $aksi       = $this->input->post('aksi');
        $nama       = $this->input->post('nama');
        $lat        = $this->input->post('lat');
        $long       = $this->input->post('long');
        $alamat     = $this->input->post('alamat');
        $email      = $this->input->post('email');
        $no_hp      = $this->input->post('no_hp');
        $status     = $this->input->post('status');
        $id_kota    = $this->input->post('id_kota');
        $id         = $this->input->post('id_hotel');

        $data = ['nama_hotel' => $nama,
                 'alamat'   => $alamat,
                 'lat'      => $lat,
                 'long'     => $long,
                 'email'    => $email,
                 'no_hp'    => $no_hp,
                 'status'   => $status,
                 'id_kota'  => $id_kota
                ];

        if ($aksi == 'Tambah') {
            $this->M_hotel->input_data('hotel', $data);
        } elseif ($aksi == 'Ubah') {
            $this->M_hotel->ubah_data('hotel', $data, array('id_hotel' => $id));
        } elseif ($aksi == 'Hapus') {
            $this->M_hotel->hapus_data('hotel', array('id_hotel' => $id));
        }

        echo json_encode($aksi);
    }

    // ambil data hotel
    public function ambil_data_hotel($id_hotel)
    {
        $data = $this->M_hotel->cari_data('hotel', array("id_hotel" => $id_hotel))->row_array();

        echo json_encode($data);
    }

    // Akhir 18-02-2020

    // menampilkan data master hotel dengan json
    public function tampil_hotel()
    {   
        $id_kota = $this->userdata->id_kota;

        $data_hotel = $this->M_hotel->get_hotel_prov($id_kota);

        $no =1;
        foreach ($data_hotel as $value) {

            if ($value['status'] == 1) {
                $sts = '<span class="badge badge-success">active</span>';
            } else {
                $sts = '<span class="badge badge-danger">non active</span>';
            }

            $tbody = array();
            $tbody[] = "<div align='center'>".$no++.".</div>";
            $tbody[] = $value['nama_hotel'];
            $tbody[] = $value['nama_kota'];
            $tbody[] = $value['alamat'];
            $tbody[] = $value['lat'];
            $tbody[] = $value['long'];
            $tbody[] = $value['email'];
            $tbody[] = $value['no_hp'];
            $tbody[] = $sts;
            $tbody[] = "<button  class='btn btn-info btn-sm btn-link edit mr-0' data='".$value['id_hotel']."' ><i class='fa fa-edit'></i></button><button  class='btn btn-danger btn-sm btn-link hapus' data='".$value['id_hotel']."'><i class='fa fa-trash'></i></button>";
            $data[]  = $tbody; 
        }

        if ($data_hotel) {
            echo json_encode(array('data'=> $data));
        }else{
            echo json_encode(array('data'=>0));
        }
    }

    public function json()
    {
        $kota = $this->input->get('id');
        $data = $this->M_hotel->get_hotel($kota);
        echo json_encode($data);
    }

    public function json_prov()
    {
        // $kota = $this->input->get('id');
        $data = $this->M_hotel->get_hotel_prov();
        echo json_encode($data);
    }

    public function simpan()
    {
        $arr = array(
            'nama_hotel' => $this->input->post('hotel'),
            'id_kota' => $this->input->post('kota'),
            'alamat' => $this->input->post('alamat'),
            'lat' => $this->input->post('lat'),
            'long' => $this->input->post('long'),
            'email' => $this->input->post('email'),
            'no_hp' => $this->input->post('no_hp'),
            'status' => $this->input->post('status')
        );

        $data = $this->M_hotel->simpan($arr);
        echo json_encode($data);
    }

    public function hapus()
    {
        $id = $this->input->post('id');
        $data = $this->M_hotel->hapus($id);
        echo json_encode($data);
    }

    public function edit()
    {
        $id = $this->input->post('id');
        $data = $this->M_hotel->edit($id);
        echo json_encode($data);
    }

    public function update()
    {
        $id = $this->input->post('id');
        $arr = array(
           'nama_hotel' => $this->input->post('hotel'),
           'id_kota' => $this->input->post('kota'),
           'alamat' => $this->input->post('alamat'),
           'lat' => $this->input->post('lat'),
           'long' => $this->input->post('long'),
           'email' => $this->input->post('email'),
           'no_hp' => $this->input->post('no_hp'),
           'status' => $this->input->post('status')
        );
        $data = $this->M_hotel->update($id, $arr);
        echo json_encode($data);
    }

    public function import()
    {
        
           $config['upload_path']          = realpath(FCPATH.'uploads/');
           $config['allowed_types']        = 'xlsx|xls';
           $config['remove_spaces']        = true;
           $config['overwrite']            = true;

           $this->load->library('upload', $config);
        if (! $this->upload->do_upload('file')) {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata("pesan", "
                    <div class='alert alert-danger alert-block'> <a class='close' data-dismiss='alert' href='#'>×</a> <h4 class='alert-heading'>Upload Failed</h4>  $error
                    </div>");
                redirect('Master/Hotel', $error);
        } else {
            $filename = $this->upload->data('file_name');
            $excelreader = new PHPExcel_Reader_Excel2007();
            $loadexcel = $excelreader->load(FCPATH.'uploads/'.$filename); // Load file yang tadi diupload ke folder excel
            $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);
            $numrow = 1;
            foreach ($sheet as $row) {
                if ($numrow > 1 && !empty($row['A'])) {
                    $c = array(
                        'kota' => $row['A'],
                        'nama_hotel' => $row['B'],
                        'alamat'=> $row['C'],
                        'lat' => $row['D'],
                        'long' => $row['E'],
                        'email' => $row['F'],
                        'no_hp' => $row['G'],
                        'status' =>'1',
                    );
                    $this->M_hotel->import($c);
                }
                            
                $numrow++; // Tambah 1 setiap kali looping
            }
            // Panggil fungsi insert_multiple yg telah kita buat sebelumnya di model
                        
            if ($this->db->affected_rows() > 0) {
                 $this->session->set_flashdata("pesan", "
                            <div class='alert alert-danger alert-block'> <a class='close' data-dismiss='alert' href='#'>×</a> <h4 class='alert-heading'>Upload Failed</h4>  $error
                            </div>");
                redirect('Master/Hotel', $error);
            } else {
                // $this->M_coa->update_mains();
                $this->session->set_flashdata("pesan", "
                            <div class='alert alert-success alert-block'> <a class='close' data-dismiss='alert' href='#'>×</a> <h4 class='alert-heading'></h4>Import Berhasil
                            </div>");
                redirect('Master/Hotel');
            }
        }
    }


}
