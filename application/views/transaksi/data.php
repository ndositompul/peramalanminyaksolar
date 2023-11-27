<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-danger">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-danger">
                    Rekapitulasi Data Tahunan
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('datapenjualan/add') ?>" class="btn btn-sm btn-success btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Rekapitulasi Penjualan Tahunan
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped w-100 dt-responsive nowrap">
            <thead class="bg-dark text-white">
                <tr>
                    <th width="10">No. </th>
                    <th width="50">Tahun</th>
                    <th width="50">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $this->load->helper('tgl_indo');
                $no = 1;
                if ($barangmasuk) :
                    foreach ($barangmasuk as $bm) :
                        $tanggal = konversi_bulan($bm['periode']);
                        $exp = explode("/", $tanggal);
                ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $exp[1]; ?></td>
                            <td><?= $bm['jumlah']; ?></td>
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
        </table>
    </div>
</div>