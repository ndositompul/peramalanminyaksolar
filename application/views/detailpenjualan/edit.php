<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-danger">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-danger">
                            Form Ubah Data Penjualan
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('detailpenjualan') ?>" class="btn btn-sm btn-secondary btn-icon-split">
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
                    <?= form_open('', [], ['periode' => $penjualan['periode'], 'id' => $penjualan['kd_penjualan']]); ?>
                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="nama">Nama</label>
                        <div class="col-md-4">
                            <input value="<?= $penjualan['nama']; ?>" type="text" class="form-control" name="nama" id="nama">
                            <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="bulan_penjualan">Bulan Penjualan</label>
                        <div class="col-md-4">
                            <input  name="bulan_penjualan" id="bulan_penjualan" type="text" class="form-control date" placeholder="Bulan Penjualan...">
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
                            <button type="submit" class="btn btn-success ">Simpan</button>
                        </div>
                    </div>
                    <?= form_close(); ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>