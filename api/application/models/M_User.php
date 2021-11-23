<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_User extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function Login($username, $password)
    {
		$query = "SELECT a.id_user, a.password,a.foto,a.id_dtw as id_usr_dtw, a.id_hotel as id_usr_hotel,b.*, e.nama_dtw, e.alamat as alamat_dtw, f.nama_hotel, f.alamat as alamat_hotel FROM m_user a LEFT JOIN dtw e ON (e.id_dtw = a.id_dtw) LEFT JOIN hotel f ON (f.id_hotel = a.id_hotel) LEFT JOIN petugas b ON (b.id_petugas = a.id_pegawai) LEFT JOIN penempatan_dtw c ON (c.id_pegawai = b.id_petugas) LEFT JOIN penempatan_hotel d ON (d.id_pegawai = b.id_petugas) WHERE a.username = '$username'";
		$value = $this->db->query($query)->result_array();
	 	$result = array();
		
		foreach($value as $row)
		{
			if ($row['password'] != null)
			{
				if (password_verify($password, $row['password']))
				{
					$result[] = array
					(
						'id_user' => $row['id_user'],
						'id_petugas' => $row['id_petugas'],
						'id_dtw' => $row['id_usr_dtw'],
                        'id_hotel' => $row['id_usr_hotel'],
                        'id_usr_dtw' => $row['id_usr_dtw'],
                        'id_usr_hotel' => $row['id_usr_hotel'],
						'status' => $row['status'],
                        'nik' => $row['nik'],
                        'foto' => $row['foto'],
						'email' => $row['email'],
						'alamat' => $row['alamat'],
                        'no_telp' => $row['no_telp'],
                        'nama_petugas' => $row['nama_petugas'],
                        'nama_dtw' => $row['nama_dtw'],
                        'nama_hotel' => $row['nama_hotel'],
                        'alamat_dtw' => $row['alamat_dtw'],
                        'alamat_hotel' => $row['alamat_hotel']
					);
				}
			}
		}	
	
		return $result;
	}
	
	function UpdateFoto($data)
	{
		$ok = "Nope!";
        
        try
        {
            $id_karyawan = $data['id'];
            $foto = $data['name'];

            $this->db->query("UPDATE m_user SET foto='$foto' WHERE id_user = $id_karyawan");
            if ($this->db->affected_rows())
            {
                $ok = "Updated!";
            }   
            else
            {
                $ok = "Nope! Failed to Update!";
            }
        }
        catch (Exception $e) 
        {
            $ok = "Nope! Failed to Update!";
        }

        return $foto;   
	}

	function ChangePassword($data)
	{
		$ok = "Nope!";
        
        try
        {
			$id_pengguna = $data['id'];
            $options = ['cost' => 10,];
            $pass = $data['name'];
			$password = password_hash($pass, PASSWORD_DEFAULT, $options);

            $this->db->query("UPDATE pengguna SET sha='$password' WHERE id_pengguna = $id_pengguna");
            if ($this->db->affected_rows())
            {
                $ok = "Updated!";
            }   
            else
            {
                $ok = "Nope! Failed to Update!";
            }
        }
        catch (Exception $e) 
        {
            $ok = "Nope! Failed to Update!";
        }

        return $ok;   
	}
}
