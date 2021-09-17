<?php

ob_start();

session_start();

include("../../connection/connect.php");
require_once('../operations/middleware/AuthMiddleware.php');

#Üye bilgilerini tanımlı cookielerden al
$userID = $_COOKIE['userID'];
$userName = $_COOKIE['userName'];
$userTitle = $_COOKIE['userTitle'];
$userImg = $_COOKIE['userImg'];
$english = $_COOKIE['english'];
$turkish = $_COOKIE['turkish'];
$germany = $_COOKIE['germany'];
$spanish = $_COOKIE['spanish'];
$arabic = $_COOKIE['arabic'];
$french = $_COOKIE['french'];

$authorization = $_COOKIE['authorization'];

$authPage = $_COOKIE['authPage'];
$authCont = $_COOKIE['authCont'];
$authSetting = $_COOKIE['authSetting'];



?>

<!doctype html>
<html lang="tr" class="no-focus">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title> <?php echo $pageTitle; ?> </title>
    <script charset="UTF-8" src="//web.webpushs.com/js/push/cac4c6d24a7374db329499efa099b76f_0.js" async></script>
    <link rel="shortcut icon" href="assets/media/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/media/favicons/favicon-192x192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/media/favicons/apple-touch-icon-180x180.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700">
    <link rel="stylesheet" id="css-main" href="assets/css/codebase.min.css">
    <link rel="stylesheet" href="assets/js/plugins/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="assets/js/plugins/datatables/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>
    <div id="page-container" class="sidebar-o enable-page-overlay side-scroll page-header-glass page-header-inverse main-content-boxed">
        <nav id="sidebar">
            <div class="sidebar-content">
                <div class="content-header content-header-fullrow px-15">
                    <div class="content-header-section sidebar-mini-visible-b">
                        <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                            <span class="text-dual-primary-dark">c</span><span class="text-primary">b</span>
                        </span>
                    </div>
                    <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                        <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                            <i class="fa fa-times text-danger"></i>
                        </button>
                        <div class="content-header-item">
                            <img src="../views/assets/media/img/logo.svg" style="height: 35px;">
                        </div>
                    </div>
                </div>
                <div class="content-side content-side-full content-side-user px-10 align-parent">
                    <div class="sidebar-mini-visible-b align-v animated fadeIn">
                        <img class="img-avatar img-avatar32" src="assets/media/avatars/avatar15.jpg" alt="">
                    </div>
                    <div class="sidebar-mini-hidden-b text-center">

                        <img src="../../uploads/<?php echo $_COOKIE['userImg']; ?>" class="yuvarlak img-avatar" width="38" height="38" />

                        <ul class="list-inline mt-10">
                            <li class="list-inline-item">
                                <b><?php echo $userName ?></b>

                            </li>

                            <li class="list-inline-item">
                                <a class="link-effect text-dual-primary-dark" href="../operations/controllers/logout">
                                    <i class="si si-logout"></i>
                                </a>
                            </li>
                            <br><span style="font-size: 11px;"><?php echo $userTitle ?></span>
                        </ul>
                    </div>
                </div>
                <div class="content-side content-side-full">
                    <ul class="nav-main">
                        <li>
                            <a href="index" class="<?php if($activeClass=="index"){echo "active";} ?>"><i class="si si-cup"></i><span class="sidebar-mini-hide">Ana Sayfa</span></a>
                        </li>
                        <?php

                        if($authPage==1){?>

                        <li class="nav-main-heading"><span class="sidebar-mini-visible">SİTE İÇERİK YÖNETİMİ</span><span class="sidebar-mini-hidden">SAYFA YÖNETİMİ</span></li>

                        <li><a href="ana-sayfa" class="<?php if($activeClass=="anasayfa"){echo "active";} ?>"><i class="si si-briefcase"></i><span class="sidebar-mini-hide">Ana Sayfa Yönetimi</span></a></li>
                        <li><a href="kurumsal" class="<?php if($activeClass=="kurumsal"){echo "active";} ?>"><i class="si si-briefcase"></i><span class="sidebar-mini-hide">Kurumsal Yönetimi</span></a></li>
                        <li><a href="sektorler" class="<?php if($activeClass=="sektorler"){echo "active";} ?>"><i class="si si-briefcase"></i><span class="sidebar-mini-hide">Sektörler Yönetimi</span></a></li>
                        <!--<li><a href="cozumler" class="<?php /*if($activeClass=="cozumler"){echo "active";} */?>"><i class="si si-briefcase"></i><span class="sidebar-mini-hide">Çözümler Yönetimi</span></a></li>-->

                        <?php }

                        if($authCont==1){?>

                        <li class="nav-main-heading"><span class="sidebar-mini-visible">SİTE İÇERİK YÖNETİMİ</span><span class="sidebar-mini-hidden">İÇERİK YÖNETİMİ</span></li>
                        <!--<li class="<?php /*if($activeClass=="ekip" OR $activeClass=="departman" ){echo "open";} */?>">
                            <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-users"></i><span class="sidebar-mini-hide">Ekip Yönetimi</span></a>
                            <ul>
                                <li><a class="<?php /*if($activeClass=="ekip"){echo "active";} */?>"href="ekip-yonetimi">Ekip Üyeleri</a></li>
                                <li><a class="<?php /*if($activeClass=="departman"){echo "active";} */?>"href="departman-ayarlari">Departman Ayarları</a></li>
                            </ul>
                        </li>-->
                        <li class="<?php if($activeClass=="ik-basvurular" OR $activeClass=="ik-acik-pozisyonlar" ){echo "open";} ?>">
                            <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-users"></i><span class="sidebar-mini-hide">İK Yönetimi</span></a>
                            <ul>
                                <li><a class="<?php if($activeClass=="ik-basvurular"){echo "active";} ?>"href="ik-basvurular">Başvurular</a></li>
                                <li><a class="<?php if($activeClass=="ik-acik-pozisyonlar"){echo "active";} ?>"href="ik-acik-pozisyonlar">Açık Pozisyonlar</a></li>
                            </ul>
                        </li>
                        <!--<li><a href="haberler" class="<?php /*if($activeClass=="haberler"){echo "active";} */?>"><i class="si si-briefcase"></i><span class="sidebar-mini-hide">Haber Yönetimi</span></a></li>-->
                        <!--<li><a href="slider" class="<?php /*if($activeClass=="slider"){echo "active";} */?>"><i class="si si-screen-desktop"></i><span class="sidebar-mini-hide">Slider Yönetimi</span></a></li>-->
                        <!--<li><a href="galeri" class="<?php /*if($activeClass=="gallery"){echo "active";} */?>"><i class="si si-camera"></i><span class="sidebar-mini-hide">Galeri Yönetimi</span></a></li>-->
                        <!--<li><a href="subeler" class="<?php /*if($activeClass=="gallery"){echo "sube";} */?>"><i class="si si-home"></i><span class="sidebar-mini-hide">Şube Yönetimi</span></a></li>-->
                        <!--<li class="<?php /*if($activeClass=="portfolio" OR $activeClass=="portfoliocat" OR $activeClass=="portfoliocomp"){echo "open";} */?>">
                            <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-puzzle"></i><span class="sidebar-mini-hide">Portfolio Yönetimi</span></a>
                            <ul>
                                <li><a class="<?php /*if($activeClass=="portfolio"){echo "active";} */?>"href="portfolio">Sayfa Yönetimi</a></li>
                                <li><a class="<?php /*if($activeClass=="portfoliocat"){echo "active";} */?>" href="portfolio-kategori">Kategori Yönetimi</a></li>
                            </ul>
                        </li>-->
                        <!--<li class="<?php /*if($activeClass=="kategoriler" OR $activeClass=="altkategoriler" OR $activeClass=="urunler"){echo "open";} */?>">
                            <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-grid"></i><span class="sidebar-mini-hide">Ürün Yönetimi</span></a>
                            <ul>
                                <li><a class="<?php /*if($activeClass=="urunler"){echo "active";} */?>"href="urunler">Ürünler</a></li>
                                <li><a class="<?php /*if($activeClass=="kategoriler"){echo "active";} */?>" href="kategori">Kategori Yönetimi</a></li>
                                <li><a class="<?php /*if($activeClass=="altkategoriler"){echo "active";} */?>"href="alt-kategori">Alt Kategori Yönetimi</a></li>
                            </ul>
                        </li>-->
                        <li class="<?php if($activeClass=="hizmetkategori" OR $activeClass=="hizmetaltkategori" OR $activeClass=="hizmet"){echo "open";} ?>">
                            <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-grid"></i><span class="sidebar-mini-hide">Haber Yönetimi</span></a>
                            <ul>
                                <li><a class="<?php if($activeClass=="hizmet"){echo "active";} ?>"href="haber">Haberler</a></li>
                                <li><a class="<?php if($activeClass=="hizmetkategori"){echo "active";} ?>" href="haber-kategori">Kategori Yönetimi</a></li>
                                <!--<li><a class="<?php /*if($activeClass=="hizmetaltkategori"){echo "active";} */?>"href="hizmet-alt-kategori">Alt Kategori Yönetimi</a></li>-->
                            </ul>
                        </li>
                            <li><a href="urunler" class="<?php if($activeClass=="urunler"){echo "active";} ?>"><i class="si si-grid"></i><span class="sidebar-mini-hide">Ürün Yönetimi</span></a></li>
                            <li><a href="dokuman" class="<?php if($activeClass=="slider"){echo "active";} ?>"><i class="si si-grid"></i><span class="sidebar-mini-hide">Döküman Yönetimi</span></a></li>

                        <?php }

                        if($authSetting==1){?>

                        <li class="nav-main-heading"><span class="sidebar-mini-visible">SİTE</span><span class="sidebar-mini-hidden">SİTE YÖNETİMİ</span></li>
                        <li class="<?php if($activeClass=="site" OR $activeClass=="iletisim" OR $activeClass=="email" OR $activeClass=="sosyal" OR $activeClass=="popup"){echo "open";} ?>">
                            <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-settings"></i><span class="sidebar-mini-hide">Genel Ayarlar</span></a>
                            <ul>
                                <li><a class="<?php if($activeClass=="site"){echo "active";} ?>"href="site-ayarlari">Site Ayarları</a></li>
                                <li><a class="<?php if($activeClass=="iletisim"){echo "active";} ?>"href="iletisim-ayarlari">İletişim Ayarları</a></li>
                                <li><a class="<?php if($activeClass=="email"){echo "active";} ?>"href="email-ayarlari">E-mail Ayarları</a></li>
                                <li><a class="<?php if($activeClass=="sosyal"){echo "active";} ?>"href="sosyal-medya-ayarlari">Sosyal Medya Ayarları</a></li>
                                <li><a class="<?php if($activeClass=="popup"){echo "active";} ?>"href="pop-up-ayarlari">Pop-up Ayarları</a></li>
                            </ul>
                        </li>
                        <!--<li>
                            <a href="bulten-ayarlari" class="<?php /*if($activeClass=="bulten"){echo "active";} */?>"><i class="si si-paper-plane"></i><span class="sidebar-mini-hide">E-posta Bülten Yönetimi</span></a>
                        </li>-->
                        <li>
                            <a href="musteri-memnuniyeti" class="<?php if($activeClass=="yorumlar"){echo "active";} ?>"><i class="si si-bubbles"></i><span class="sidebar-mini-hide">Müşteri memnuniyeti</span></a>
                        </li>

                        <?php }


                        if($authorization=="admin") {?>

                        <li class="nav-main-heading"><span class="sidebar-mini-visible">KULLANICILAR</span><span class="sidebar-mini-hidden">CMS YÖNETİMİ</span></li>
                        <li><a href="admin-yonetimi" class="<?php if($activeClass=="admin"){echo "active";} ?>"><i class="si si-user"></i><span class="sidebar-mini-hide">Admin Yönetimi</span></a></li>
                        <li><a href="log" class="<?php if($activeClass=="log"){echo "active";} ?>"><i class="fa fa-list-alt"></i><span class="sidebar-mini-hide">Log Kayıtları</span></a></li>

                        <?php }

                        ?>
                    </ul>
                </div>
            </div>
        </nav>
        <header id="page-header">
            <div class="mobil-gizle">
                <div class="content-header">
                    <div class="content-header-section">
                        <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="sidebar_toggle">
                            <i class="fa fa-navicon"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div id="page-header-loader" class="overlay-header bg-primary">
                <div class="content-header content-header-fullrow text-center">
                    <div class="content-header-item">
                        <i class="fa fa-sun-o fa-spin text-white"></i>
                    </div>
                </div>
            </div>
        </header>