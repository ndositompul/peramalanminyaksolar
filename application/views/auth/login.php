<nav class="navbar bg-white pt-2 pb-3 fixed-top">
    <div class="container">
        <a class="navbar-brand text-dark" style="font-weight: 800;"> <img src="<?= base_url('assets/')?>img/wdplogo.jpg" style="width: 50px;" alt=""> Rancang Bangun Sistem Informasi Peramalan Penjualan Minyak Solar Pada PT. Willy Dwi Perkasa</a>
    </div>
</nav>
<!-- Outer Row -->
<div class="row justify-content-center mt-5 pt-lg-5">

    <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg mt-5">
            <div class="card-body p-0 bg-light">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center mb-4">
                                <strong class="text-muted">Silahkan Login</stronng>
                            </div>
                            <?= $this->session->flashdata('pesan'); ?>
                            <?= form_open('', ['class' => 'user']); ?>
                            <div class="form-group">
                                <input autofocus="autofocus" autocomplete="off" value="<?= set_value('username'); ?>" type="text" name="username" class="form-control form-control-user" placeholder="Username">
                                <?= form_error('username', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control form-control-user" placeholder="Password">
                                <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <button type="submit" class="btn btn-success btn-user btn-block">
                                <i class="fas fa-fw fa-sign-in-alt"></i>
                                M A S U K
                            </button>
                            <?= form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>