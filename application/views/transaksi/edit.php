<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-primary">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                            Form Input Barang Masuk
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
                <?php foreach ($datapenjualan as $penjualan) { ?>
                    <?= $this->session->flashdata('pesan'); ?>
                    <?= form_open('', [], ['periode' => $penjualan['periode'],'kd_penjualan'=>$penjualan['kd_penjualan']]); ?>
                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="kd_penjualan">Kode Penjualan</label>
                        <div class="col-md-4">
                            <input value="<?= $penjualan['kd_penjualan']; ?>" type="text" readonly="readonly" class="form-control">
                            <?= form_error('kd_penjualan', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="bulan_penjualan">Bulan Penjualan</label>
                        <div class="col-md-4">
                            <input value="<?= konversi_bulan($penjualan['periode']); ?>" name="bulan_penjualan" id="bulan_penjualan" type="text" class="form-control" placeholder="Bulan Penjualan..." readonly="readonly">
                            <?= form_error('bulan_penjualan', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="jumlah">Jumlah</label>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input value="<?= $penjualan['jumlah'] ?>" min="1" name="jumlah" id="jumlah" type="number" class="form-control" placeholder="Jumlah...">
                            </div>
                            <?= form_error('jumlah', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col offset-md-4">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                    <?= form_close(); ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>