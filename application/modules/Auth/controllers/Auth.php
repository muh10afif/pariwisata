<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Auth extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
         $this->load->library('session');
        $this->load->model('M_auth');
    }

    public function index()
    {
        $session = $this->session->userdata('status');

        if ($session == '') {
            $this->load->view('login');
        } else {
            redirect('Dashboard');
        }
    }

    // proses login sweetalert
    public function login()
    {
        $u = $this->input->post('username', TRUE);
		$p = $this->input->post('password', TRUE);

		$username = trim(htmlspecialchars($u, ENT_QUOTES)); 
		$password = trim(htmlspecialchars($p, ENT_QUOTES)); 

		$cek_username = $this->M_auth->login($username);

		if ($cek_username->num_rows() != 0) {
            $data   = $cek_username->row_array();
            $data_2 = $cek_username->row();
			
			// cek password dengan verify
			if (password_verify($password,$data['password'])) {

                $id_pegawai = $data['id_pegawai'];
                $id_dtw     = $data['id_dtw'];
                $id_hotel   = $data['id_hotel'];
                $id_kota    = $data['id_kota'];

                if ($id_pegawai == 0 && $id_dtw == 0 && $id_hotel == 0 && $id_kota == 0) {
                    $level = "admin";
                } elseif ($id_pegawai == 0 && $id_dtw != 0 && $id_hotel == 0 && $id_kota == 0) {
                    $level = "dtw";
                } elseif ($id_pegawai == 0 && $id_dtw == 0 && $id_hotel != 0 && $id_kota == 0) {
                    $level = "hotel";
                } elseif ($id_pegawai == 0 && $id_dtw == 0 && $id_hotel == 0 && $id_kota != 0) {
                    $level = "kota";
                } elseif ($id_pegawai != 0 && $id_dtw == 0 && $id_hotel == 0 && $id_kota != 0) {
                    $level = "petugas";
                }
			
				$data_session = array(
					'nama' 	    => $data['username'],
					'status'    => "Loged in",
                    'level'	    => $level,
                    'userdata'  => $data_2,
                    'masuk'     => 'pariwisata'
				);
				$this->session->set_userdata($data_session);

				// berhasil login
				echo json_encode(['hasil' => 2]);

			} else {
				// password salah
				echo json_encode(['hasil'  => 1]);
			}

		} else {
			// username tidak ditemukan
			echo json_encode(['hasil'  => 0]);
		}
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('Auth');
    }

    public function tes()
    {
        echo password_hash('11', PASSWORD_DEFAULT);
    }
}

/* End of file  */
/* Location: ./application/controllers/ */
