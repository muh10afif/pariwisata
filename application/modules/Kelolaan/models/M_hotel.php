<?php if (! defined('BASEPATH')) {
        exit('No direct script access allowed');
    }
    
    class M_hotel extends CI_Model
    {
        public function cari_data($tabel, $where)
        {
            return $this->db->get_where($tabel, $where);
        }

        public function get_data($tabel, $order)
        {
            $this->db->order_by($order, 'asc');
            
            return $this->db->get($tabel);          
        }

        public function ubah_data($tabel, $data, $where)
        {
            $this->db->update($tabel, $data, $where);
        }

        public function hapus_data($tabel, $where)
        {
            $this->db->delete($tabel, $where);
        }

        public function input_data($tabel, $data)
        {
            return $this->db->insert($tabel, $data);
        }

        public function cari_tot_jml_hotel($tabel, $periode, $id_hotel)
        {
            $this->db->select('sum(pengunjung_pria) as tot_pria, sum(pengunjung_wanita) as tot_wanita, sum(jumlah_pengunjung) as tot_jumlah');
            $this->db->from($tabel);
            $this->db->where('status', 1);
            $this->db->where('periode', $periode);
            $this->db->where('id_hotel', $id_hotel);
            
            return $this->db->get();
        }

        public function get_provinsi_hotel($periode, $id_hotel)
        {
            $this->db->from('rekap_wisnus_hotel as d');
            $this->db->where('d.status', 1);
            $this->db->where('d.periode', $periode);
            $this->db->where('d.id_hotel', $id_hotel);
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

        // cek provinsi
        public function cek_provinsi($periode, $id_hotel, $provinsi)
        {
            $this->db->from('rekap_wisnus_hotel as d');
            $this->db->where('d.status', 1);
            $this->db->where('d.periode', $periode);
            $this->db->where('d.id_hotel', $id_hotel);
            $this->db->where('d.id_provinsi', $provinsi);

            return $this->db->get();
        }

        // WISMAN

        // mencari list hotel wisman status 0
        public function get_data_list_hotel_wisman($periode, $id)
        {
            $this->db->from('rekap_wisman_hotel as d');
            $this->db->join('negara as n', 'n.id_negara = d.id_negara', 'inner');
            $this->db->join('kawasan as k', 'k.id_kawasan = n.id_kawasan', 'inner');
            $this->db->where('d.status', 1);
            
            $this->db->where('d.periode', $periode);
            
            $this->db->where($id);
            
            return $this->db->get();
        }

        // ambil negara yang tidak ada pada rekap wisman hotel
        public function cari_negara_rekap_wisman($periode, $id_hotel, $id_kawasan)
        {
            $this->db->from('rekap_wisman_hotel as d');
            $this->db->where('d.status', 0);
            $this->db->where('d.periode', $periode);
            $this->db->where('d.id_hotel', $id_hotel);
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

        public function cari_data_o($tabel, $where, $order)
        {
            $this->db->order_by($order, 'asc');
            
            return $this->db->get_where($tabel, $where);
        }

        // cek negara
        public function cek_negara($periode, $id_hotel, $negara)
        {
            $this->db->from('rekap_wisman_hotel as d');
            $this->db->where('d.status', 1);
            $this->db->where('d.periode', $periode);
            $this->db->where('d.id_hotel', $id_hotel);
            $this->db->where('d.id_negara', $negara);

            return $this->db->get();
        }
        
        public function get_hotel($id_pegawai)
        {

            $this->db->select('*');
            $this->db->from('hotel');
            $this->db->join('penempatan_hotel', 'penempatan_hotel.id_hotel = hotel.id_hotel', 'inner');
            $this->db->join('rekap_wisman_hotel as rwis', 'rwis.id_hotel = hotel.id_hotel', 'left');
            $this->db->join('rekap_wisnus_hotel as rwisn', 'rwisn.id_hotel = hotel.id_hotel', 'left');
            $this->db->where('penempatan_hotel.id_pegawai', $id_pegawai);
            $this->db->group_by('hotel.id_hotel');
            $this->db->order_by('nama_hotel', 'asc');
            return $this->db->get()->result();
        }

        public function get_hotel_list()
        {
            return $this->db->get('hotel')->result();
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

        public function fil_periode($per)
        {
            $this->db->select('*');
            $this->db->from('hotel');
            $this->db->join('rekap_wisman_hotel as rwis', 'rwis.id_hotel = hotel.id_hotel', 'left');
            $this->db->join('rekap_wisnus_hotel as rwisn', 'rwisn.id_hotel = hotel.id_hotel', 'left');
            $this->db->where("rwis.periode ='".$per."' OR rwisn.periode = '".$per."'");
            $this->db->group_by('hotel.id_hotel');
            $this->db->order_by('nama_hotel', 'asc');
            return $this->db->get()->result();
        }

        // level petugas 

        public function get_hotel_petugas_2($id_petugas)
        {
            $this->db->select('*');
            $this->db->from('penempatan_hotel a');
            $this->db->join('hotel b', 'b.id_hotel = a.id_hotel', 'inner');
            $this->db->where('a.id_pegawai', $id_petugas);
            $this->db->where('a.status', 1);
             
            return $this->db->get();
        }

        public function cek_wisnusman_petugas($tabel, $periode, $per_awal, $id_petugas, $id_hotel)
        {
            $this->db->select('*');
            $this->db->from('penempatan_hotel a');
            $this->db->join("$tabel b", 'b.id_hotel = a.id_hotel', 'inner');
            $this->db->where('a.id_pegawai', $id_petugas);
            $this->db->where('b.status', 1);
            $this->db->where('b.id_hotel', $id_hotel);
            
            if ($periode == $per_awal) {
                $this->db->where('b.periode', $per_awal);
               
            } else {
                $this->db->where('b.periode', $periode);
            }

            return $this->db->get()->num_rows();
        }
    }
