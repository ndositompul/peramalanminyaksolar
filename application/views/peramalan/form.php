<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-bottom-success">
            <div class="card-header bg-white py-3">
                <h4 class="h5 align-middle m-0 font-weight-bold text-success">
                    Form Peramalan
                </h4>
            </div>
            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <?= form_open(); ?>
                <div class="row form-group">
                    <label class="col-lg-3 text-lg-right" for="tahun">Tahun</label>
                    <div class="col-lg-5">
                        
                        <select class="form-control" name="tahun">
                            <option selected>Pilih Tahun</option>
                            <?php
                            foreach ($periode as $dataperiode) {
                                $periode = explode("-", $dataperiode['periode']);
                                echo "<option value='" . $periode[0] . "'>" . $periode[0]   . "</option>";
                            }
                            ?>
                        </select>
                        <?= form_error('tahun', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-9 offset-lg-3">
                        <button type="submit" class="btn btn-success btn-icon-split">
                            <span class="icon">
                                <i class="fa fa-forward"></i>
                            </span>
                            <span class="text">
                                Proses
                            </span>
                        </button>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>