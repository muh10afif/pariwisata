<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class M_auth extends CI_Model
{

    public function login($username)
    {
        $this->db->select('*');
        $this->db->from('m_user');
        $this->db->where('username', $username);

        return $this->db->get();
    }

    public function register($data)
    {
        return  $this->db->insert('users', $data);
    }

    public function get_data_user()
    {
        return $this->db->get('users')->result();
    }

    public function get_users_byid($id)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = array(
                  'id' => $row->id,
                'username' => $row->username,
                'jabatan' => $row->jabatan,
                );
                return $data;
            }
        }
    }

    public function update_users($id, $arr)
    {
        $this->db->where('id', $id);
        $query =  $this->db->update('users', $arr);
  
        return $query;
    }

    public function hapus($id)
    {
        $this->db->where('id', $id);
        return  $this->db->delete('users');
    }

    public function get_guru()
    {
        return $this->db->get('guru')->result();
    }

    public function get_nilai_siswa($nisn)
    {
        $query = $this->db->query("SELECT nisn,nama_siswa,k.nama_kelas from siswa as s JOIN ruang_kelas as k ON s.id_kelas = k.id  where nisn ='".$nisn."'");
        return $query->row();
    }

    public function nilai_ipa($nisn)
    {
        $siswa = $this->db->get_where('siswa', array('nisn' => $nisn))->row();
        $n_ipa = $this->db->query("Select SUM(nilai_1) as n1, SUM(nilai_2) as n2, SUM(nilai_3) as n3,SUM(nilai_4) as n4 FROM nilai as n JOIN siswa as s ON s.id = n.id_siswa WHERE s.id = '".$siswa->id."' AND id_mapel = '1' AND id_ki = '1';")->row();
        return $n_ipa;
    }

    public function nilai_mtk($nisn)
    {
        $siswa = $this->db->get_where('siswa', array('nisn' => $nisn))->row();
        $n_ipa = $this->db->query("Select SUM(nilai_1) as n1, SUM(nilai_2) as n2, SUM(nilai_3) as n3,SUM(nilai_4) as n4 FROM nilai as n JOIN siswa as s ON s.id = n.id_siswa WHERE s.id = '".$siswa->id."' AND id_mapel = '2' AND id_ki = '1';")->row();
        return $n_ipa;
    }

    public function nilai_bi($nisn)
    {
        $siswa = $this->db->get_where('siswa', array('nisn' => $nisn))->row();
        $n_ipa = $this->db->query("Select SUM(nilai_1) as n1, SUM(nilai_2) as n2, SUM(nilai_3) as n3,SUM(nilai_4) as n4 FROM nilai as n JOIN siswa as s ON s.id = n.id_siswa WHERE s.id = '".$siswa->id."' AND id_mapel = '3' AND id_ki = '1';")->row();
        return $n_ipa;
    }

    public function nilai_pkn($nisn)
    {
        $siswa = $this->db->get_where('siswa', array('nisn' => $nisn))->row();
        $n_ipa = $this->db->query("Select SUM(nilai_1) as n1, SUM(nilai_2) as n2, SUM(nilai_3) as n3,SUM(nilai_4) as n4 FROM nilai as n JOIN siswa as s ON s.id = n.id_siswa WHERE s.id = '".$siswa->id."' AND id_mapel = '4' AND id_ki = '1';")->row();
        return $n_ipa;
    }
}

/* End of file M_auth.php */
/* Location: ./application/models/M_auth.php */
