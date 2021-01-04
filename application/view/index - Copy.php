<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CodePen - Unsplash Resize URL</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="./style.css">

</head>

<body>
    <!-- partial:index.partial.html -->
    <div class="container">
        <div class="row">
            <div class="wrapper">
                <h1> Resize 📷</h1>
                <p>Use the fields to input an unsplash URL, your desired width and height. Drag the image to your desktop or use the link to download it! 🤞</p>
                <div class="col-lg-9 col-md-12 col-12 d-flex align-items-center">
                    <a href="" download></a>
                    <img src="">
                </div>

                <div class="col-lg-3 col-md-12 col-12">
                    <form id="app">
                        <input type="text" id="url" placeholder="URL" value="https://unsplash.com/photos/P8PlK2nGwqA">
                        <div class="res">
                            <input type="number" id="width" placeholder="Width" value="1920">
                            <span>&times;</span>
                            <input type="number" id="height" placeholder="Height" value="1080">
                        </div>
                    </form>
                </div>


            </div>

        </div>
    </div>
    <script src="./script.js"></script>

</body>

</html>