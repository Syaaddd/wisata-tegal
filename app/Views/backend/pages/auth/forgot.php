<?= $this->extend('backend/layout/auth-layout') ?>
<?= $this->section('content') ?>

<div class="login-box bg-white box-shadow border-radius-10">
    <div class="login-title">
        <h2 class="text-center text-primary">Forgot Password</h2>
    </div>
    <h6 class="mb-20">
        Enter your email address to reset your password
    </h6>

    <?php $validation = \config\Services::validation(); ?>
    <form action="" method="POST">
        <?= csrf_field() ?>

        <?php if(!empty(session()->getFlashdata('succes'))) : ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('succes') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <div class="input-group custom">
            <input type="text" class="form-control form-control-lg" placeholder="Email">
            <div class="input-group-append custom">
                <span class="input-group-text"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-5">
                <div class="input-group mb-0">
					<input class="btn btn-primary btn-lg btn-block" type="submit" value="Submit">
                </div>
            </div>
            <div class="col-2">
                <div class="font-16 weight-600 text-center" data-color="#707373" style="color: rgb(112, 115, 115);">
                    OR
                </div>
            </div>
            <div class="col-5">
                <div class="input-group mb-0">
                    <a class="btn btn-outline-primary btn-lg btn-block" href="<?= route_to('admin.login.form')?>">Login</a>
                </div>
            </div>
        </div>
    </form>
</div>

<?php $this->endSection() ?>