<?php

$authPageName = "setting";
$activeClass = "site";
$pageTitle = "Maharethane - Site Ayarları";
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
                    <h1 class="font-w700 text-white mb-10">Site ayarları</h1>
                    <h2 class="h4 font-w400 text-white-op">Web sitenizin genel ayarlarını buradan düzenleyebilirsiniz.</h2>
                </div>
            </div>
        </div>
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">SİTE GENEL AYARLARI</h3>
                <div class="block-options">
                    <div class="block-options-item">

                    </div>
                </div>
            </div>
            <div class="block-content block-content-full">
                <form action="../operations/controllers/siteController" method="post" >
                    
                    <?php 
                    
                    $getData = $db->prepare("SELECT * FROM tbl_site WHERE id=1");
                    $getData->execute();
                    $getSite = $getData->fetch(PDO::FETCH_ASSOC);
                    
                    ?>
                    <!-- application title -->
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Site Başlığı (title)</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="site_baslik" placeholder="Lütfen doldurun" value="<?= $getSite['site_baslik']?>">
                        </div>
                    </div>
                    <!-- application description -->
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Site Açıklama (description)</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" name="site_aciklama" rows="5" placeholder="Lütfen doldurun"><?= $getSite['site_aciklama']?></textarea>
                        </div>
                    </div>
                    <!-- application link -->
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Site Link</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="link" placeholder="Lütfen doldurun" value="<?= $getSite['link']?>">
                        </div>
                    </div>
                    <!-- application tags -->
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Site Etiket</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="site_etiket" placeholder="Lütfen doldurun" value="<?= $getSite['site_etiket']?>">
                        </div>
                    </div>
                    <!-- google analytics api -->
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Google Analytics API</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="google_analytic" placeholder="Lütfen doldurun" value="<?= $getSite['google_analytic']?>">
                        </div>
                    </div>

                    <?php 
                    
                    if($authorization=="admin"){?>

                    
                    <!-- application langauges -->
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Dil Ayarları</label>
                        <div class="col-lg-2" style="display: flex;">
                            <label class="css-control css-control-warning css-switch">
                                <input type="checkbox" class="css-control-input" name="turkce" value="1" <?php if($getSite['turkce']==1) {echo "checked";} ?>>
                                <span class="css-control-indicator"></span> Türkçe
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label"></label>
                        <div class="col-lg-2" style="display: flex;">
                            <label class="css-control css-control-warning css-switch">
                                <input type="checkbox" class="css-control-input" name="ingilizce" value="1" <?php if($getSite['ingilizce']==1) {echo "checked";} ?>>
                                <span class="css-control-indicator"></span> İngilizce
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label"></label>
                        <div class="col-lg-2" style="display: flex;">
                            <label class="css-control css-control-warning css-switch">
                                <input type="checkbox" class="css-control-input" name="fransizca" value="1" <?php if($getSite['fransizca']==1) {echo "checked";} ?>>
                                <span class="css-control-indicator"></span> Fransızca
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label"></label>
                        <div class="col-lg-2" style="display: flex;">
                            <label class="css-control css-control-warning css-switch">
                                <input type="checkbox" class="css-control-input" name="ispanyolca" value="1" <?php if($getSite['ispanyolca']==1) {echo "checked";} ?>>
                                <span class="css-control-indicator"></span> İspanyolca
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label"></label>
                        <div class="col-lg-2" style="display: flex;">
                            <label class="css-control css-control-warning css-switch">
                                <input type="checkbox" class="css-control-input" name="arapca" value="1" <?php if($getSite['arapca']==1) {echo "checked";} ?>>
                                <span class="css-control-indicator"></span> Arapça
                            </label>
                        </div>
                    </div>

                    <?php }

                    ?>
                    <!-- application langauges end-->

                    <!-- validation error message -->
                    <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                    <div class="block-options">
                        <div class="block-options-item">
                        <button type="submit" name="update" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                        <a href="site-ayarlari"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
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