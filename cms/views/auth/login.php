<?php

ob_start();

#Database bağlantısı
include('../../../connection/connect.php');

#Giriş yapılmış ise anasayfaya yönlendir
if ($_COOKIE['loggedUser'] == "ok") {

    header('Location: ../index');
};

?>

<!doctype html>

<html lang="en" class="no-focus">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Maharethane CRM</title>
    <script charset="UTF-8" src="//web.webpushs.com/js/push/cac4c6d24a7374db329499efa099b76f_0.js" async></script>
    <link rel="shortcut icon" href="../assets/media/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="../assets/media/favicons/favicon-192x192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/media/favicons/apple-touch-icon-180x180.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700">
    <link rel="stylesheet" id="css-main" href="../assets/css/codebase.min.css">
</head>

<body>
    <div id="page-container" class="main-content-boxed">
        <main id="main-container">
            <div class="bg-image" style="background-image: url('../assets/media/photos/<?php echo rand(1, 9); ?>.jpg');">
                <div class="row mx-0 bg-black-op">
                    <div class="hero-static col-md-6 col-xl-8 d-none d-md-flex align-items-md-end">
                        <div class="p-30 invisible" data-toggle="appear">
                            <p class="font-size-h3 font-w600 text-white">
                                Maharethane Creative Agency
                            </p>
                            <p class="font-italic text-white-op">
                                Copyright &copy; <span class="js-year-copy"></span>
                            </p>
                        </div>
                    </div>
                    <div class="hero-static col-md-6 col-xl-4 d-flex align-items-center bg-white invisible" data-toggle="appear" data-class="animated fadeInRight" >
                        <div class="content content-full">
                            <div class="px-30 py-10">
                                <img src="../assets/media/img/logo.svg" style="width: 280px;">

                                <h1 class="h3 font-w700 mt-30 mb-10">CMS Yönetimi</h1>
                                <h2 class="h5 font-w400 text-muted mb-0">Lütfen Giriş Yapın</h2>
                            </div>

                            <form class="js-validation-signin px-30" method="post" action="../../operations/controllers/loginCheck">
                                <?=$csrf_token;?>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <div class="form-material floating">
                                            <input type="text" class="form-control" id="login-username" name="username" required="">
                                            <label for="login-username">Kullanıcı Adı</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <div class="form-material floating">
                                            <input type="password" class="form-control" id="login-password" name="password" required="">
                                            <label for="login-password">Şifre</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label class="css-control css-control-secondary css-checkbox">
                                            <input type="checkbox" class="css-control-input" name="session" checked="" value="checked">
                                            <span class="css-control-indicator"></span> Oturumu Açık Bırak
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-hero btn-secondary" name="loginCheck">
                                        <i class="si si-login mr-10"></i> Giriş Yap
                                    </button>
                                    <div class="mt-30">
                                        <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="#">
                                            <i class="fa fa-warning mr-5"></i> Şifremi Unuttum
                                        </a>
                                    </div>
                                </div>
                            </form>
                            <?php if ($_GET["err"] == 4) {  ?>
                                <table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td height="40" align="center" class="user-text">
                                            <div class="yuvarlak" style="background-color:#9ccc65; ">
                                                <span class="pe-7s-alarm" style=" font-size:30px; display: block; "> </span>
                                                <span style="padding-bottom:40px; color: #fff; padding: 10px;">Çıkış başarılı.</span>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            <?php  } ?>
                            <br />
                            <?php if ($_GET["err"] == 3) {  ?>
                                <table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td height="40" align="center" class="user-text">
                                            <div class="yuvarlak" style="background-color:#C00; ">
                                                <span class="pe-7s-alarm" style=" font-size:30px; display: block; "> </span>
                                                <span style="padding-bottom:40px; color: #fff; padding: 10px;">Panele ulaşmak için lütfen giriş yapın.</span>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            <?php  } ?>
                            <br />
                            <?php if ($_GET["err"] == 2) {  ?>
                                <table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td height="40" align="center" class="user-text">
                                            <div class="yuvarlak" style="background-color:#C00; ">
                                                <span class="pe-7s-alarm" style=" font-size:30px; display: block; "></span>
                                                <span style="padding-bottom:40px; color: #fff; padding: 10px;">Oturum Süresi Sona Erdi</span>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            <?php  } ?>
                            <br />
                            <?php if ($_GET["err"] == 1) {  ?><table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td height="40" align="center" class="user-text">
                                            <div class="yuvarlak" style="background-color:#C00; ">
                                                <span class="pe-7s-attention" style=" font-size:30px; display: block; "></span>
                                                <span style="padding-bottom:40px; padding: 10px; color: #fff;">Kullanıcı adı veya şifreniz Hatalı</span>
                                            </div>
                                        </td>
                                    </tr>
                                </table><br /><?php } ?>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>
    <script src="../assets/js/codebase.core.min.js"></script>
    <script src="../assets/js/codebase.app.min.js"></script>
    <script src="../assets/js/pages/op_auth_signin.min.js"></script>
    
</body>

</html>