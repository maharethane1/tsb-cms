<?php

$authPageName = "setting";
$activeClass = "popup";
$pageTitle = "Maharethane - Popup Ayarları";
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
                    <h1 class="font-w700 text-white mb-10">Pop-up ayarları</h1>
                    <h2 class="h4 font-w400 text-white-op">Web sitenizde bulunan pop-up ayarlarını buradan düzenleyebilirsiniz.</h2>
                </div>
            </div>
        </div>
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">POP-UP AYARLARI</h3>
                <div class="block-options">
                    <div class="block-options-item">

                    </div>
                </div>
            </div>
            <div class="block-content block-content-full">
                <form action="../operations/controllers/popupController.php" method="post" enctype="multipart/form-data">
                    
                    <?php 
                    
                    $getData = $db->prepare("SELECT * FROM tbl_site WHERE id=1");
                    $getData->execute();
                    $getSite = $getData->fetch(PDO::FETCH_ASSOC);
                    
                    ?>
                    <!-- email adress -->
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Başlık</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="baslik" placeholder="Lütfen doldurun" value="<?= $getSite['popup_baslik']?>">
                        </div>
                    </div>
                    
                    <!-- popup görsel alanı -->
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label" >Görsel</label>
                        <div class="col-lg-5">
                            <?php 
                            if ( $getSite['popup_gorsel']=="noimage.jpg" ) { ?>
                            
                            <img src="../../uploads/noimage.jpg" class="w-100 upload-slider"><br>

                            <?php 
                            }else {?>

                            <img src="../../uploads/<?= $getSite['popup_gorsel'] ?>" class="w-100 upload-slider"><br>

                            <?php }
                            ?>
                            
                            <div class="custom-file">
                                <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                <input type="file" class="custom-file-input" name="resim" size="42" accept="image/*" data-toggle="custom-file-input" oninput="imgSlider()">
                                <input type="hidden" name="old-image" value="<?= $getSite['popup_gorsel'] ?>">
                                <label class="custom-file-label" for="example-file-input-custom">Bir dosya seçin</label>
                            </div>
                        </div>
                    </div>

                    <!-- durum belirtme alanı(default aktif) -->
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Aktif</label>
                        <div class="col-lg-2" style="display: flex;">
                            <label class="css-control css-control-warning css-switch">
                                <input type="checkbox" class="css-control-input" name="aktif" value="1" checked>
                                <span class="css-control-indicator"></span> Pop-up Aktif
                            </label>
                        </div>
                    </div>

                    <!-- validation error message -->
                    <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
            </div>
            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                <div class="block-options">
                    <div class="block-options-item">
                    <button type="submit" name="update" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                    <a href="pop-up-ayarlari"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
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