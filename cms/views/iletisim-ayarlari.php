<?php

$authPageName = "setting";
$activeClass = "iletisim";
$pageTitle = "Maharethane - İletişim Ayarları";
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
                    <h1 class="font-w700 text-white mb-10">İletişim ayarları</h1>
                    <h2 class="h4 font-w400 text-white-op">Web sitenizde bulunan iletişim bilgilerini buradan düzenleyebilirsiniz.</h2>
                </div>
            </div>
        </div>
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">İLETİŞİM AYARLARI</h3>
                <div class="block-options">
                    <div class="block-options-item">

                    </div>
                </div>
            </div>
            <div class="block-content block-content-full">
                <form action="../operations/controllers/iletisimController.php" method="post" >
                    
                    <?php 
                    
                    $getData = $db->prepare("SELECT * FROM tbl_site WHERE id=1");
                    $getData->execute();
                    $getSite = $getData->fetch(PDO::FETCH_ASSOC);
                    
                    ?>
                    <!-- email adress -->
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">E-mail</label>
                        <div class="col-lg-10">
                            <input type="email" class="form-control" name="email" placeholder="Lütfen doldurun" value="<?= $getSite['email']?>">
                        </div>
                    </div>
                    <!-- phone number -->
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Telefon</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="telefon" placeholder="Lütfen doldurun" value="<?= $getSite['telefon']?>">
                        </div>
                    </div>
                    <!-- GSM number -->
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">GSM</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="gsm" placeholder="Lütfen doldurun" value="<?= $getSite['gsm']?>">
                        </div>
                    </div>
                    <!-- Fax number -->
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Fax</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="fax" placeholder="Lütfen doldurun" value="<?= $getSite['fax']?>">
                        </div>
                    </div>
                    <!-- adress -->
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Adres</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" name="adres" rows="5" placeholder="Lütfen doldurun"><?= $getSite['adres']?></textarea>
                        </div>
                    </div>
                    <!-- validation error message -->
                    <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                    
            </div>
            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                    <div class="block-options">
                        <div class="block-options-item">
                        <button type="submit" name="update" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                        <a href="iletisim-ayarlari"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
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