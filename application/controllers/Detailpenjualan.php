<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detailpenjualan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('Admin_model', 'admin');
        $this->load->library('form_validation');
        $this->load->helper('tgl_indo');
    }

    public function index()
    {
        $data['title'] = "Data Penjualan";
        $this->db->order_by('periode', 'ASC');
        $data['barangmasuk'] = $this->db->get('data_penjualan')->result_array();
        $this->template->load('templates/dashboard', 'detailpenjualan/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('bulan_penjualan', 'periode', 'required');
        $this->form_validation->set_rules('nama', 'nama', 'required');
        $this->form_validation->set_rules('jumlah', 'jumlah', 'numeric');
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Data Penjualan";
            $this->template->load('templates/dashboard', 'detailpenjualan/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $tanggal = explode(" ", $input['bulan_penjualan']);
            $sql = "INSERT INTO data_penjualan(nama,periode,jumlah) values('". $input['nama'] . "',STR_TO_DATE('01/" .  $tanggal[0] . "/" . $tanggal[1] . "','%d/%M/%Y'),'". $input['jumlah']."')";
            $insert = $this->db->query($sql);
            if ($insert) {
                set_pesan('data berhasil disimpan.');
                redirect('detailpenjualan');
            } else {
                set_pesan('Opps ada kesalahan!');
                redirect('detailpenjualan/add');
            }
        }
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Data Penjualan ";
            $data['datapenjualan'] = $this->db->query("SELECT * FROM data_penjualan WHERE kd_penjualan='".$getId."'")->result_array();
            $this->template->load('templates/dashboard', 'detailpenjualan/edit', $data);
        } else {
            $input = $this->input->post(null, true);
            $tanggal = explode(" ", $input['bulan_penjualan']);
            $sql = "UPDATE data_penjualan SET nama='". $input['nama'] . "',periode=STR_TO_DATE('01/" .  $tanggal[0] . "/" . $tanggal[1] . "','%d/%M/%Y'),jumlah='". $input['jumlah']."' WHERE kd_penjualan='".$id."'";
            $update = $this->db->query($sql);
            
            if ($update) {
                set_pesan('data berhasil disimpan');
                redirect('detailpenjualan');
            } else {
                set_pesan('gagal menyimpan data');
                redirect('detailpenjualan/edit/' . $id);
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('data_penjualan', 'kd_penjualan', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('detailpenjualan');
    }
}