<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class M_penempatan extends CI_Model
{

    // 30-12-2019

    // menampilkan data penempatan dtw 
    public function get_penempatan($tabel, $id_kota, $id_pegawai)
    {
        $this->db->select("p.status, t.nama_petugas, d.nama_$tabel, id_penempatan_$tabel, d.id_$tabel, d.alamat");
        
        $this->db->from("penempatan_$tabel as p");
        $this->db->join("$tabel as d", "d.id_$tabel = p.id_$tabel", 'inner');
        $this->db->join('petugas as t', 't.id_petugas = p.id_pegawai', 'inner');
        
        $this->db->where('d.id_kota', $id_kota);
        // $this->db->where('p.status', 1);

        if ($id_pegawai != '') {
            $this->db->where('t.id_petugas', $id_pegawai);
        }
        
        return $this->db->get();
        
    }

    // menampilkan data penempatan tambah
    public function get_penempatan_tambah($tabel, $id_kota)
    {
        $this->db->select('*');
        $this->db->from("penempatan_$tabel as p");
        $this->db->join("$tabel as d", "d.id_$tabel = p.id_$tabel", 'inner');
        $this->db->where('d.id_kota', $id_kota);
        $this->db->where('p.status', 1);
        
        $a  = $this->db->get()->result();
        $ar = array();
        foreach ($a as $b) {
            if ($tabel == 'dtw') {
                $id = $b->id_dtw;
            } else {
                $id = $b->id_hotel;
            }

            $ar[] = $id;
        }
        $im     = implode(",", $ar);
        $hasil  = explode(",", $im);

        $this->db->select("*");
        $this->db->from("$tabel");
        
        $this->db->where('id_kota', $id_kota);
        // $this->db->where('p.status', 1);

        if ($hasil[0] != "") {
            $this->db->where_not_in("id_$tabel", $hasil);
        }

        return $this->db->get();
    }

    // ubah data
    public function ubah_data($tabel, $data, $where)
    {
        $this->db->update($tabel, $data, $where);
    }

    // cari data
    public function cari_data($tabel, $where)
    {
        return $this->db->get_where($tabel, $where);
    }

    // input data batch
    public function input_data_batch($tabel, $data)
    {
        $this->db->insert_batch($tabel, $data);
    }

    // mencari list untuk select box list dtw / hotel
    public function get_list_select_penempatan($id_kota, $nm_tabel, $penempatan)
    {
        $this->db->select('*');
        $this->db->from("$nm_tabel as n");
        $this->db->join("$penempatan as p", "p.id_$penempatan = n.id_$penempatan", 'inner');
        $this->db->where('p.id_kota', $id_kota);
        $this->db->where('n.status', 1);
        
        $a  = $this->db->get()->result();
        $ar = array();
        foreach ($a as $b) {
            if ($penempatan == 'dtw') {
                $id = $b->id_dtw;
            } else {
                $id = $b->id_hotel;
            }

            $ar[] = $id;
        }
        $im     = implode(",", $ar);
        $hasil  = explode(",", $im);

        $this->db->from("$penempatan as p");
        $this->db->where('p.id_kota', $id_kota);
        if ($hasil[0] != "") {
            $this->db->where_not_in("p.id_$penempatan", $hasil);
        }

        return $this->db->get();
        
    }

    // cek penempatan
    public function cari_data_penempatan($nm_tabel, $penempatan, $id_hotel_dtw)
    {
        $this->db->from("$nm_tabel as t");
        $this->db->where("id_$penempatan", $id_hotel_dtw);
        $this->db->where('status', 1);
        
        return $this->db->get();
        
    }

    // Akhir 30-12-2019

    public function get_petugas($kota)
    {
        $this->db->select('*');
        $this->db->from('petugas');
        $this->db->join('m_user', 'm_user.id_pegawai = petugas.id_petugas', 'inner');
        $this->db->where('m_user.id_kota', $kota);
                
        return $this->db->get()->result();
    }

    public function get_dtw($kota)
    {
        $this->db->select('*');
        $this->db->from('dtw');
        $this->db->where('dtw.id_kota', $kota);
        
        return $this->db->get()->result();
    }

    public function get_hotel($kota)
    {
        $this->db->select('*');
        $this->db->from('hotel');
        $this->db->where('hotel.id_kota', $kota);
        
        return $this->db->get()->result();
    }

    public function get_kota()
    {
        return $this->db->get('kota')->result();
        
    }

    public function get_p_dtw($kota)
    {
        $this->db->select('pdtw.id_dtw,petugas.nama_petugas,kota.nama_kota,dtw.nama_dtw,dtw.status');
        $this->db->from('penempatan_dtw as pdtw');
        $this->db->join('petugas', 'petugas.id_petugas = pdtw.id_pegawai');
        $this->db->join('dtw', 'dtw.id_dtw = pdtw.id_dtw');
        $this->db->join('kota', 'kota.id_kota= dtw.id_kota');
        $this->db->where('kota.id_kota', $kota);
        

        return $this->db->get()->result();
    }

    public function get_p_hotel($kota)
    {
        $this->db->select('photel.id_hotel,petugas.nama_petugas,kota.nama_kota,hotel.nama_hotel,hotel.status');
        $this->db->from('penempatan_hotel as photel');
        $this->db->join('petugas', 'petugas.id_petugas = photel.id_pegawai');
        $this->db->join('hotel', 'hotel.id_hotel = photel.id_hotel');
        $this->db->join('kota', 'kota.id_kota= hotel.id_kota');
        $this->db->where('kota.id_kota', $kota);
        

        return $this->db->get()->result();
    }

    // public function simpan($arr)
    // {
    //     return $this->db->insert('petugas', $arr);
    // }

    // public function hapus($id)
    // {
    //     $this->db->where('id_petugas', $id);
    //     return $this->db->delete('petugas');
    // }
    // public function edit($id)
    // {
    //     $this->db->where('id_petugas', $id);
    //     return $this->db->get('petugas')->row();
    // }

    // public function update($id, $arr)
    // {
    //     $this->db->where('id_petugas', $id);
    //     return $this->db->update('petugas', $arr);
    // }
}
