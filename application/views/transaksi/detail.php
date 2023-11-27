<div class="row justify-content-center">
    <div class="col">
        <div class="card shadow-sm border-bottom-primary">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                            <?php
                            $tanggal = konversi_bulan($barangmasuk[0]['periode']);
                            $exp = explode("/", $tanggal);
                            echo $exp[0] . " " . $exp[1];
                            ?>
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('datapenjualan') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                            <span class="icon">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">
                                Kembali
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped w-100 dt-responsive nowrap" id="dataTable">
                        <thead>
                            <tr>
                                <th>No. </th>
                                <th>ID Registrasi</th>
                                <th>Pangkalan</th>
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
                                        <td><?= $bm['id_registrasi']; ?></td>
                                        <td><?= $bm['pangkalan']; ?></td>
                                        <td><?= $bm['jumlah']; ?></td>
                                        <td>
                                            <a href="<?= base_url('detailpenjualan/edit/') . $bm['id'] ?>" class="btn btn-warning btn-circle btn-sm"><i class="fa fa-edit"></i></a>
                                            <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('detailpenjualan/delete/') . $bm['id'] ?>" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></a>
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
        </div>
    </div>
</div>