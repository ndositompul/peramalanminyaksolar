<div class="row justify-content-center">
    <div class="col">
        <div class="card shadow-sm border-bottom-danger">
            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <?= form_open('peramalan/inputNilaiAlpha', [], '') ?>
                <div class="row form-group">
                    <div class="col-md-5">
                        <div class="input-group">
                            <input value="<?php if (isset($nilai_alpha)) {
                                                echo $nilai_alpha;
                                            } ?>" step="0.1" max="0.9" min="0.1" name="alpha" id="alpha" type="number" class="form-control" placeholder="Nilai Alpha..." <?php if ($alpha) {
                                                                                                                                                                                echo "disabled";
                                                                                                                                                                            } ?>>
                        </div>
                        <?= form_error('alpha', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="col-md-5">
                        <button type="submit" class="btn btn-success" <?php if ($alpha) {
                                                                            echo "disabled";
                                                                        } ?>>Proses</button>
                        <a onclick="return confirm('Yakin ingin reset nilai alpha?')" href="<?= base_url('peramalan/reset'); ?>" class="btn btn-warning">Reset</a>
                    </div>

                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row justify-content-center">
    <div class="col">
        <div class="card shadow-sm border-bottom-danger">
                <div class="card-header bg-white py-3">
                    <div class="row">
                        <div class="col">
                            <h4 class="h5 align-middle m-0 font-weight-bold text-danger">
                            Hasil Peramalan Penjualan Minyak Solar
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped w-100 dt-responsive nowrap">
                        <thead class="bg-dark text-white">
                            <tr>
                                <?php
                                $tahunRamal = intVal($hasil_ramal[0]['tahun']);
                                $tahunRamal = $tahunRamal + 1;
                                ?>
                                <th>No. </th>
                                <th>Periode</th>
                                <th>Aktual</th>
                                <th>Peramalan</th>
                                <th>Deviasi absolut [ Et = Xt-Ft ]</th>
                                <th>Kesalahan [ Et<sup>2</sup> ]</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $this->load->helper('tgl_indo');
                            $no = 1;
                            $totalNilaiXt = 0;
                            $totalNilaiFt = 0;
                            $totalNilaiMad = 0;
                            $totalNilaiMse = 0;
                            if ($hasil_ramal) :
                                foreach ($hasil_ramal as $hasil) :
                                    $totalNilaiXt += $hasil['data_rill'];
                                    $totalNilaiFt += $hasil['data_peramalan'];
                                    $totalNilaiMad += $hasil['mad'];
                                    $totalNilaiMse += $hasil['mse'];
                            ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $hasil['tahun']; ?></td>
                                        <td>
                                            <?php if ($hasil['data_rill'] == 0) {
                                                echo "-";
                                            } else {
                                                echo $hasil['data_rill'];
                                            } ?>
                                        </td>
                                        <td>
                                            <?php if ($hasil['data_peramalan'] == 0) {
                                                echo "-";
                                            } else {
                                                echo $hasil['data_peramalan'];
                                            } ?>
                                        </td>
                                        <td>
                                            <?php if ($hasil['mad'] == 0) {
                                                echo "-";
                                            } else {
                                                echo $hasil['mad'];
                                            } ?>
                                        </td>
                                        <td>
                                            <?php if ($hasil['mse'] == 0) {
                                                echo "-";
                                            } else {
                                                echo $hasil['mse'];
                                            } ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="8" class="text-center">
                                        Data Kosong
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" align="center">Jumlah</th>
                                <th><?php echo $totalNilaiXt; ?></th>
                                <th><?php echo $totalNilaiFt; ?></th>
                                <th><?php echo $totalNilaiMad; ?></th>
                                <th><?php echo $totalNilaiMse; ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>
    <?php if (isset($nilai_alpha)) { ?>
        <br>
        <div class="row justify-content-center">
            <div class="col">
                <div class="card shadow-sm border-bottom-danger">
                    <div class="card-header bg-white py-3">
                        <div class="row">
                            <div class="col">
                                <h4 class="h5 align-middle m-0 font-weight-bold text-danger">
                                    Perhitungan Mean Square Error (MSE)
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped w-100 dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>Nilai Kesalahan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><b><i>MSE = &Sigma;(X<sub>t</sub>-F<sub>t</sub>)<sup>2</sup>/<sub>n</sub></i></b></td>
                                </tr>
                                <tr>
                                    <td>MSE = <?= $totalNilaiMse ?>/3</td>
                                </tr>
                                <tr>
                                    <td>= <?= round($totalNilaiMse / 3, 0); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <?php if (isset($nilai_alpha)) { ?>
            <!-- Area Chart -->
            <br>
            <div class="row justify-content-center">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header bg-danger py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-white">Grafik Ramalan Penjualan Minyak Solar </h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="grafikRamal" width="910" height="320" class="chartjs-render-monitor" style="display: block; width: 910px; height: 320px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        <script src="<?= base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
        <script type="text/javascript">
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#858796';
            var chLine = document.getElementById("grafikRamal");
            var chartType = "bar";

            var chartData = {
                labels: [
                    <?php
                    if (count($hasil_ramal) > 0) {
                        foreach ($hasil_ramal as $graph) {
                            echo "'" . $graph['tahun'] . "',";
                        }
                    }
                    ?>
                ],
                datasets: [{
                        label: 'Data Aktual',
                        data: [
                            <?php
                            if (count($hasil_ramal) > 0) {
                                foreach ($hasil_ramal as $graph) {
                                    echo $graph['data_rill'] . ", ";
                                }
                            }
                            ?>
                        ],
                        lineTension: 0.3,
                        backgroundColor: "rgba(78, 115, 223, 0.9)",
                        borderColor: "rgba(78, 115, 223, 0.9)",
                        pointRadius: 3,
                        pointBackgroundColor: "rgba(78, 115, 223, 1)",
                        pointBorderColor: "rgba(78, 115, 223, 1)",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "#5a5c69",
                        pointHoverBorderColor: "#5a5c69",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        fill: false
                    },
                    {
                        label: 'Data Peramalan',
                        data: [
                            <?php
                            if (count($hasil_ramal) > 0) {
                                foreach ($hasil_ramal as $graph) {
                                    echo $graph['data_peramalan'] . ", ";
                                }
                            } ?>
                        ],
                        lineTension: 0.3,
                        backgroundColor: "rgba(231, 74, 59, 0.9)",
                        borderColor: "#e74a3b",
                        pointRadius: 3,
                        pointBackgroundColor: "#e74a3b",
                        pointBorderColor: "#e74a3b",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "#5a5c69",
                        pointHoverBorderColor: "#5a5c69",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        fill: false
                    }
                ]
            };

            function init() {
                if (chLine) {
                    new Chart(chLine, {
                        type: chartType,
                        data: chartData,
                        options: {
                            maintainAspectRatio: false,
                            scales: {
                                xAxes: [{
                                    time: {
                                        unit: 'date'
                                    },
                                    gridLines: {
                                        display: false,
                                        drawBorder: false
                                    },
                                    ticks: {
                                        maxTicksLimit: 7
                                    }
                                }],
                                yAxes: [{
                                    time: {
                                        unit: 'date'
                                    },
                                    ticks: {
                                        maxTicksLimit: 5,
                                        padding: 10
                                    },
                                    gridLines: {
                                        color: "rgb(234, 236, 244)",
                                        zeroLineColor: "rgb(234, 236, 244)",
                                        drawBorder: false,
                                        borderDash: [2],
                                        zeroLineBorderDash: [2]
                                    }
                                }],
                            },
                            legend: {
                                display: true
                            }
                        }
                    });
                }
            }

            init();
        </script>
    <?php }
} else { ?>
    <br>
    <br>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card shadow-sm border-bottom-primary">
                <div class="card-body">
                    Silahkan masukkan nilai alpha terlebih dahulu untuk memulai proses peramalan
                </div>
            </div>
        </div>
    </div>
<?php
} ?>