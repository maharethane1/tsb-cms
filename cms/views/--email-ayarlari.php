<?php

$authPageName = "setting";
$activeClass = "email";
$pageTitle = "Maharethane - E-mail Ayarları";
include('layouts/header.php');
include('../operations/middleware/AuthorizationMiddleware.php');
$perform = $_GET['perform'];
$contentID = $_GET['id'];

?>

<script type="text/javascript">
    function invalidFunction(e, message) {
        e.preventDefault();
        document.getElementById('hataMesaji').innerText = message;
        document.getElementById('hataMesaji').className = "badge badge-danger";
    }
</script>

<main id="main-container">
    <!-- Page Content -->
    <div class="content">
        <div class="block block-transparent bg-video" data-vide-bg="assets/media/videos/city_night" data-vide-options="posterType: jpg" style="position: relative;"><div style="position: absolute; z-index: -1; inset: 0px; overflow: hidden; background-size: cover; background-color: transparent; background-repeat: no-repeat; background-position: 50% 50%; background-image: none;"><video autoplay="" loop="" muted="" style="margin: auto; position: absolute; z-index: -1; top: 50%; left: 50%; transform: translate(-50%, -50%); visibility: visible; opacity: 1; width: 1154px; height: auto;"><source src="assets/media/videos/city_night.mp4" type="video/mp4"><source src="assets/media/videos/city_night.webm" type="video/webm"><source src="assets/media/videos/city_night.ogv" type="video/ogg"></video></div>
            <div class="block-content bg-primary-dark-op">
                <div class="py-20 text-center">
                    <h1 class="font-w700 text-white mb-10">E-mail ayarları</h1>
                    <h2 class="h4 font-w400 text-white-op">Web sitenizin smtp e-mail ayarlarını buradan düzenleyebilirsiniz.</h2>
                </div>
            </div>
        </div>
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">E-MAIL AYARLARI</h3>
                <div class="block-options">
                    <div class="block-options-item">

                    </div>
                </div>
            </div>
            <div class="block-content block-content-full">
                <form action="../operations/controllers/emailController.php" method="post" >
                    
                    <?php 
                    
                    $getData = $db->prepare("SELECT * FROM tbl_site WHERE id=1");
                    $getData->execute();
                    $getSite = $getData->fetch(PDO::FETCH_ASSOC);
                    
                    ?>
                    <!-- smtp adress-->
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">SMTP</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="php_email_smtp" placeholder="Lütfen doldurun" value="<?= $getSite['php_email_smtp']?>">
                        </div>
                    </div>
                    <!-- port number -->
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Port</label>
                        <div class="col-lg-10">
                            <input type="number" class="form-control" name="php_email_port" placeholder="Lütfen doldurun" value="<?= $getSite['php_email_port']?>">
                        </div>
                    </div>
                    <!-- smptp mail adress -->
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">E-mail</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="php_email_adres" placeholder="Lütfen doldurun" value="<?= $getSite['php_email_adres']?>">
                        </div>
                    </div>
                    <!-- smtp mail password -->
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Parola</label>
                        <div class="col-lg-10">
                            <input type="password" class="form-control" name="php_email_sifre" placeholder="Lütfen doldurun" value="<?= $getSite['php_email_sifre']?>">
                        </div>
                    </div>
                    <!-- Fax number -->
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Güvenlik</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="php_email_guvenlik" placeholder="Lütfen doldurun" value="<?= $getSite['php_email_guvenlik']?>">
                        </div>
                    </div>
                    <!-- validation error message -->
                    <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                    
            </div>
            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                <div class="block-options">
                    <div class="block-options-item">
                    <button type="submit" name="update" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                    <a href="email-ayarlari"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</main>

<?php

include('layouts/footer.php');

?>