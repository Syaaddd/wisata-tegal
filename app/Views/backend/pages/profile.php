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
            <div class="row">
                <div class="profile-photo text-center">
                    <div class="profile-avatar mb-4">
                        <img src="<?= get_user()->picture == null ? '/images/users/default-avatar.png' : '/images/users/' . get_user()->picture ?>"
                            alt="User Avatar" class="avatar-photo ci-avatar-photo img-fluid">
                    </div>
                </div>

            </div>
            <div class="">
                <form action="<?= route_to('update-personal-picture') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="mt-3 mb-4">
                        <label for="user_profile_file" class="btn btn-primary w-100">Change Avatar</label>
                        <!-- <input type="file" name="user_profile_file" class="d-none" id="user_profile_file" accept="image/*"> -->
                        <input type="file" id="user_profile_file" accept="image/*" class="d-none" name="user_profile_file">

                    </div>
                    <div class="mt-3 mb-4">
                        <button type="submit" class="btn btn-success w-100">Upload Picture</button>
                    </div>


                </form>
            </div>
            <div class=" mt-4">
                <h5 class="text-center h5 mb-0"><?= get_user()->name ?></h5>
                <p class="text-center text-muted font-14"><?= get_user()->email ?></p>
            </div>
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
                        <!-- personal details content -->
                        <div class="tab-pane fade show active" id="personal_details" role="tabpanel">
                            <div class="pd-20">
                                <form action="<?= route_to('update-personal-details') ?>" method="POST" id="personal_details_form">
                                    <?= csrf_field() ?>
                                    <div id="form-messages">
                                        <?php if (session()->getFlashdata('success_details')): ?>
                                            <div class="alert alert-success">
                                                <?= session()->getFlashdata('success_details') ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (session()->getFlashdata('errors_details')): ?>
                                            <div class="alert alert-danger">
                                                <ul>
                                                    <?php foreach (session()->getFlashdata('errors_details') as $error): ?>
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
                        <!-- change password content -->
                        <div class="tab-pane fade" id="change_password" role="tabpanel">
                            <div class="pd-20 profile-task-wrap">
                                <form action="<?= route_to('change-password') ?>" method="POST" id="change_password_form">
                                    <?= csrf_field() ?>
                                    <div id="messages-password">
                                        <?php if (session()->getFlashdata('success_password')): ?>
                                            <div class="alert alert-success">
                                                <?= session()->getFlashdata('success_password') ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (session()->getFlashdata('errors_password')): ?>
                                            <div class="alert alert-danger">
                                                <ul>
                                                    <?php foreach (session()->getFlashdata('errors_password') as $error): ?>
                                                        <li><?= esc($error) ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" class="ci_csrf_token">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Current Password</label>
                                                <input type="password" class="form-control" name="current_password" placeholder="Enter your current password">
                                                <span class="text-danger error-text current_password_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">New Password</label>
                                                <input type="password" class="form-control" name="new_password" placeholder="Enter your new password">
                                                <span class="text-danger error-text new_password_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Confirm New Password</label>
                                                <input type="password" class="form-control" name="confirm_new_password" placeholder="Enter your new confirm">
                                                <span class="text-danger error-text confirm_new_password_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Changes Password</button>
                                    </div>
                                </form>
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
    $(document).ready(function() {
        let urlParams = new URLSearchParams(window.location.search);
        let activeTab = urlParams.get('tab');

        if (activeTab === 'password') {
            $('.nav-tabs a[href="#change_password"]').tab('show');
        } else {
            $('.nav-tabs a[href="#personal_details"]').tab('show');
        }
    });


    $('#personal_details_form').on('submit', function(e) {
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
            success: function(response) {
                if (response.status === 1) {
                    $('#form-messages').html(`<div class="alert alert-success">${response.msg}</div>`);
                    setTimeout(function() {
                        window.location.href = '<?= route_to("admin.profile") ?>';
                    }, 2000);
                } else {
                    $.each(response.error, function(prefix, val) {
                        form.find('span.' + prefix + '_error').text(val);
                    });
                }
            }
        });
    });

    $('#change_password_form').on('submit', function(e) {
        e.preventDefault();
        // alert('change password form submitted');
        var form = $(this);
        var formdata = new FormData(form[0]);

        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: formdata,
            processData: false,
            dataType: 'json',
            contentType: false,
            success: function(response) {
                if (response.status === 1) {
                    $('#messages-password').html(`<div class="alert alert-success">${response.msg}</div>`);
                    setTimeout(function() {
                        window.location.href = '<?= route_to("admin.profile") ?>';
                    }, 2000);
                } else {
                    $.each(response.error, function(prefix, val) {
                        form.find('span.' + prefix + '_error').text(val);
                    });
                }
            }
        });
    });

    let cropper;
    $('#user_profile_file').on('change', function(e) {
        let file = e.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event) {
                let image = document.getElementById('image-preview');
                image.src = event.target.result;
                image.style.display = 'block';
                // Destroy the previous cropper instance if it exists
                if (cropper) {
                    cropper.destroy();
                }
                cropper = new Cropper(image, {
                    aspectRatio: 1, // Set aspect ratio (1:1 for square)
                    viewMode: 1,
                    preview: '.preview',
                });
            };
            reader.readAsDataURL(file);
        }
    });

    $('#uploadButton').on('click', function() {
        let canvas = cropper.getCroppedCanvas();
        canvas.toBlob(function(blob) {
            let formData = new FormData();
            formData.append('croppedImage', blob);
            formData.append('csrf_token', '<?= csrf_hash() ?>');

            $.ajax({
                url: '<?= route_to('update-personal-picture') ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Handle success
                    toastr.success(response.message);
                },
                error: function() {
                    toastr.error('Image upload failed!');
                }
            });
        });
    });

    // $('#user_profile_file').ijaboCropTool({
    //     preview: '.ci-avatar-photo',
    //     setRatio: 1,
    //     allowedExtensions: ['jpg', 'jpeg', 'png'],
    //     processUrl: '<?= route_to('update-personal-picture') ?>',
    //     withCSRF: ['<?= csrf_token() ?>', '<?= csrf_hash() ?>'],
    //     onSuccess: function(message) {
    //         toastr.success(message);
    //     },
    //     onError: function(message) {
    //         toastr.error(message);
    //     }
    // });
</script>
<?= $this->endSection() ?>