<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penempatan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_penempatan');
    }

    // 30-12-2019

    public function index()
    {
        if (!empty($this->userdata)) {
            $data['userdata']   = $this->userdata;
            $data['Menu']       = "Penempatan";
            $data['Page']       = "Penempatan";
            $data['kota']       = $this->M_penempatan->get_kota();
            $data['petugas']    = $this->M_penempatan->get_petugas($this->userdata->id_kota);
            
            $this->template->views('V_penempatan', $data);
        }
        else{
            
            redirect('Auth/Auth','refresh');
            
        }
    }

    // menampilkan penempatan petugas 
    public function tampil_penempatan()
    {
        $id_kota = $this->userdata->id_kota;

        $penempatan = $this->input->post('penempatan');
        $id_pegawai = $this->input->post('id_pegawai');

        $data = array();

        if ($penempatan == 'dtw') {
            $p_dtw      = $this->M_penempatan->get_penempatan('dtw', $id_kota, $id_pegawai)->result();

            // mengambil data pada penempatan dtw
            foreach ($p_dtw as $pd) {
                
                $data['dtw'][] = [  'nama_petugas'   => $pd->nama_petugas, 
                                    'penempatan'     => 'DTW',
                                    'nama_tempat'    => $pd->nama_dtw,
                                    'status'         => $pd->status,
                                    'id_penempatan'  => $pd->id_penempatan_dtw,
                                    'tabel'          => 'penempatan_dtw',
                                    'id_dtw_hotel'   => $pd->id_dtw
                                ];
            }
        } elseif($penempatan == 'hotel') {
            $p_hotel    = $this->M_penempatan->get_penempatan('hotel', $id_kota, $id_pegawai)->result();

            // mengambil data pada penempatan hotel
            foreach ($p_hotel as $ph) {
                
                $data['hotel'][] = ['nama_petugas'   => $ph->nama_petugas, 
                                    'penempatan'     => 'HOTEL',
                                    'nama_tempat'    => $ph->nama_hotel,
                                    'status'         => $ph->status,
                                    'id_penempatan'  => $ph->id_penempatan_hotel,
                                    'tabel'          => 'penempatan_hotel',
                                    'id_dtw_hotel'   => $ph->id_hotel
                                ];
            }
        } else {

            $p_dtw      = $this->M_penempatan->get_penempatan('dtw', $id_kota, $id_pegawai)->result();

            // mengambil data pada penempatan dtw
            foreach ($p_dtw as $pd) {
                
                $data['dtw'][] = [  'nama_petugas'   => $pd->nama_petugas, 
                                    'penempatan'     => 'DTW',
                                    'nama_tempat'    => $pd->nama_dtw,
                                    'status'         => $pd->status,
                                    'id_penempatan'  => $pd->id_penempatan_dtw,
                                    'tabel'          => 'penempatan_dtw',
                                    'id_dtw_hotel'   => $pd->id_dtw
                                ];
            }

            $p_hotel    = $this->M_penempatan->get_penempatan('hotel', $id_kota, $id_pegawai)->result();

            // mengambil data pada penempatan hotel
            foreach ($p_hotel as $ph) {
                
                $data['hotel'][] = ['nama_petugas'   => $ph->nama_petugas, 
                                    'penempatan'     => 'HOTEL',
                                    'nama_tempat'    => $ph->nama_hotel,
                                    'status'         => $ph->status,
                                    'id_penempatan'  => $ph->id_penempatan_hotel,
                                    'tabel'          => 'penempatan_hotel',
                                    'id_dtw_hotel'   => $ph->id_hotel
                                ];
            }

        }
        
        ksort($data);

        $no=0;
        foreach($data as $key =>$value)
        {
            foreach($value as $p)
            {
                $no++;
                $row    = array();

                if ($p['status'] == 1) {
                    $status = "<span class='badge badge-success'>Active</span>";
                    $aksi   = "<button class='btn btn-sm btn-success mr-3 ubah-penempatan' data-id='".$p['id_penempatan']."' nm_tabel='".$p['tabel']."' penempatan='".strtolower($p['penempatan'])."' id_kota='".$id_kota."'>Edit</button><button class='btn btn-sm btn-danger hapus-penempatan' data-id='".$p['id_penempatan']."' nm_tabel='".$p['tabel']."'>Hapus</button>";
                } else {
                    $status = "<span class='badge badge-warning'>Inactive</span>";
                    $aksi   = "<button class='btn btn-sm btn-warning ubah-kembali' data-id='".$p['id_penempatan']."' nm_tabel='".$p['tabel']."' penempatan='".strtolower($p['penempatan'])."' id_dtw_hotel='".$p['id_dtw_hotel']."'>Aktifkan</button>";
                }

                $row[]  = $no.".";
                $row[]  = $p['nama_petugas'];
                $row[]  = $p['penempatan'];
                $row[]  = $p['nama_tempat'];
                $row[]  = $status;
                $row[]  = $aksi;
            
                $dt[]   = $row;
            }
        }

        if ($data) {
            echo json_encode(array('data'=> $dt));
        }else{
            echo json_encode(array('data'=>0));
        }
    }

    // aksi untuk tabel penempatan 
    public function aksi_penempatan()
    {
        $id_penempatan      = $this->input->post('id_penempatan');
        $nm_tabel           = $this->input->post('nm_tabel');
        $aksi               = $this->input->post('aksi');
        $id_hotel_dtw       = $this->input->post('id_hotel_dtw');
        $penempatan         = $this->input->post('penempatan');
        $id_penempatan_sbl  = $this->input->post('id_penempatan_sbl');
        
        if ($aksi == 'hapus') {
            $this->M_penempatan->ubah_data($nm_tabel, array('status' => 0),array("id_$nm_tabel" => $id_penempatan));
        } elseif ($aksi == 'ubah_kembali') {
            $this->M_penempatan->ubah_data($nm_tabel, array('status' => 1),array("id_$nm_tabel" => $id_penempatan));
        } elseif ($aksi == 'ubah') {
            $this->M_penempatan->ubah_data($nm_tabel, array("id_$penempatan" => $id_hotel_dtw, 'status' => 1),array("id_$nm_tabel" => $id_penempatan));
        } elseif ($aksi == 'ubah_kembali_hapus') {
            $this->M_penempatan->ubah_data($nm_tabel, array('status' => 1),array("id_$nm_tabel" => $id_penempatan));
            $this->M_penempatan->ubah_data($nm_tabel, array('status' => 0),array("id_$nm_tabel" => $id_penempatan_sbl));
        }
        
        echo json_encode(['status' => TRUE]);
    }

    // mengambil data penempatan 
    public function ambil_data_penempatan()
    {
        $id_penempatan  = $this->input->post('id_penempatan');
        $nm_tabel       = $this->input->post('nm_tabel');
        $penempatan     = $this->input->post('penempatan');
        $id_kota        = $this->input->post('id_kota');

        $cr_1 = $this->M_penempatan->cari_data("penempatan_$penempatan", array("id_penempatan_$penempatan" => $id_penempatan))->row_array();
        $cr_2 = $this->M_penempatan->cari_data("petugas", array('id_petugas' => $cr_1['id_pegawai']))->row_array();

        if ($penempatan == 'dtw') {
            $list_dtw   = $this->M_penempatan->get_list_select_penempatan($id_kota, $nm_tabel, $penempatan)->result_array();

            $option = "<option value='a'>-- Pilih DTW --</option>";

            foreach ($list_dtw as $a) {
                $option .= "<option value='".$a['id_dtw']."'>".$a['nama_dtw']."</option>";
            }

        } else {
            $list_hotel = $this->M_penempatan->get_list_select_penempatan($id_kota, $nm_tabel, $penempatan)->result_array();

            $option = "<option value='a'>-- Pilih Hotel --</option>";

            foreach ($list_hotel as $a) {
                $option .= "<option value='".$a['id_hotel']."'>".$a['nama_hotel']."</option>";
            }
        }

        $dt = [ 'statu'         => TRUE,
                'nm_petugas'    => $cr_2['nama_petugas'],
                'id_petugas'    => $cr_2['id_petugas'],
                'select_p'      => $option
              ];

        echo json_encode($dt);
    }

    // cek penempatan dtw hotel 
    public function cek_penempatan()
    {
        $nm_tabel       = $this->input->post('nm_tabel');
        $penempatan     = $this->input->post('penempatan');
        $id_hotel_dtw   = $this->input->post('id_dtw_hotel');

        $data = $this->M_penempatan->cari_data_penempatan($nm_tabel, $penempatan, $id_hotel_dtw);

        $dt  = $data->num_rows();
        $dt2 = $data->row_array(); 
        
        echo json_encode(['status' => TRUE, 'cari_p' => $dt, 'id_penempatan' => $dt2["id_$nm_tabel"]]);
    }

    // menampilkan tambah data petugas
    public function tampil_penempatan_tambah()
    {
        $id_kota = $this->userdata->id_kota;

        $data = array();

        $p_dtw      = $this->M_penempatan->get_penempatan_tambah('dtw', $id_kota)->result();

        // mengambil data pada penempatan dtw
        foreach ($p_dtw as $pd) {
            
            $data['dtw'][] = [ 
                                'penempatan'     => 'DTW',
                                'nama_tempat'    => $pd->nama_dtw,
                                'tabel'          => 'penempatan_dtw',
                                'id_dtw_hotel'   => $pd->id_dtw,
                                'alamat'         => $pd->alamat
                            ];
        }

        $p_hotel    = $this->M_penempatan->get_penempatan_tambah('hotel', $id_kota)->result();

        // mengambil data pada penempatan hotel
        foreach ($p_hotel as $ph) {
            
            $data['hotel'][] = [
                                'penempatan'     => 'HOTEL',
                                'nama_tempat'    => $ph->nama_hotel,
                                'tabel'          => 'penempatan_hotel',
                                'id_dtw_hotel'   => $ph->id_hotel,
                                'alamat'         => $ph->alamat
                            ];
        }
        
        ksort($data);

        $no=0;
        foreach($data as $key =>$value)
        {
            foreach($value as $p)
            {
                $no++;
                $row    = array();

                $row[]  = $no.".";
                $row[]  = "<input type='checkbox' name='id_jenis[]' value='".$p['id_dtw_hotel']."' penempatan='".strtolower($p['penempatan'])."'>";
                $row[]  = $p['penempatan'];
                $row[]  = $p['nama_tempat'];
                $row[]  = $p['alamat'];
            
                $dt[]   = $row;
            }
        }

        if ($data) {
            echo json_encode(array('data'=> $dt));
        }else{
            echo json_encode(array('data'=>0));
        }
    }

    // proses simpan tambah penempatan
    public function simpan_tambah_penempatan()
    {
        $id_petugas     = $this->input->post('id_petugas');
        $penempatan     = strtolower($this->input->post('penempatan'));
        $id_dtw_hotel   = $this->input->post('id_dtw_hotel');
        
        $hasil = array();

        for ($i=0; $i < count($id_dtw_hotel); $i++) { 

        $hasil[] = [ 'id_pegawai'       => $id_petugas,
                     "id_$penempatan"   => $id_dtw_hotel[$i],
                     'status'           => 1
                    ];
        }
        
        $this->M_penempatan->input_data_batch("penempatan_$penempatan", $hasil);

        echo json_encode(['status'  => TRUE]);
    }

    // Akhir 30-12-2019

    public function json()
    {
        $kota = $this->userdata->id_kota;
        $data = $this->M_petugas->get_petugas($kota);
        echo json_encode($data);
    }

    public function get_penempatan()
    {
        $kota = $this->input->get('id');
        $data['dtw'] = $this->M_penempatan->get_dtw($kota);
        $data['hotel'] = $this->M_penempatan->get_hotel($kota);
        echo json_encode($data); 
    }

    public function json_penempatan()
    {
        $kota = $this->input->get('id');
        $data['dtw'] = $this->M_penempatan->get_p_dtw($kota);
        $data['hotel'] = $this->M_penempatan->get_p_hotel($kota);
        echo json_encode($data);
    }


    public function simpan_dtw()
    {
     $petugas = $this->input->post('petugas_add');
     $pn = $this->input->post('id_pn[]');
     $fil_pn = $this->input->post('fil_penempatan');
     $i= "0";
     $j= "0";
     if(is_array($pn)){
            foreach ($pn as $key => $val) {
             $data[$i]['id_pegawai'] = $petugas;
             $data[$i]['id_dtw'] = $val;
             $data[$i]['status'] = "1";
             $i++;   
            }
           $q = $this->db->insert_batch('penempatan_dtw', $data); 
           echo json_encode($q);
     }
    }

    public function simpan_hotel()
    {
     $petugas = $this->input->post('petugas_add');
     $pn = $this->input->post('id_pn[]');
     $fil_pn = $this->input->post('fil_penempatan');
     $i= "0";
     $j= "0";
     if(is_array($pn)){
            foreach ($pn as $key => $val) {
             $data[$i]['id_pegawai'] = $petugas;
             $data[$i]['id_hotel'] = $val;
             $data[$i]['status'] = "1";
             $i++;   
            }
           $q = $this->db->insert_batch('penempatan_hotel', $data); 
           echo json_encode($q);
     }
    }     

    //     $data = $this->M_petugas->simpan($arr);
    //     echo json_encode($data);
    // }

    // public function hapus()
    // {
    //     $id = $this->input->post('id');
    //     $data = $this->M_petugas->hapus($id);
    //     echo json_encode($data);
    // }

    // public function edit()
    // {
    //     $id = $this->input->post('id');
    //     $data = $this->M_petugas->edit($id);
    //     echo json_encode($data);
    // }

    // public function update()
    // {
    //     $id = $this->input->post('id');
    //     $arr = array(
    //        'nama_petugas' => $this->input->post('petugas'),
    //        'nik' => $this->input->post('nik'),
    //        'alamat' => $this->input->post('alamat'),
    //        'email' => $this->input->post('email'),
    //        'no_telp' => $this->input->post('no_telp'),
    //        'status' => $this->input->post('status')
    //     );
    //     $data = $this->M_petugas->update($id, $arr);
    //     echo json_encode($data);
    // }
}
