<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cek_login_lib
{
    public function belum_login()
    {
    	$_this =& get_instance();
    	if ($_this->session->userdata('masuk') != 'pariwisata') {
    		redirect('auth','refresh');
    	}
    }

    public function sudah_login()
    {
    	$_this =& get_instance();
    	if ($_this->session->userdata('masuk') == 'pariwisata') {
    		redirect('dashboard','refresh');
    	}
    }


}

/* End of file Cek_login_lib.php */
