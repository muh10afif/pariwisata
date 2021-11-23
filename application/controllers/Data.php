<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_master', 'M_data'));
    }

    /**********************************************************************************/

    /*                                  KELOLAAN                                      */

    /**********************************************************************************/
    
    // halaman kelolaan
    public function kelolaan()
    {
        $data = [
                 'judul'        => 'Kelolaan',
                 'kelolaan'     => 'active',
                 'd_karyawan'   => $this->M_master->get_data_karyawan()->result_array(),
                 'd_mesin'      => $this->M_master->get_data_mesin_belum()->result_array()
                ];
            
        $this->template->load('template', 'data/kelolaan/V_kelolaan', $data);
    }

    // menampilkan list data kelolaan
    public function tampil_kelolaan()
    {
        $data_kelolaan = $this->M_data->get_data_kelolaan()->result_array();

        $no = 1;
        foreach ($data_kelolaan as $k) {
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no++."</div>";
            $tbody[]    = $k['nama_karyawan'];
            $tbody[]    = $k['nama_mesin'];
            $aksi       = "<div align='center'> <button class='btn btn-icon btn-icon-circle btn-sun btn-icon-style-2 ubah-kelolaan' data-id=".$k['id_kelola_mesin']."><span class='btn-icon-wrap'><i class='icon-pencil'></i></span></button>".' '."<button class='btn btn-icon btn-icon-circle btn-danger btn-icon-style-2 hapus-kelolaan' id='id' data-id=".$k['id_kelola_mesin']."><span class='btn-icon-wrap'><i class='icon-trash'></i></span></button> </div>";    
            $tbody[]    = $aksi;
            $data[]     = $tbody; 
        }

        if ($data_kelolaan) {
            echo json_encode(array('data'   => $data));
        } else {
            echo json_encode(array('data'   => 0));
        }
    }

    // proses tambah kelolaan
    public function tambah_kelolaan()
    {
        $id_pegawai = $this->input->post('id_karyawan');
        $id_mesin   = $this->input->post('id_mesin');

        $data = [
                 'id_pegawai'   => $id_pegawai,
                 'id_mesin'     => $id_mesin                 
                ];

        $cek_id_pegawai_mesin = $this->M_data->cari_data('kelola_mesin', $data)->num_rows();

        $cek_id_mesin = $this->M_data->cari_data('kelola_mesin', array('id_mesin' => $id_mesin))->num_rows();

        // jika id pegawai dan id_mesin tidak ada pada tabel kelola mesin
        if ($cek_id_pegawai_mesin == 0) {

            if ($cek_id_mesin == 0) {

                $hasil  = $this->M_master->input_data('kelola_mesin', $data);

                $data_mesin = $this->M_master->get_data_mesin_belum()->result_array();

                if (!empty($data_mesin)) {

                    $option[] = "<option value=' '>-- Pilih Mesin --</option>";
                    foreach ($data_mesin as $k) {
                        $option[]   = "<option value=".$k['id_mesin'].">".$k['nama_mesin']."</option>";
                    }
                    
                } else {
                    $option = 0;
                }

                echo json_encode(array('data' => $hasil, 'cek' => '0 id_mesin', 'mesin' => $option));

            } else {
                echo json_encode(array('cek' => '1 id_mesin'));
            }
            
        } else {
            
            echo json_encode(array('cek' => '0'));
        }
       
    }

    // menampilkan form edit kelolaan
    public function form_edit_kelolaan()
    {
        $where  = ['id_kelola_mesin'  => $this->input->post('id_kelola_mesin')];

        $data   = [ 'd_karyawan'    => $this->M_master->get_data_karyawan()->result_array(),
                    'd_mesin'       => $this->M_master->get_data_mesin_atm()->result_array(),
                    'd_kelolaan'    => $this->M_data->edit_data_kelolaan('kelola_mesin', $where)->row_array()
                ];

        $this->load->view('data/kelolaan/V_edit_kelolaan', $data);
    }

    // proses ubah
    public function ubah_kelolaan($id = 0)
    {
        $id_pegawai      = $this->input->post('id_karyawan');
        $id_mesin        = $this->input->post('id_mesin');
        $id_pegawai_lama = $this->input->post('id_pegawai_lama');
        $id_mesin_lama   = $this->input->post('id_mesin_lama');

        $data = [
                 'id_pegawai'   => $id_pegawai,
                 'id_mesin'     => $id_mesin                 
                ];

        $where  = [ 'id_kelola_mesin'   => $this->input->post('id_kelola_mesin')];

        $cek_id_pegawai_mesin = $this->M_data->cari_data('kelola_mesin', $data)->num_rows();

        $cek_id_mesin = $this->M_data->cari_data('kelola_mesin', array('id_mesin' => $id_mesin))->num_rows();


        // jika id pegawai dan id_mesin tidak ada pada tabel kelola mesin
        if ($cek_id_pegawai_mesin == 0) {

            if ($cek_id_mesin == 0) {

                if ($id == 0) {
                    $hasil  = $this->M_master->ubah_data('kelola_mesin', $data, $where);
                } else {
                    $hasil  = null;
                }

                $data_mesin = $this->M_master->get_data_mesin_belum()->result_array();

                if ($data_mesin) {

                    $option[] = "<option value=' '>-- Pilih Mesin --</option>";
                    foreach ($data_mesin as $k) {
                        $option[]   = "<option value=".$k['id_mesin'].">".$k['nama_mesin']."</option>";
                    }
                    
                } else {
                    $option = 0;
                }

                echo json_encode(array('data' => $hasil, 'cek' => '0 id_mesin', 'mesin' => $option));
                
            } else {
                echo json_encode(array('cek' => '1 id_mesin'));
            }
            
        } else {

            $data_mesin = $this->M_master->get_data_mesin_belum()->result_array();

            if (($id_mesin == $id_mesin_lama) && ($id_pegawai == $id_pegawai_lama) ) {
                if ($data_mesin) {
                    
                    $option[] = "<option value=' '>-- Pilih Mesin --</option>";
                    foreach ($data_mesin as $k) {
                        $option[]   = "<option value=".$k['id_mesin'].">".$k['nama_mesin']."</option>";
                    }
                    
                } else {
                    $option = 0;
                }

                echo json_encode(array('cek' => '1 bisa masuk', 'mesin' => $option));
            } else {
                echo json_encode(array('cek' => '0'));
            }
        }

    }

    // proses hapus
    public function hapus_kelolaan()
    {
        $where  = ['id_kelola_mesin'    => $this->input->post('id_kelola_mesin')];

        $hasil  = $this->M_master->hapus_data('kelola_mesin', $where);

        $data_mesin = $this->M_master->get_data_mesin_belum()->result_array();

        if ($data_mesin) {
                    
            $option[] = "<option value=' '>-- Pilih Mesin --</option>";
            foreach ($data_mesin as $k) {
                $option[]   = "<option value=".$k['id_mesin'].">".$k['nama_mesin']."</option>";
            }
            
        } else {
            $option = 0;
        }

        echo json_encode(array('hasil' => $hasil, 'mesin' => $option));
    }

    /**********************************************************************************/

    /*                              TASKLIST TBI                                */

    /**********************************************************************************/

    // menampilkan halaman monitoring pegawai
    public function task_tbi()
    {
        $data   = [ 'judul'         => 'Tasklist TBI',
                    'pegawai'       => 'active',
                    'd_karyawan'    => $this->M_master->jenis_task()->result_array(),
                    'l_karyawan'    => $this->M_master->list_pegawai()->result_array()          
                  ];

        $this->template->load('template', 'data/task_tbi/V_mon_pegawai', $data);
    }

    // menampilkan data monitoring pegawai
    public function tampil_task_tbi()
    {
        $id_jenis  = $this->input->post('id_jenis');
        
        $list   = $this->M_data->get_datatables($id_jenis);

        $data   = array();
        $no     = $_POST['start'];

        foreach ($list as $s) {
            $no++;
            $row    = array();
            $row[]  = "<div align='center'>".$no."</div>";
            $row[]  = $s['jenis_tasklist'];
            $row[]  = $s['pemberi_tugas'];
            $row[]  = $s['penerima_tugas'];
            $row[]  = $s['tasklist'];
            $row[]  = tgl_indo($s['expire_date']);
            if($s['status'] == 0)
            {
                $status = "Belum Dikerjakan";
            }
            else if($s['status'] == 1)
            {
                $status = "Menunggu Approval";
            }
            else if($s['status'] == 2)
            {
                $status = "Belum Tuntas";
            }
            $row[]  = $status;
            $aksi   = "<div align='center'> <button class='btn btn-icon btn-icon-circle btn-sun btn-icon-style-2 detail-hasil-mon-pegawai' data-toggle='modal' data-id=".$s['id_tasklist']."><span class='btn-icon-wrap'><i class='icon-info'></i></span></button></div>";
            $row[]  = $aksi;

            $data[] = $row;
        }

        $output = array( "draw"             => $_POST['draw'],
                         "recordsTotal"     => $this->M_data->count_all($id_jenis),
                         "recordsFiltered"  => $this->M_data->count_filtered($id_jenis),   
                         "data"             => $data,
                        );

        echo json_encode($output);
    }

    public function tambah_tasklist()
    {
        $tasklist = $this->input->post('tasklist');
        $penerima_tugas = $this->input->post('penerima_tugas');
        $pemberi_tugas = $this->input->post('pemberi_tugas');
        $jenis_task = $this->input->post('jenis_task');
        $expire_date    = $this->input->post('expire_date');
        $keterangan     = $this->input->post('keterangan');
        
        $data       = [ 'penerima_tugas'   => $penerima_tugas,
                        'pemberi_tugas'    => $pemberi_tugas,
                        'expire_date'      => $expire_date,
                        'keterangan'       => $keterangan,
                        'jenis_task'       => $jenis_task,
                        'tasklist'         => $tasklist,
                        'status'           => 0
                    ];
        
        $hasil      = $this->M_master->input_data('tasklist', $data);

        echo json_encode($hasil);
    }

    // menampilkan form detail mon pegawai
    public function form_detail_mon_pegawai()
    {
        $id_task = $this->input->post('id_tasklist');

        $data['data_hsl_mon']   = $this->M_data->get_data_task_detail($id_task)->row_array();
        $id_jenis  = $this->input->post('id_jenis');
        
        $data['data_hsl_task']  = $this->M_data->get_data_hasil_task($id_task)->result_array();

        $this->load->view('data/task_tbi/V_detail_mon_pegawai', $data);
        
        
    }

    public function setujuiHasil($id_hasil)
    {
        $status = 1;
        $this->M_data->updateHasilTask($status,$id_hasil);
        redirect('data/task_tbi');
        
    }

    /**********************************************************************************/

    /*                              MONITORING MESIN                                  */

    /**********************************************************************************/

    // menampilkan halaman monitoring mesin
    public function mon_sewa_tempat()
    {
        $data   = [ 'judul'         => 'Monitoring Sewa Tempat',
                    'sewa_tempat'   => 'active'
                  ];

        $this->template->load('template', 'data/mon_sewa_tempat/V_mon_sewa_tempat', $data);
    }

    // menampilkan data status due date
    public function tampil_data_status($status)
    {
        $data_due_date = $this->M_data->cari_data('mesin', array('status' => $status))->result_array();

        $no=1;
        foreach ($data_due_date as $d) {
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no++."</div>";
            $tbody[]    = $d['nama_mesin'];
            $tbody[]    = $d['alamat'];
            $tbody[]    = tgl_indo($d['tgl_jatuh_tempo']);
            $aksi       = "<div align='center'> <button class='btn btn-icon btn-icon-circle btn-sun btn-icon-style-2 detail-sewa-tempat' data-toggle='modal' data-id=".$d['id_mesin']."><span class='btn-icon-wrap'><i class='icon-info'></i></span></button></div>";
            $tbody[]    = $aksi;
            $data[]     = $tbody;
        }

        if ($data_due_date) {
            echo json_encode(array('data' => $data));     
        } else {
            echo json_encode(array('data' => 0));
        }
        
    }

    // menampilkan form detail sewa tempat mesin
    public function form_detail_sewa_tempat()
    {
        $id_mesin   = $this->input->post('id_mesin');

        $data['d_mesin'] = $this->M_data->cari_data('mesin', array('id_mesin' => $id_mesin))->row_array();

        $this->load->view('data/mon_sewa_tempat/V_detail_mon_sewa_tempat', $data);
    }

    /**********************************************************************************/

    /*                                  DATA REMINDER                                 */

    /**********************************************************************************/

    // menampilkan halaman data reminder
    public function reminder()
    {
        $data   = [ 'judul'     => 'Data Reminder',
                    'reminder'  => 'active',
                    'd_mesin'   => $this->M_data->get_data_mesin_sudah()->result_array(),
                    'd_jenis'   => $this->M_data->get_data('jenis_reminder')->result_array()
                  ];    

        $this->template->load('template', 'data/reminder/V_reminder', $data);
    }

    // menampilkan list data reminder
    public function tampil_reminder()
    {
        $data_reminder = $this->M_data->get_data_reminder();

        $no = 1;
        foreach ($data_reminder as $r) {
            if ($r['status'] == 0) {
                $status = 'Tidak Ada Monitoring';
            } else {
                $status = 'Ada Monitoring';
            }

            $tbody = array();
            
            $tbody[]    = "<div align='center'>".$no++."</div>";
            $tbody[]    = $r['nama_karyawan'];
            $tbody[]    = $r['nama_mesin'];
            $tbody[]    = "Level ".$r['level'];
            $tbody[]    = $status;
            $aksi       = "<div align='center'> <button class='btn btn-icon btn-icon-circle btn-sun btn-icon-style-2 ubah-reminder' data-id=".$r['id_reminder']."><span class='btn-icon-wrap'><i class='icon-pencil'></i></span></button>".' '."<button class='btn btn-icon btn-icon-circle btn-danger btn-icon-style-2 hapus-reminder' id='id' data-id=".$r['id_reminder']."><span class='btn-icon-wrap'><i class='icon-trash'></i></span></button> </div>"; 
            $tbody[]    = $aksi;
            $data[]     = $tbody;            
        }

        if ($data_reminder) {
            echo json_encode(array('data'   => $data));
        } else {
            echo json_encode(array('data'   => 0));
        }
        
    }

    // proses tambah 
    public function tambah_reminder()
    {
        $id_mesin        = $this->input->post('id_mesin');
        $id_jns_reminder = $this->input->post('id_jenis_reminder');

        $hasil = $this->M_data->get_id_kelola_mesin($id_mesin)->row_array();

        $id_kelola_mesin = $hasil['id_kelola_mesin'];

        $data = ['id_kelola_mesin'      => $id_kelola_mesin,
                 'id_jenis_reminder'    => $id_jns_reminder,
                 'status'               => 0
                ];

        $hasil = $this->M_data->cari_data('reminder', array('id_kelola_mesin' => $id_kelola_mesin, 'id_jenis_reminder' => $id_jns_reminder))->num_rows();

        if ($hasil == 0) {

            $result = $this->M_data->input_data('reminder', $data);
            echo json_encode(array('hasil' => $result, 'cek' => 1));

        } else {
            echo json_encode(array('cek' => 0));
        }
        

        
        
    }

    // menampilkan halaman form reminder
    public function form_edit_reminder()
    {
        $id_reminder = $this->input->post('id_reminder');

        $id_kelola_mesin = $this->M_data->cari_data('reminder', array('id_reminder' => $id_reminder))->row_array();

        $id_mesin    = $this->M_data->cari_data('kelola_mesin', array('id_kelola_mesin' => $id_kelola_mesin['id_kelola_mesin']))->row_array();

        $data = ['d_mesin'   => $this->M_data->get_data('mesin')->result_array(),
                 'd_jenis'   => $this->M_data->get_data('jenis_reminder')->result_array(),
                 'd_reminder'=> $this->M_data->cari_data('reminder', array('id_reminder' => $id_reminder))->row_array(),
                 'id_mesin'  => $id_mesin['id_mesin']  
                ];

        $this->load->view('data/reminder/V_edit_reminder', $data);
    }

    // proses ubah reminder
    public function ubah_reminder()
    {
        $id_mesin           = $this->input->post('id_mesin');
        $id_jenis_reminder  = $this->input->post('id_jenis_reminder');
        $id_reminder        = $this->input->post('id_reminder');
        
        $id_kelola_mesin = $this->M_data->cari_data('reminder', array('id_reminder' => $id_reminder))->row_array();

        $data       = ['id_jenis_reminder'    => $id_jenis_reminder];

        $data_2     = ['id_mesin'   => $id_mesin];
        
        $where_2    = ['id_kelola_mesin'    => $id_kelola_mesin['id_kelola_mesin']];

        $where      = ['id_reminder'    => $id_reminder];

        $this->M_data->ubah_data('reminder', $data, $where);
        
        $hasil = $this->M_data->ubah_data('kelola_mesin', $data_2, $where_2);

        echo json_encode($hasil);
        
    }

    // proses hapus
    public function hapus_reminder()
    {
        $where = ['id_reminder' => $this->input->post('id_reminder')];

        $hasil = $this->M_data->hapus_data('reminder', $where);

        echo json_encode($hasil);
    }


    public function tes()
    {
        $latitude   = '-6.8938104';
        $longitude  = '107.5616196';

        $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&key=AIzaSyDx0U_l7WLDkzQ72SbpfaYIWCALbIa60wk'.'&sensor=true'); 
        $output = json_decode($geocodeFromLatLong);
        $status = $output->status;
        
        echo $jalan     = ($status=="OK")?$output->results[0]->address_components[1]->long_name:'';
        echo $nomer     = ($status=="OK")?$output->results[0]->address_components[0]->long_name:'';
        echo $desa      = ($status=="OK")?$output->results[0]->address_components[2]->long_name:'';
        echo $kecamatan = ($status=="OK")?$output->results[0]->address_components[3]->long_name:'';
        echo $kota      = ($status=="OK")?$output->results[0]->address_components[4]->long_name:'';
        echo $provinsi  = ($status=="OK")?$output->results[0]->address_components[5]->long_name:'';
        echo $negara    = ($status=="OK")?$output->results[0]->address_components[6]->long_name:'';
        echo $kode_pos  = ($status=="OK")?$output->results[0]->address_components[7]->long_name:'';

        echo '<pre>';
        print_r($output);
        echo '</pre>';

        //Get address from json data

        $api = 'AIzaSyAo4v-p3cnYpf5rjf-KQDHIIZqbW_f0vmo';

        $a = 'AIzaSyCX0BerEOaK59srKbH-FnzzRYM1xTzeEts';
        
        
    }


    
}

/* End of file Data.php */
