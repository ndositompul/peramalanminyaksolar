<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-danger">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-danger">
                    Data Penjualan
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('detailpenjualan/add') ?>" class="btn btn-sm btn-success btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Data Penjualan
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped w-100 dt-responsive nowrap" id="dataTable">
            <thead class="bg-dark text-white">
                <tr>
                    <th>No. </th>
                    <th>Nama</th>
                    <th>Periode</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
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
                            <td><?= $bm['nama']; ?></td>
                            <td><?= $exp[0]; ?> - <?= $exp[1]; ?></td>
                            <td><?= $bm['jumlah']; ?></td>
                            <td>
                                <a href="<?= base_url('detailpenjualan/edit/') . $bm['kd_penjualan'] ?>" class="btn btn-primary btn-circle btn-sm" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('detailpenjualan/delete/') . $bm['kd_penjualan'] ?>" class="btn btn-warning btn-circle btn-sm" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
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
        </table>
    </div>
</div>
<script>
$(function (){
  $('[data-toggle="tooltip"]').tooltip()

})

</script>