<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
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

        //Rekap SQL
        $sqlDelete = "DELETE FROM peramalan";
        $this->db->query($sqlDelete);

        $sql = "SELECT periode,sum(jumlah) as jumlah FROM `data_penjualan` GROUP BY MONTH(periode), YEAR(periode)";
        $dataPenjualan = $this->db->query($sql)->result_array();
        foreach ($dataPenjualan as $dataJual) {
            $sqlInput = "INSERT INTO peramalan(periode,jumlah) values('" . $dataJual['periode'] . "','" . $dataJual['jumlah'] . "')";
            $insert = $this->db->query($sqlInput);
        }

        $this->form_validation->set_rules('tahun', 'Periode Tahun', 'required');
        $alpha = $this->db->get('alpha')->result_array();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Laporan";
            $sql = "SELECT periode FROM `peramalan` GROUP BY YEAR(periode)";
            $data['periode'] = $this->db->query($sql)->result_array();
            $this->template->load('templates/dashboard', 'laporan/form', $data);
        } else {
            $tahunselected = $this->input->post('tahun');
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
            $this->_cetak($data['hasil_ramal'], intval($tahun));
        }
    }

    private function _cetak($data, $tahun)
    {
        $tahunRamal = $tahun + 1;
        $this->load->library('CustomPDF');
        //$table = $table_ == 'barang_masuk' ? 'Barang Masuk' : 'Barang Keluar';

        $pdf = new FPDF();
        $pdf->AddPage('L', 'A4');
        $pdf->SetFont('Times', 'B', 16);
        //$pdf->Cell(190, 7, 'Laporan ' . $table, 0, 1, 'C');

        $pdf->Image('assets/img/wdplogo.jpg', 12, 5, 30);
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->MultiCell(0, 20, 'PT. WILLY DWI PERKASA', 0, 'C');
        $pdf->Ln(5);
        $pdf->SetFont('', 'B', 12);
        $pdf->SetX(10);
        $pdf->Cell(0, 12, 'PERAMALAN PENJUALAN MINYAK SOLAR', 0, 1, 'C');
        $pdf->SetLineWidth(1);
        $pdf->Line(10,31,200,31);
        $pdf->SetLineWidth(0);
        $pdf->Line(10,32,200,32);
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 10, 'C');
        $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
        $pdf->Cell(25, 7, 'Bulan', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Nilai Aktual', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Nilai Peramalan', 1, 0, 'C');
        $pdf->Cell(50, 7, 'Deviasi Absolut [Et=Xt-Ft]', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Kesalahan [Et^2]', 1, 0, 'C');
        $pdf->Ln();

        $no = 1;
        $sqlDelete = "DELETE FROM laporan";
        $this->db->query($sqlDelete);
        foreach ($data as $d) {
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
            $pdf->Cell(25, 7, $d['bulan'], 1, 0, 'C');
            $pdf->Cell(30, 7, $d['data_rill'], 1, 0, 'C');
            $pdf->Cell(30, 7, $d['data_peramalan'], 1, 0, 'C');
            $pdf->Cell(50, 7, $d['mad'], 1, 0, 'R');
            $pdf->Cell(45, 7, $d['mse'], 1, 0, 'R');
            $pdf->Ln();


            $sqlInput = "INSERT INTO laporan(periode,jumlah) values('" . $d['bulan'] . "','" . $d['data_rill'] . "')";
            $this->db->query($sqlInput);
        }

        $pdf->Ln(8);
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetX(90);
        $pdf->Cell(0, 11, 'Mengetahui,     ', 0, 0, 'R');
        $pdf->Ln(6);
        $pdf->Cell(0, 10, 'Pimpinan        ', 0, 1, 'R');
        $pdf->Ln(18);
        $pdf->SetX(90);
        $pdf->Cell(0, 10, 'CHALIK ARMADA', 0, 1, 'R');
        $pdf->Ln();
        
        $file_name =  'Laporan ' . $tahun . '.pdf';
        $pdf->Output('I', $file_name);
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

        $alpha = $this->db->get('alpha')->result_array();
        $tahunselected = $this->input->post('tahun');
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
        $this->_cetaktahun($data['hasil_ramal'], intval($tahun));
    }

    private function _cetaktahun($data, $tahun)
    {
        $tahunRamal = $tahun + 1;
        $this->load->library('CustomPDF');
        //$table = $table_ == 'barang_masuk' ? 'Barang Masuk' : 'Barang Keluar';

        $pdf = new FPDF();
        $pdf->AddPage('P', 'A4');
        $pdf->SetFont('Times', 'B', 16);
        //$pdf->Cell(190, 7, 'Laporan ' . $table, 0, 1, 'C');
        $pdf->Image('assets/img/wdplogo.jpg', 12, 5, 30);
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->MultiCell(0, 20, 'PT. WILLY DWI PERKASA', 0, 'C');
        $pdf->Ln(5);
        $pdf->SetFont('', 'B', 12);
        $pdf->SetX(10);
        $pdf->Cell(0, 12, 'PERAMALAN PENJUALAN MINYAK SOLAR', 0, 1, 'C');
        $pdf->SetLineWidth(1);
        $pdf->Line(10,31,200,31);
        $pdf->SetLineWidth(0);
        $pdf->Line(10,32,200,32);
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 10, 'C');
        $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
        $pdf->Cell(25, 7, 'Tahun', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Nilai Aktual', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Nilai Peramalan', 1, 0, 'C');
        $pdf->Cell(50, 7, 'Deviasi Absolut [Et=Xt-Ft]', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Kesalahan [Et^2]', 1, 0, 'C');
        $pdf->Ln();

        $no = 1;
        $sqlDelete = "DELETE FROM laporan";
        $this->db->query($sqlDelete);
        foreach ($data as $d) {
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
            $pdf->Cell(25, 7, $d['tahun'], 1, 0, 'C');
            $pdf->Cell(30, 7, $d['data_rill'], 1, 0, 'C');
            $pdf->Cell(30, 7, $d['data_peramalan'], 1, 0, 'C');
            $pdf->Cell(50, 7, $d['mad'], 1, 0, 'C');
            $pdf->Cell(45, 7, $d['mse'], 1, 0, 'C');
            $pdf->Ln();


            $sqlInput = "INSERT INTO laporan(periode,jumlah) values('" . $d['tahun'] . "','" . $d['data_rill'] . "')";
            $this->db->query($sqlInput);
        }

        $pdf->Ln(8);
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetX(90);
        $pdf->Cell(0, 11, 'Mengetahui,     ', 0, 0, 'R');
        $pdf->Ln(6);
        $pdf->Cell(0, 10, 'Pimpinan        ', 0, 1, 'R');
        $pdf->Ln(18);
        $pdf->SetX(90);
        $pdf->Cell(0, 10, 'CHALIK ARMADA', 0, 1, 'R');
        $pdf->Ln();

        $file_name =  'Laporan Peramalan Tahunan.pdf';
        $pdf->Output('I', $file_name);
    }
}
