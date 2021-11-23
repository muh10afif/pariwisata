<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_login extends CI_Model {

    public function cek_username($username)
    {
        $this->db->from('m_user a');
        
        $this->db->where('a.username', $username);

        return $this->db->get();
    }

}

/* End of file M_login.php */
