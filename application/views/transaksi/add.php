<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-danger">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-danger">
                           Input Data Rekapitulasi Penjualan
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
                <?= $this->session->flashdata('pesan'); ?>
                <?= form_open(); ?>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="bulan_penjualan">Bulan Penjualan</label>
                    <div class="col-md-4">
                        <input value="" name="bulan_penjualan" id="bulan_penjualan" type="text" class="form-control date" placeholder="Masukan Bulan Penjualan">
                        <?= form_error('bulan_penjualan', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="nama">Nama</label>
                    <div class="col-md-4">
                        <input  type="text"  id="nama" name="nama" class="form-control">
                        <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="jumlah">Jumlah</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <input value="<?= set_value('jumlah'); ?>" min="1" name="jumlah" id="jumlah" type="number" class="form-control" placeholder="Masukan Jumlah">
                        </div>
                        <?= form_error('jumlah', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col offset-md-4">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="reset" class="btn btn-warning">Reset</button>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>