<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
    <link href='<?php $this->asset('css/p.css') ?>' rel='stylesheet'>
    <link rel="stylesheet" href="<?php $this->asset('css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?php $this->asset('css/unicons.css') ?>">
    <link rel="stylesheet" href="<?php $this->asset('css/owl.carousel.min.css') ?>">
    <link rel="stylesheet" href="<?php $this->asset('css/owl.theme.default.min.css') ?>">
    <link rel="stylesheet" href="<?php $this->asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?php $this->asset('css/cropper.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/dropzone"></script>
    <script src="https://unpkg.com/cropperjs"></script>

    <!-- MAIN STYLE -->
    <link rel="stylesheet" href="<?php $this->asset('css/tooplate-style.css') ?>">


</head>

<body>
<nav class="navbar navbar-expand-sm navbar-light">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a href="#about" class="nav-link"><span data-hover="About">About</span></a>
                </li>
                <li class="nav-item">
                    <a href="#project" class="nav-link"><span data-hover="Projects">Projects</span></a>
                </li>
                <li class="nav-item">
                    <a href="#resume" class="nav-link"><span data-hover="Resume">Resume</span></a>
                </li>
                <li class="nav-item">
                    <a href="#contact" class="nav-link"><span data-hover="Contact">Contact</span></a>
                </li>
            </ul>
            <fieldset class="field-container">
                <form method="post" action="<?php $this->url('home/search'); ?>">
                    <input type="text" placeholder="Search..." class="field" id="text" name="text"/>
                    <div class="icons-container">
                        <div class="icon-search"></div>
                        <div class="icon-close">
                            <div class="x-up"></div>
                            <div class="x-down"></div>
                        </div>
                    </div>
                </form>

            </fieldset>
            <ul class="navbar-nav ml-lg-auto">
                <div class="ml-lg-4">
                    <div class="color-mode d-lg-flex justify-content-center align-items-center">
                        <i class="color-mode-icon"></i> Color mode
                    </div>
                </div>
            </ul>
        </div>
    </div>
</nav>

<!-- ABOUT -->
<section class="about full-screen d-lg-flex justify-content-center align-items-center" id="about">
    <div class="container mt-5 p-3 ">
        <div class="row no-gutters">
            <div class="col-md-3">
                <div class="payment-info">
                    <div class="card-container">
                        <div align="center">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="image_area">
                                        <form method="post" action="<?php $this->url('uploadProfile/upload'); ?>">
                                            <label for="upload_image">
                                                <img src="<?php $image_name = 'public\userProfile\\' . $_SESSION['userName'] . '.png';
                                                if (!file_exists($image_name))
                                                    $this->asset('userProfile/user.png');
                                                else $this->asset('userProfile/' . $_SESSION['userName'] . '.png'); ?>"
                                                     id="uploaded_image"
                                                     class="img-responsive img-circle"/>
                                                <div class="overlay">
                                                    <div class="text">Click to Change Profile Image</div>
                                                </div>
                                                <input type="file" name="image" class="image" id="upload_image"
                                                       style="display:none"/>
                                            </label>
                                        </form>
                                    </div>
                                </div>
                                <div class="modal fade" id="modal" tabindex="-1" role="dialog"
                                     aria-labelledby="modalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Crop Image Before Upload</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="img-container">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <img src="" id="sample_image"/>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="preview"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="crop" class="btn btn-primary">Crop</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    Cancel
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4><?php echo $_SESSION['userName']; ?></h4>
                        <p><?php echo $_SESSION['email']; ?></p>
                        <hr class="line">
                        <div>
                            <div class="wrapper">
                                <div class="container-chart chart" data-size="100"
                                     data-value="<?php echo $volume; ?>"
                                     data-arrow="up">
                                </div>
                            </div>
                        </div>
                        <hr class="line">
                        <div>
                            <form method='post' action='<?php $this->url('upload/uploadFile'); ?>' id="file-upload-form"
                                  class="uploader" enctype='multipart/form-data'>
                                <input id="file" type="file" name="file[]" multiple accept="image/*"/>

                                <label for="file" id="file-drag">
                                    <img id="file-image" src="#" alt="Preview" class="hidden">
                                    <div id="start">
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                        <div>Select a file or drag here</div>

                                        <input type='submit' name='submit' class="btn btn-primary" value='Upload'>

                                    </div>
                                </label>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9 col-sm-12 col-12">
                <div class="product-details mr-2">
                    <h6 class="mb-0">Files</h6>
                    <div class="d-flex justify-content-between"><span>You have <?php echo sizeof($files); ?> items in your storage</span>
                    </div>
                    <?php foreach ($files as $file) { ?>
                        <div class="d-flex justify-content-between align-items-center mt-3 p-2 items rounded white">
                            <div class="d-flex flex-row"><img
                                        src="<?php if ($file['content_type'] == 'application/pdf')
                                            $this->asset('images/pdf.png');
                                        else if ($file['content_type'] == 'image/png' or $file['content_type'] == 'image/jpg' or $file['content_type'] == 'image/jpeg')
                                            $this->asset('images\picture.png');
                                        else if ($file['content_type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
                                            $this->asset('images\Word-icon.png'); ?>"
                                        width="40">
                                <div class="ml-2"><span
                                            class="font-weight-bold d-block text-abstract"><?php echo $file['name']; ?></span>
                                </div>
                            </div>
                            <div class="d-flex flex-row align-items-center">
                                <span class="d-block ml-5 font-weight-bold"><?php if ($file['content_length'] == 0) echo "60 B"; else if ($file['content_length'] < 1024) echo intval($file['content_length']) . " KB";
                                    else if ($file['content_length'] < 1024 * 1024) echo intval($file['content_length'] / 1024) . " MB";
                                    else echo intval($file['content_length'] / (1024 * 1024)) . " GB"; ?>
                                </span>
                                <?php if ($file['content_type'] == 'image/png' or $file['content_type'] == 'image/jpg' or $file['content_type'] == 'image/jpeg') { ?>
                                    <a href="<?php $this->url('home/resize/' . $file['file_id']); ?>">
                                        <img class="icon-dvd icon-view1"
                                             src="<?php $this->asset('images/resize.png'); ?>"/>
                                    </a>
                                <?php } else { ?>
                                    <a class="icon-view"
                                       href="<?php $this->url('home/viewFile/' . $file['file_id']); ?>">
                                    </a>
                                <?php } ?>
<!--                                --><?php //if ($file['content_type'] == 'image/png' or $file['content_type'] == 'image/jpg' or $file['content_type'] == 'image/jpeg'
//                                    or $file['content_type'] == 'application/pdf' or $file['content_type']=='text/plain') { ?>
                                    <a href="<?php $this->url('home/viewFile/' . $file['file_id']); ?>">
                                        <img class="icon-dvd" src="<?php $this->asset('images/view.png'); ?>"/>
                                    </a>
                                <a href="<?php $this->url('download/file/' . $file['file_id']); ?>">
                                    <img class="icon-dvd" src="<?php $this->asset('images/download.png'); ?>"/>
                                </a>
                                <a href="<?php $this->url('edit/file/' . $file['file_id']); ?>">
                                    <img class="icon-dvd" src="<?php $this->asset('images/edit.png'); ?>"/>
                                </a>
                                <a href="<?php $this->url('delete/file/' . $file['file_id']); ?>">
                                    <img class="icon-dvd " src="<?php $this->asset('images/delete.png'); ?>"/>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?php $this->asset('js/jquery-3.3.1.min.js') ?>"></script>
<script src="<?php $this->asset('js/popper.min.js') ?>"></script>
<script src="<?php $this->asset('js/bootstrap.min.js') ?>"></script>
<script src="<?php $this->asset('js/Headroom.js') ?>"></script>
<script src="<?php $this->asset('js/jQuery.headroom.js') ?>"></script>
<script src="<?php $this->asset('js/owl.carousel.min.js') ?>"></script>
<script src="<?php $this->asset('js/smoothscroll.js') ?>"></script>
<script src="<?php $this->asset('js/custom.js') ?>"></script>
<script src="<?php $this->asset('js/script.js') ?>"></script>
<script>

    $(document).ready(function () {

        var $modal = $('#modal');

        var image = document.getElementById('sample_image');

        var cropper;

        $('#upload_image').change(function (event) {
            var files = event.target.files;

            var done = function (url) {
                image.src = url;
                $modal.modal('show');
            };

            if (files && files.length > 0) {
                reader = new FileReader();
                reader.onload = function (event) {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });

        $modal.on('shown.bs.modal', function () {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });

        $('#crop').click(function () {
            canvas = cropper.getCroppedCanvas({
                width: 400,
                height: 400
            });

            canvas.toBlob(function (blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function () {
                    var base64data = reader.result;
                    $.ajax({
                        url: '<?php $this->url('uploadProfile/upload'); ?>',
                        method: 'POST',
                        data: {image: base64data},
                        success: function (data) {
                            $modal.modal('hide');
                            $('#uploaded_image').attr('src', data);
                        }
                    });
                };
            });
        });

    });
</script>
</body>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>-->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
</html>