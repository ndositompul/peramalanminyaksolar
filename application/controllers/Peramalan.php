<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peramalan extends CI_Controller
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

        $data['title'] = "Data Peramalan";
        $this->form_validation->set_rules('tahun', 'Periode Tahun', 'required');
        $alpha = $this->db->get('alpha')->result_array();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Peramalan";
            $sql = "SELECT periode FROM `data_penjualan` GROUP BY YEAR(periode)";
            $data['periode'] = $this->db->query($sql)->result_array();
            $this->template->load('templates/dashboard', 'peramalan/form', $data);
        } else {
            //Rekap SQL
            $sqlDelete = "DELETE FROM peramalan";
            $this->db->query($sqlDelete);
            $tahunselected = $this->input->post('tahun');
            $sql = "SELECT periode,sum(jumlah) as jumlah FROM `data_penjualan` GROUP BY MONTH(periode), YEAR(periode)";
            $dataPenjualan = $this->db->query($sql)->result_array();
            foreach ($dataPenjualan as $dataJual) {
                $sqlInput = "INSERT INTO peramalan(periode,jumlah) values('" . $dataJual['periode'] . "','" . $dataJual['jumlah'] . "')";
                $insert = $this->db->query($sqlInput);
            }
            if ($this->db->get('alpha')->num_rows() <= 0) {
                $data['alpha'] = false;
                $data['hasil_ramal'] = "";
                $this->template->load('templates/dashboard', 'peramalan/hasilramal', $data);
            } else {
                $data['alpha'] = true;
                $alpha = $alpha[0]['nilai'];
                $this->db->where('year(periode)', $tahunselected);
                $data['penjualan'] = $this->db->get('peramalan')->result_array();
                $i = 0;
                $jml = sizeof($data['penjualan']);
                $this->db->select_sum('jumlah');
                $sumPenjualan = $this->db->get('peramalan')->result_array();
                $nilaiPenjualan = $sumPenjualan[0]['jumlah'];
                $singleEksponensial[0] =  null;
                $nilaiFt = 0;
                foreach ($data['penjualan'] as $penjualan) {
                    $periode = explode("-", $penjualan['periode']);
                    $bulan = $periode[1];
                    $tahun = $periode[0];
                    $data_rill = $penjualan['jumlah'];
                    $bullan[$i] = $data_rill;
                    //Peramalan

                    if ($i == 0) {
                        $ramal[$i] =  array(
                            'tahun' => $tahun,
                            'bulan' => nama_bulan($bulan) . " " . $tahun,
                            'data_rill' => round($data_rill),
                            'data_peramalan' => 0,
                            'mad' => 0,
                            'mse' => 0
                        );
                        $nilaiFt = round($data_rill);
                    } else {

                        //MAD
                        $mad = round($data_rill - round($nilaiFt, 2), 1);
                        //MSE
                        $mse = pow($mad, 2);
                        $ramal[$i] =  array(
                            'tahun' => $tahun,
                            'bulan' => nama_bulan($bulan) . " " . $tahun,
                            'data_rill' => round($data_rill),
                            'data_peramalan' => round($nilaiFt, 2),
                            'mad' => $mad,
                            'mse' => $mse
                        );
                        $singleEksponensial[$i] =  ($alpha * $data_rill) + ((1 - $alpha) * $nilaiFt);
                        $nilaiFt = round($singleEksponensial[$i], 2);
                    }
                    $i += 1;

                    if ($jml == $i) {
                        //MAD
                        $mad = round(0 - round($nilaiFt, 2), 1);
                        //MSE
                        $mse = pow($mad, 2);

                        if ($bulan == 12) {
                            $bulan = 1;
                            $tahun += 1;
                        } else {
                            $bulan += 1;
                        }

                        $ramal[$jml + 1] =  array(
                            'tahun' => $tahun,
                            'bulan' => nama_bulan($bulan) . " " . $tahun,
                            'data_rill' => 0,
                            'data_peramalan' => round($nilaiFt, 2),
                            'mad' => $mad,
                            'mse' => $mse
                        );

                        $singleEksponensial[$i] =  ($alpha * $data_rill) + ((1 - $alpha) * $nilaiFt);
                        $nilaiFt = round($singleEksponensial[$i], 2);
                    }
                }



                $data['nilai_alpha'] = $alpha;
                $data['hasil_ramal'] = $ramal;
                $this->template->load('templates/dashboard', 'peramalan/hasilramal', $data);
            }
        }
    }

    public function pertahun()
    {
        //Rekap SQL
        $sqlDelete = "DELETE FROM peramalan";
        $this->db->query($sqlDelete);

        $sql = "SELECT periode,sum(jumlah) as jumlah FROM `data_penjualan` GROUP BY YEAR(periode)";
        $dataPenjualan = $this->db->query($sql)->result_array();
        foreach ($dataPenjualan as $dataJual) {
            $sqlInput = "INSERT INTO peramalan(periode,jumlah) values('" . $dataJual['periode'] . "','" . $dataJual['jumlah'] . "')";
            $insert = $this->db->query($sqlInput);
        }

        $data['title'] = "Data Peramalan";
        $alpha = $this->db->get('alpha')->result_array();
        if ($this->db->get('alpha')->num_rows() <= 0) {
            $data['alpha'] = false;
            $data['hasil_ramal'] = "";
            $this->template->load('templates/dashboard', 'peramalan/hasilramalpertahun', $data);
        } else {
            $data['alpha'] = true;
            $alpha = $alpha[0]['nilai'];
            $data['penjualan'] = $this->db->get('peramalan')->result_array();
            $i = 0;
            $jml = sizeof($data['penjualan']);
            $this->db->select_sum('jumlah');
            $sumPenjualan = $this->db->get('peramalan')->result_array();
            $nilaiPenjualan = $sumPenjualan[0]['jumlah'];
            $singleEksponensial[0] =  null;
            $nilaiFt = 0;
            foreach ($data['penjualan'] as $penjualan) {
                $periode = explode("-", $penjualan['periode']);
                $bulan = $periode[1];
                $tahun = $periode[0];
                $data_rill = $penjualan['jumlah'];
                $bullan[$i] = $data_rill;
                //Peramalan

                if ($i == 0) {
                    $ramal[$i] =  array(
                        'tahun' => $tahun,
                        'bulan' => nama_bulan($bulan) . " " . $tahun,
                        'data_rill' => round($data_rill),
                        'data_peramalan' => 0,
                        'mad' => 0,
                        'mse' => 0
                    );
                    $nilaiFt = round($data_rill);
                } else {

                    //MAD
                    $mad = round($data_rill - round($nilaiFt, 2), 1);
                    //MSE
                    $mse = pow($mad, 2);
                    $ramal[$i] =  array(
                        'tahun' => $tahun,
                        'bulan' => nama_bulan($bulan) . " " . $tahun,
                        'data_rill' => round($data_rill),
                        'data_peramalan' => round($nilaiFt, 2),
                        'mad' => $mad,
                        'mse' => $mse
                    );
                    $singleEksponensial[$i] =  ($alpha * $data_rill) + ((1 - $alpha) * $nilaiFt);
                    $nilaiFt = round($singleEksponensial[$i], 2);
                }
                $i += 1;

                if ($jml == $i) {
                    //MAD
                    $mad = round(0 - round($nilaiFt, 2), 1);
                    //MSE
                    $mse = pow($mad, 2);

                    $tahun += 1;

                    $ramal[$jml + 1] =  array(
                        'tahun' => $tahun,
                        'bulan' => nama_bulan($bulan) . " " . $tahun,
                        'data_rill' => 0,
                        'data_peramalan' => round($nilaiFt, 2),
                        'mad' => $mad,
                        'mse' => $mse
                    );

                    $singleEksponensial[$i] =  ($alpha * $data_rill) + ((1 - $alpha) * $nilaiFt);
                    $nilaiFt = round($singleEksponensial[$i], 2);
                }
            }



            $data['nilai_alpha'] = $alpha;
            $data['hasil_ramal'] = $ramal;
            $this->template->load('templates/dashboard', 'peramalan/hasilramalpertahun', $data);
        }
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('alpha', 'alpha', 'required');
    }

    public function reset()
    {
        if ($this->db->query("DELETE FROM alpha")) {
            set_pesan('nilai alpha berhasil direset.');
        } else {
            set_pesan('nilai alpha gagal direset.', false);
        }
        redirect('peramalan');
    }

    public function inputNilaiAlpha()
    {

        $this->_validasi();
        $input = $this->input->post(null, true);
        $sql = "INSERT INTO alpha(nilai) values('" . $input['alpha'] . "')";
        $insert = $this->db->query($sql);
        if ($insert) {
            set_pesan('Nilai alpha berhasil dimasukkan.');
            redirect('peramalan');
        } else {
            set_pesan('Opps ada kesalahan!');
            redirect('peramalan');
        }
    }
}
