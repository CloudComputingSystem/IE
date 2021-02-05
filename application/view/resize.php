<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cloud Computing System</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,900">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="<?php $this->asset('css/style.css'); ?>">
    <link rel="stylesheet" href="<?php $this->asset('css/bootstrap.min.css'); ?>">

</head>

<body>
<section class="about full-screen d-lg-flex justify-content-center align-items-center" id="about">
    <div class="container">
        <div class="row">
            <div class="wrapper">
                <h1>Resize 📷</h1>
            </div>

            <div class="col-lg-8 col-md-12 col-12">
                <a href="" download><img src="<?php echo $file['path'] ?>"></a>
            </div>

            <div class="col-lg-4 col-md-12 col-12">
                <form id="app" action="<?php $this->url('home/crop/' . $file['file_id']); ?>" method="post">
                    <div class="res">
                        <input type="number" id="width" name="width" placeholder="Width"
                               value="<?php echo $size['x']; ?>">
                        <span>&times;</span>
                        <input type="number" id="height" name="height" placeholder="Height"
                               value="<?php echo $size['y']; ?>">
                    </div>
                    <button id="button" class="btn btn-block login-btn  custom-btn custom-btn-bg custom-btn-link">
                        download
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<script src="<?php echo $this->asset('js/script.js'); ?>"></script>

</body>

</html>