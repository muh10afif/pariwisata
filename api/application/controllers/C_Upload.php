<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/API_Controller.php';
class C_Upload extends API_Controller
{
	function __construct($config = 'rest') {
        parent::__construct($config);
        date_default_timezone_set("Asia/Jakarta");//set you countary name from below timezone list
        $this->load->model('M_Upload');
        $this->load->database();
    }

    public function PostDokumen()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            'requireAuthorization' => true,
        ]);
        
        $dataInput = json_decode(file_get_contents('php://input'), true);

        //define('UPLOAD_DIR', 'images/foto_dokumen/berita_acara_ots/');
        define('UPLOAD_DIR', 'images/');

        $name_file = '-';
        if($dataInput['Id_jenis_dok'] == 1)
            $name_file = $dataInput['Nama_debitur'] . '-(' . date('Y-m-d') . ')-' . 'Berita_Acara_OTS-' . uniqid() . '.png';
        else if($dataInput['Id_jenis_dok'] == 2)
            $name_file = $dataInput['Nama_debitur'] . '-(' . date('Y-m-d') . ')-' . 'Dokumen_Agunan-' . uniqid() . '.png';
        else if($dataInput['Id_jenis_dok'] == 3)
            $name_file = $dataInput['Nama_debitur'] . '-(' . date('Y-m-d') . ')-' . 'Bukti_Pembayaran-' . uniqid() . '.png';
        else if($dataInput['Id_jenis_dok'] == 4)
            $name_file = $dataInput['Nama_debitur'] . '-(' . date('Y-m-d') . ')-' . 'Somasi-' . uniqid() . '.png';
        else if($dataInput['Id_jenis_dok'] == 5)
            $name_file = $dataInput['Nama_debitur'] . '-(' . date('Y-m-d') . ')-' . 'Surat_Penunjukan-' . uniqid() . '.png';
        else if($dataInput['Id_jenis_dok'] == 6)
            $name_file = $dataInput['Nama_debitur'] . '-(' . date('Y-m-d') . ')-' . 'Aset Lainnya-' . uniqid() . '.png';
        else
            $name_file = $dataInput['Id_jenis_dok'];
        
        $image_base64 = base64_decode($dataInput['Foto_dokumen']);
        $file = UPLOAD_DIR . $name_file;
        file_put_contents($file, $image_base64);
        $dataInput['Foto_dokumen_url'] = $name_file;

        $dataInput['Add_time'] = date("Y-m-d H:i:s");

        $hasil = $this->M_Upload->PostDokumen($dataInput);

        echo json_encode($hasil);
    }

    public function PostAgunan()
    {
        /*try
        {
            $user_data = $this->_apiConfig([
                'methods' => ['POST'],
                'requireAuthorization' => true,
            ]);

            header('Content-Type: application/json');

            $config['max_size']=2048;
            $config['allowed_types']="jpg|jpeg|png|bmp";
            $config['remove_spaces']=TRUE;
            $config['overwrite']=TRUE;
            $config['upload_path']=FCPATH.'images/foto_tampak_depan';
            $data_input = json_decode(file_get_contents('php://input'), true);
            $this->load->library('upload');
            $this->upload->initialize($config);
            $foto_upload = $data_input['Foto_tampak_depan'];
            $this->upload->do_upload($foto_upload);
            $data = array('upload_data' => $this->upload->data());
            $filename=$data['upload_data']['file_name'];
            $data_input['Foto_tampak_depan_url'] = $filename;

            $config['max_size']=2048;
            $config['allowed_types']="jpg|jpeg|png|bmp";
            $config['remove_spaces']=TRUE;
            $config['overwrite']=TRUE;
            $config['upload_path']=FCPATH.'images/foto_tampak_belakang';
            $data_input = json_decode(file_get_contents('php://input'), true);
            $this->load->library('upload');
            $this->upload->initialize($config);
            $foto_upload = $data_input['Foto_tampak_belakang'];
            $this->upload->do_upload($foto_upload);
            $data = array('upload_data' => $this->upload->data());
            $filename=$data['upload_data']['file_name'];
            $data_input['Foto_tampak_belakang_url'] = $filename;

            $config['max_size']=2048;
            $config['allowed_types']="jpg|jpeg|png|bmp";
            $config['remove_spaces']=TRUE;
            $config['overwrite']=TRUE;
            $config['upload_path']=FCPATH.'images/foto_tampak_kanan';
            $data_input = json_decode(file_get_contents('php://input'), true);
            $this->load->library('upload');
            $this->upload->initialize($config);
            $foto_upload = $data_input['Foto_tampak_kanan'];
            $this->upload->do_upload($foto_upload);
            $data = array('upload_data' => $this->upload->data());
            $filename=$data['upload_data']['file_name'];
            $data_input['Foto_tampak_kanan_url'] = $filename;

            $config['max_size']=2048;
            $config['allowed_types']="jpg|jpeg|png|bmp";
            $config['remove_spaces']=TRUE;
            $config['overwrite']=TRUE;
            $config['upload_path']=FCPATH.'images/foto_tampak_kiri';
            $data_input = json_decode(file_get_contents('php://input'), true);
            $this->load->library('upload');
            $this->upload->initialize($config);
            $foto_upload = $data_input['Foto_tampak_kiri'];
            $this->upload->do_upload($foto_upload);
            $data = array('upload_data' => $this->upload->data());
            $filename=$data['upload_data']['file_name'];
            $data_input['Foto_tampak_kiri_url'] = $filename;

            $config['max_size']=2048;
            $config['allowed_types']="jpg|jpeg|png|bmp";
            $config['remove_spaces']=TRUE;
            $config['overwrite']=TRUE;
            $config['upload_path']=FCPATH.'images/foto_akses_jalan';
            $data_input = json_decode(file_get_contents('php://input'), true);
            $this->load->library('upload');
            $this->upload->initialize($config);
            $foto_upload = $data_input['Foto_akses_jalan'];
            $this->upload->do_upload($foto_upload);
            $data = array('upload_data' => $this->upload->data());
            $filename=$data['upload_data']['file_name'];
            $data_input['Foto_akses_jalan_url'] = $filename;

            
            $hasil = $this->M_Upload->PostFotoAgunan($data_input);

            echo json_encode($hasil);
        }
        catch( Exception $e)
        {
            log_message( 'error', $e->getMessage( ) . ' in ' . $e->getFile() . ':' . $e->getLine() );
        }*/

        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            'requireAuthorization' => true,
        ]);
        
        $dataInput = json_decode(file_get_contents('php://input'), true);

        define('UPLOAD_DIR', 'images/');
        
        //FOTO AGUNAN TAMPAK KANAN
        $fotoKanan = $dataInput['Foto_tampak_kanan'];
        if($fotoKanan != null)
        {
            foreach($fotoKanan as $kanan)
            {
                $image_base64 = base64_decode($kanan);
                $name_file = $dataInput['Nama_debitur'] . '-(' . date('Y-m-d') . ')-' . 'Tampak_Kanan-' . uniqid() . '.png';
                $file = UPLOAD_DIR . $name_file;
                file_put_contents($file, $image_base64);
                array_push($dataInput['Foto_tampak_kanan_url'], $name_file);
                //$dataInput['Foto_tampak_kanan_url'] = array($name_file);
            }
        }

        //FOTO AGUNAN TAMPAK KIRI
        $fotoKiri = $dataInput['Foto_tampak_kiri'];
        if($fotoKiri != null)
        {
            foreach($fotoKiri as $kiri)
            {
                $image_base64 = base64_decode($kiri);
                $name_file = $dataInput['Nama_debitur'] . '-(' . date('Y-m-d') . ')-' . 'Tampak_Kiri-' . uniqid() . '.png';
                $file = UPLOAD_DIR . $name_file;
                file_put_contents($file, $image_base64);
                array_push($dataInput['Foto_tampak_kiri_url'], $name_file);
                //$dataInput['Foto_tampak_kiri_url'] = array($name_file);
            }
        }

        //FOTO AGUNAN TAMPAK DEPAN
        $fotoDepan = $dataInput['Foto_tampak_depan'];
        if($fotoDepan != null)
        {
            foreach($fotoDepan as $depan)
            {
                $image_base64 = base64_decode($depan);
                $name_file = $dataInput['Nama_debitur'] . '-(' . date('Y-m-d') . ')-' . 'Tampak_Depan-' . uniqid() . '.png';
                $file = UPLOAD_DIR . $name_file;
                file_put_contents($file, $image_base64);
                array_push($dataInput['Foto_tampak_depan_url'], $name_file);
                //$dataInput['Foto_tampak_depan_url'] = array($name_file);
            }
        }

        //FOTO AGUNAN TAMPAK BELAKANG
        $fotoBelakang = $dataInput['Foto_tampak_belakang'];
        if($fotoBelakang != null)
        {
            foreach($fotoBelakang as $belakang)
            {
                $image_base64 = base64_decode($belakang);
                $name_file = $dataInput['Nama_debitur'] . '-(' . date('Y-m-d') . ')-' . 'Tampak_Belakang-' . uniqid() . '.png';
                $file = UPLOAD_DIR . $name_file;
                file_put_contents($file, $image_base64);
                array_push($dataInput['Foto_tampak_belakang_url'], $name_file);
                //$dataInput['Foto_tampak_belakang_url'] = array($name_file);
            }
        }

        //FOTO AGUNAN AKSES JALAN
        //define('UPLOAD_DIR', 'images/' . $dataInput['Nama_debitur'] . '/akses_jalan/');
        $fotoAksesJalan = $dataInput['Foto_akses_jalan'];
        if($fotoAksesJalan != null)
        {
            foreach($fotoAksesJalan as $akses_jalan)
            {
                $image_base64 = base64_decode($akses_jalan);
                $name_file = $dataInput['Nama_debitur'] . '-(' . date('Y-m-d') . ')-' . 'Akses_Jalan-' . uniqid() . '.png';
                $file = UPLOAD_DIR . $name_file;
                file_put_contents($file, $image_base64);
                array_push($dataInput['Foto_akses_jalan_url'], $name_file);
                //$dataInput['Foto_akses_jalan_url'] = array($name_file);
            }
        }

        //FOTO AGUNAN MESIN || LAIN-LAIN || KENDARAAN 
        //define('UPLOAD_DIR', 'images/' . $dataInput['Nama_debitur'] . '/akses_jalan/');
        // $fotoLainLain = $dataInput['Foto_lain_lain'];
        // if($fotoLainLain != null)
        // {
        //     $nama_jenis_asset = $dataInput['Nama_jenis_asset'];
        //     foreach($fotoLainLain as $lain_lain)
        //     {
        //         $image_base64 = base64_decode($lain_lain);
        //         $name_file = $dataInput['Nama_debitur'] . '-(' . date('Y-m-d') . ')-' . $nama_jenis_asset . '-' . uniqid() . '.png';
        //         $file = UPLOAD_DIR . $name_file;
        //         file_put_contents($file, $image_base64);
        //         array_push($dataInput['Foto_lain_lain_url'], $name_file);
        //     }
        // }

        $dataInput['Add_time'] = date("Y-m-d H:i:s");

        $hasil = $this->M_Upload->save_agunan($dataInput);

        echo json_encode($hasil);

    }
}