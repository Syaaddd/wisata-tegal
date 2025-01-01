<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Profile</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= route_to('admin.home') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Profile
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
        <div class="pd-20 card-box height-100-p">
            <div class="profile-photo">
                <a href="modal" data-toggle="modal" data-target="#modal" class="edit-avatar"><i class="fa fa-pencil"></i></a>
                <img src="<?= get_user()->picture == null ? '/images/users/default-avatar.png' : '/images/users/' . get_user()->picture ?>" alt="" class="avatar-photo">
            </div>
            <h5 class="text-center h5 mb-0"><?= get_user()->name ?></h5>
            <p class="text-center text-muted font-14">
                <?= get_user()->email ?>
            </p>
        </div>
    </div>
    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
        <div class="card-box height-100-p overflow-hidden">
            <div class="profile-tab height-100-p">
                <div class="tab height-100-p">
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#personal_details" role="tab">Personal Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#change_password" role="tab">Change Password</a>
                        </li>
                    </ul>
                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="personal_details" role="tabpanel">
                            <div class="pd-20">
                                <form action="<?= route_to('update-personal-details') ?>" method="POST" id="personal_details_from">
                                    <?= csrf_field() ?>
                                    <div id="form-messages">
                                        <?php if (session()->getFlashdata('success')): ?>
                                            <div class="alert alert-success">
                                                <?= session()->getFlashdata('success') ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (session()->getFlashdata('errors')): ?>
                                            <div class="alert alert-danger">
                                                <ul>
                                                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                                        <li><?= esc($error) ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Name</label>
                                                <input type="text" name="name" class="form-control"
                                                    placeholder="Enter your name" value="<?= get_user()->name ?>">
                                                <span class="text-danger error-text name_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Username</label>
                                                <input type="text" name="username" class="form-control"
                                                    placeholder="Enter your Username" value="<?= get_user()->username ?>">
                                                <span class="text-danger error-text username_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Bio</label>
                                        <textarea name="bio" cols="30" rows="10" class="form-control"
                                            placeholder="Enter your bio"><?= get_user()->bio ?></textarea>
                                        <span class="text-danger error-text bio_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="change_password" role="tabpanel">
                            <div class="pd-20 profile-task-wrap">
                                ---- Change Password Content ----
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    $('#personal_details_from').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var formdata = new FormData(form[0]);

        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: formdata,
            processData: false,
            dataType: 'json',
            contentType: false,
            beforeSend: function() {
                // Bersihkan pesan sebelumnya
                $('#form-messages').html('');
                form.find('span.error-text').text('');
            },
            success: function(response) {
                if (response.status === 1) {
                    // Jika berhasil, tampilkan pesan sukses
                    $('#form-messages').html(`
            <div class="alert alert-success">${response.msg}</div>
        `);
                    setTimeout(function() {
                        window.location.href = '<?= route_to("admin.profile") ?>'; // Redirect ke halaman profil
                    }, 2000);
                } else {
                    // Jika ada kesalahan validasi, tampilkan pesan kesalahan
                    $.each(response.error, function(prefix, val) {
                        form.find('span.' + prefix + '_error').text(val);
                    });
                    $('#form-messages').html(`
            <div class="alert alert-danger">Please fix the errors below.</div>
        `);
                }
            }

        });
    });
</script>
<?= $this->endSection() ?>