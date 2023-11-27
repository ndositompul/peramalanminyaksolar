<div class="row">
    <!-- Penjualan Terakhir -->
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary py-3">
                <h6 class="m-0 font-weight-bold text-white text-center">Pengertian Peramalan Single Exponential Smoothing</h6>
            </div>
            <div class="card-body">
                Metode Peramalan Exponential Smoothing atau Penghalusan eksponensial (Penghalusan bertingkat) ini banyak digunakan untuk meramalkan permintaan barang (demand) yang perubahannya sangat cepat.
                <br>
                Peramalan dengan Exponential Smoothing atau Metode Penghalusan Eksponensial ini cukup mudah, yaitu dengan memasukan prakiraan permintaan sekarang dengan data permintaan nyata atau data permintaan aktual ke dalam rumus Exponential Smoothing.
                <br>
                <br>
                Rumus Exponential Smoothing (Penghalusan Eksponensial) :
                <br>
                <b>Ft = Ft – 1 + α (Dt-1 – Ft-1)</b>
                <br>
                Dimana :
                <li>
                    Ft = Prakiraan Permintaan sekarang
                </li>
                <li>
                    Ft-1 = Prakiraan Permintaan yang lalu
                </li>
                <li>
                    α = Konstanta Eksponensial
                </li>
                <li>
                    Dt-1 = Permintaan Nyata
                </li>
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
                    echo "'" . $graph['bulan'] . "',";
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