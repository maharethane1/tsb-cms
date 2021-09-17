<?php 

if ($_GET['error']=="400" ) { 

    $errorType = 400;
    $errorHead = "Hata";
    $errorDescription = "Beklenmeyen bir hata oluştu";

 }

?>


<!doctype html>
<html lang="en" class="no-focus">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Hata</title>
        <meta name="description" content="Codebase - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">
        <meta property="og:title" content="Codebase - Bootstrap 4 Admin Template &amp; UI Framework">
        <meta property="og:site_name" content="Codebase">
        <meta property="og:description" content="Codebase - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
        <meta property="og:type" content="website">
        <meta property="og:url" content="">
        <meta property="og:image" content="">
        <link rel="shortcut icon" href="../assets/media/favicons/favicon.png">
        <link rel="icon" type="image/png" sizes="192x192" href="../assets/media/favicons/favicon-192x192.png">
        <link rel="apple-touch-icon" sizes="180x180" href="../assets/media/favicons/apple-touch-icon-180x180.png">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700">
        <link rel="stylesheet" id="css-main" href="../assets/css/codebase.min.css">
    </head>
    <body>
        <div id="page-container" class="main-content-boxed">
            <main id="main-container">
                <div class="hero bg-white">
                    <div class="hero-inner">
                        <div class="content content-full">
                            <div class="py-30 text-center">
                                <div class="display-3 text-warning"><?php echo $errorType ?></div>
                                <h1 class="h2 font-w700 mt-30 mb-10"><?php echo $errorHead ?></h1>
                                <h2 class="h3 font-w400 text-muted mb-50"><?php echo $errorDescription ?></h2>
                                <a class="btn btn-hero btn-rounded btn-alt-secondary" href="javascript:javascript:history.go(-1)">
                                    <i class="fa fa-arrow-left mr-10"></i> Geri dön
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <script src="../assets/js/codebase.core.min.js"></script>
        <script src="../assets/js/codebase.app.min.js"></script>
    </body>
</html>