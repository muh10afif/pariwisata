<?php if (! defined('BASEPATH')) {
        exit('No direct script access allowed');
    }
    
    class M_dtw extends CI_Model
    {
        public function cari_data($tabel, $where)
        {
            return $this->db->get_where($tabel, $where);
        }

        public function cari_data_o($tabel, $where, $order)
        {
            $this->db->order_by($order, 'asc');
            
            return $this->db->get_where($tabel, $where);
        }

        public function get_data($tabel, $order)
        {
            $this->db->order_by($order, 'asc');
            
            return $this->db->get($tabel);          
        }

        public function get_dtw($id_dtw)
        {
            $this->db->select('*');
            $this->db->from('dtw');
            $this->db->where('id_dtw', $id_dtw);
            
            return $this->db->get()->result();
        }

        public function get_dtw_petugas($id_petugas)
        {
            $this->db->select('*');
            $this->db->from('penempatan_dtw a');
            $this->db->join('dtw b', 'b.id_dtw = a.id_dtw', 'inner');
            $this->db->where('a.id_pegawai', $id_petugas);
            return $this->db->get()->result();
        }

        public function get_dtw_petugas_2($id_petugas)
        {
            $this->db->select('*');
            $this->db->from('penempatan_dtw a');
            $this->db->join('dtw b', 'b.id_dtw = a.id_dtw', 'inner');
            $this->db->where('a.id_pegawai', $id_petugas);
            $this->db->where('a.status', 1);
             
            return $this->db->get();
        }

        public function cek_wisnus($per)
        {
            $this->db->get_where('rekap_wisnus_dtw ', array('rekap_wisnus_dtw.periode'=> $per))->num_rows();
           if($this->db->affected_rows() > 0)
            {return true;
            }
            else{
                return false;
            }
        }

        public function cek_wisnusman_petugas($tabel, $periode, $per_awal, $id_petugas, $id_dtw)
        {
            $this->db->select('*');
            $this->db->from('penempatan_dtw a');
            $this->db->join("$tabel b", 'b.id_dtw = a.id_dtw', 'inner');
            $this->db->where('a.id_pegawai', $id_petugas);
            $this->db->where('b.status', 1);
            $this->db->where('b.id_dtw', $id_dtw);
            
            if ($periode == $per_awal) {
                $this->db->where('b.periode', $per_awal);
               
            } else {
                $this->db->where('b.periode', $periode);
            }

            return $this->db->get()->num_rows();
        }

        public function cek_wisnus_petugas($per, $id_petugas)
        {
            $this->db->select('*');
            $this->db->from('penempatan_dtw a');
            $this->db->join('rekap_wisnus_dtw b', 'b.id_dtw = a.id_dtw', 'inner');
            $this->db->where('a.id_pegawai', $id_petugas);
            return $this->db->get()->num_rows();
        }
        
        public function cek_wisman_petugas($per, $id_petugas)
        {
            $this->db->select('*');
            $this->db->from('penempatan_dtw a');
            $this->db->join('rekap_wisman_dtw b', 'b.id_dtw = a.id_dtw', 'inner');
            $this->db->where('a.id_pegawai', $id_petugas);
            return $this->db->get()->num_rows();
        }

        public function cek_wisman($per)
        {
            $this->db->get_where('rekap_wisman_dtw', array('rekap_wisman_dtw.periode'=> $per))->result();
            if($this->db->affected_rows() > 0)
            {return true;
            }
            else{
                return false;
            }
        }

        public function get_dtw_list()
        {
            return $this->db->get('dtw')->result();
        }

        // mencari list dtw status 0
        public function get_data_list($tabel, $periode, $id)
        {
            $this->db->from("$tabel as d");
            $this->db->join('provinsi as p', 'p.id_provinsi = d.id_provinsi', 'inner');
            $this->db->where('d.status', 0);

            $this->db->where('d.periode', $periode);

            $this->db->where($id);
            
            return $this->db->get();
        }

        // mencari list dtw wisman status 0
        public function get_data_list_dtw_wisman($periode, $id_dtw)
        {
            $this->db->from('rekap_wisman_dtw as d');
            $this->db->join('negara as n', 'n.id_negara = d.id_negara', 'inner');
            $this->db->join('kawasan as k', 'k.id_kawasan = n.id_kawasan', 'inner');
            $this->db->where('d.status', 0);
            $this->db->where('d.periode', $periode);
            $this->db->where('d.id_dtw', $id_dtw);
            
            return $this->db->get();
        }

        public function cari_tot_jml_dtw($tabel, $periode, $id_dtw)
        {
            $this->db->select('sum(pengunjung_pria) as tot_pria, sum(pengunjung_wanita) as tot_wanita, sum(jumlah_pengunjung) as tot_jumlah');
            $this->db->from($tabel);
            $this->db->where('status', 0);
            $this->db->where('periode', $periode);
            $this->db->where('id_dtw', $id_dtw);
            
            return $this->db->get();

        }

        public function get_provinsi_dtw($periode, $id_dtw)
        {
            $this->db->from('rekap_wisnus_dtw as d');
            $this->db->where('d.status', 0);
            $this->db->where('d.periode', $periode);
            $this->db->where('d.id_dtw', $id_dtw);
            $a = $this->db->get()->result();
            $ay = array();
            foreach ($a as $b) {
                $ay[] = $b->id_provinsi;
            }

            $im    = implode(',',$ay);
            $id    = explode(',',$im); 

            $this->db->from('provinsi');
            $this->db->where_not_in('id_provinsi', $id); 
            $this->db->order_by('nama_provinsi', 'asc');

            return $this->db->get();
            
        }

        // ambil negara yang tidak ada pada rekap wisman dtw
        public function cari_negara_rekap_wisman($periode, $id_dtw, $id_kawasan)
        {
            $this->db->from('rekap_wisman_dtw as d');
            $this->db->where('d.status', 0);
            $this->db->where('d.periode', $periode);
            $this->db->where('d.id_dtw', $id_dtw);
            $a = $this->db->get()->result();
            $ay = array();
            foreach ($a as $b) {
                $ay[] = $b->id_negara;
            }

            $im    = implode(',',$ay);
            $id    = explode(',',$im); 

            $this->db->from('negara');
            $this->db->where('id_kawasan', $id_kawasan);
            $this->db->where_not_in('id_negara', $id);
            $this->db->order_by('nama_negara', 'asc');
            
            return $this->db->get();
            
        }

        // cek provinsi
        public function cek_provinsi($periode, $id_dtw, $provinsi)
        {
            $this->db->from('rekap_wisnus_dtw as d');
            $this->db->where('d.status', 1);
            $this->db->where('d.periode', $periode);
            $this->db->where('d.id_dtw', $id_dtw);
            $this->db->where('d.id_provinsi', $provinsi);

            return $this->db->get();
        }

        // cek negara
        public function cek_negara($periode, $id_dtw, $negara)
        {
            $this->db->from('rekap_wisman_dtw as d');
            $this->db->where('d.status', 1);
            $this->db->where('d.periode', $periode);
            $this->db->where('d.id_dtw', $id_dtw);
            $this->db->where('d.id_negara', $negara);

            return $this->db->get();
        }

        public function input_data($tabel, $data)
        {
            $this->db->insert($tabel, $data);
            if($this->db->affected_rows())
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public function hapus_data($tabel, $where)
        {
            $this->db->delete($tabel, $where);
        }

        public function ubah_data($tabel, $data, $where)
        {
            $this->db->update($tabel, $data, $where);
        }

        public function get_provinsi()
        {
            $this->db->order_by('nama_provinsi', 'ASC');
            return $this->db->get('provinsi')->result();
        }

        public function asia()
        {
            $this->db->select('*');
            $this->db->from('negara');
            $this->db->join('kawasan', 'negara.id_kawasan = kawasan.id_kawasan');
            $this->db->where('nama_kawasan', 'ASIA');
            return $this->db->get();
        }

        public function afrika()
        {
            $this->db->select('*');
            $this->db->from('negara');
            $this->db->join('kawasan', 'negara.id_kawasan = kawasan.id_kawasan');
            $this->db->where('nama_kawasan', 'AFRIKA');
            return $this->db->get();
        }

        public function amerika()
        {
            $this->db->select('*');
            $this->db->from('negara');
            $this->db->join('kawasan', 'negara.id_kawasan = kawasan.id_kawasan');
            $this->db->where('nama_kawasan', 'AMERIKA');
            return $this->db->get();
        }

        public function australia()
        {
            $this->db->select('*');
            $this->db->from('negara');
            $this->db->join('kawasan', 'negara.id_kawasan = kawasan.id_kawasan');
            $this->db->where('nama_kawasan', 'AUSTRALIA');
            return $this->db->get();
        }

        public function eropa()
        {
            $this->db->select('*');
            $this->db->from('negara');
            $this->db->join('kawasan', 'negara.id_kawasan = kawasan.id_kawasan');
            $this->db->where('nama_kawasan', 'EROPA');
            return $this->db->get();
        }

        // public function fil_periode($per)
        // {
        //     $this->db->select('*');
        //     $this->db->from('dtw');
        //     $this->db->join('rekap_wisman_dtw as rwis', 'rwis.id_dtw = dtw.id_dtw', 'left');
        //     $this->db->join('rekap_wisnus_dtw as rwisn', 'rwisn.id_dtw = dtw.id_dtw', 'left');
        //     $this->db->where("rwis.periode ='".$per."-01' OR rwisn.periode = '".$per."-01'");
        //     $this->db->group_by('dtw.id_dtw');
        //     $this->db->order_by('nama_dtw', 'asc');
        //     return $this->db->get()->result();
        // }
    }