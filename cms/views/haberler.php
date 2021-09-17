<?php

$authPageName = "content";
$activeClass ="haberler";
$pageTitle = "Maharethane - Haberler Yönetimi";
include('layouts/header.php');
include('../operations/middleware/AuthorizationMiddleware.php');
$perform = $_GET['perform'];
$contentID = $_GET['id'];
$controllerName="haberler";

?>



<script type="text/javascript">

    var fileobj;

    function upload_file(e) {
        e.preventDefault();
        for (i = 0; i < e.dataTransfer.files.length; i++) {
            fileobj = e.dataTransfer.files[i];
            ajax_file_upload(fileobj);
        }
    }

    function file_explorer() {
        document.getElementById('selectfile').click();
        document.getElementById('selectfile').onchange = function() {
            for (var i = 0; i < this.files.length; i++) {
                fileobj = document.getElementById('selectfile').files[i];
                ajax_file_upload(fileobj);
            }
        };
    }

    function ajax_file_upload(file_obj) {
        if (file_obj != undefined) {
            var form_data = new FormData();
            form_data.append('file', file_obj);
            form_data.append('imageUpload', '');
            form_data.append('contentID', <?= $contentID ?>);
            form_data.append('pageName', 'haberler');
            form_data.append('performName', 'Haberler sayfa yönetimi');
            form_data.append('columnName', 'haber_id');
            $.ajax({
                type: 'POST',
                url: '../operations/controllers/imageUploadController.php',
                contentType: false,
                processData: false,
                data: form_data,
                success: function(data) {
                    $('#bilgiver').append(data);
                    $("#tamamalandı").show();
                    $("#bilgiver").show();
                    $("#tamamalandı").delay(1000).fadeOut(500);
                    $('#selectfile').val('');
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    }

    function goBack() {
        window.history.back();
    }

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
                    <h1 class="font-w700 text-white mb-10">Haber Yönetimi</h1>
                    <h2 class="h4 font-w400 text-white-op">Haberler sayfası içeriklerini bu alandan yönetebilirsiniz.</h2>
                </div>
            </div>
        </div>
        <?php
        #Aksiyon olmadan sayfa açılımı
        if ($perform == "" or $perform == NULL) { ?>
            <!-- Kayıtlı içerikleri görüntüleme -->
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">İÇERİKLER</h3>
                    <div class="block-options">
                        <div class="block-options-item">
                            <a href="?perform=add"> <button class="btn btn-sm btn-hero btn-outline-secondary"> YENİ EKLE</button></a>
                        </div>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <!-- DataTables functionality is initialized with .js-dataTable-full class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                    <table id="sort" class="table table-bordered table-striped table-vcenter js-dataTable-full background-white">
                        <thead>
                            <tr>
                                <th class="text-center d-none d-sm-table-cell" style="width: 20%;">Dil Durum</th>
                                <th>Haber Başlık</th>
                                <th class="d-none d-sm-table-cell" style="width: 5%;">Durum</th>
                                <th class="text-center" style="width: 15%;">İşlem</th>
                                <th class="text-center" style="width: 5%;">Taşı</th>
                            </tr>
                        </thead>
                        <tbody id="sortItems">

                            <?php
                            #Sayfa bilgilerini database den çek
                            $pageData = $db->prepare("SELECT * FROM tbl_haberler ORDER BY sira ASC");
                            $pageData->execute();

                            #Sorguya uygun kayıtları döngüye al
                            while ($getData = $pageData->fetch(PDO::FETCH_ASSOC)) { ?>

                                <tr data-id="<?= $getData['id']?>">
                                    <td class="font-w600  d-none d-sm-table-cell text-center">
                                        <span class="badge  <?php if ($getData['aktif_tr'] == 1) {echo "badge-success";} else {echo "badge-danger";} ?>">TR</span>
                                        <span class="badge  <?php if ($getData['aktif_en'] == 1) {echo "badge-success";} else {echo "badge-danger";} ?>">EN</span>
                                        <span class="badge  <?php if ($getData['aktif_es'] == 1) {echo "badge-success";} else {echo "badge-danger";} ?>">ES</span>
                                        <span class="badge  <?php if ($getData['aktif_fr'] == 1) {echo "badge-success";} else {echo "badge-danger";} ?>">FR</span>
                                        <span class="badge  <?php if ($getData['aktif_ar'] == 1) {echo "badge-success";} else {echo "badge-danger";} ?>">AR</span>
                                    </td>
                                    <td class="font-w600"><?= $getData['baslik_tr'] ?> </td>
                                    <td class="font-w600 d-none d-sm-table-cell"><span class="badge  <?php if($getData['aktif']==1){echo "badge-info";}elseif($getData['aktif']==0){echo "badge-danger";} ?>"><?php if($getData['aktif']==1){echo "Aktif";}elseif($getData['aktif']==0){echo "Pasif";} ?></span></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="?perform=edit&id=<?= $getData["id"] ?>"><button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="İçerik Düzenle" data-placement="bottom">
                                                    <i class="fa fa-pencil"></i>
                                                </button></a>
                                            <a href="?perform=foto&id=<?= $getData["id"] ?>&pageName=haberler"><button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Galeri" data-placement="bottom">
                                                    <i class="fa fa-photo"></i>
                                                </button></a>
                                            <a href="../operations/controllers/haberlerController?perform=delete&id=<?= $getData["id"]; ?>&adi=<?= $getData["baslik_tr"]; ?>" onclick="return confirm('<?= $getData['baslik_tr']; ?> Adlı Kaydı Silmek İstediğinize Eminmisiniz? ')">
                                            <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="İçeriği Sil" data-placement="bottom">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="handle-sort text-center"><i class="fa fa-arrows" aria-hidden="true"></i></td>
                                </tr>

                            <?php }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php }

        #Content Ekleme alanı ($_GET['perform']=="add" ise aşağıdaki kod bloğu çalışacak)
        if ($perform == "add") { ?>
            <div class="block block-fx-shadow">
                <div class="block">
                    <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                        <!-- Türkçe aktif ise -->
                        <?php if ($turkish == "on") { ?>
                            <li class="nav-item"><a class="nav-link active" href="#turkce" style="padding: 20px;">TÜRKÇE</a> </li>
                        <?php } ?>
                        <!-- İngilizce aktif ise -->
                        <?php if ($english == "on") { ?>
                            <li class="nav-item"> <a class="nav-link " href="#ingilizce" style="padding: 20px;">
                                    <span class="sidebar-mini-visible">İNG</span><span class="sidebar-mini-hidden">İNGİLİZCE</span></a></li>
                        <?php } ?>
                        <!-- İspanyolca aktif ise -->
                        <?php if ($spanish == "on") { ?>
                            <li class="nav-item"> <a class="nav-link " href="#ispanyolca" style="padding: 20px;">İSPANYOLCA</a></li>
                        <?php } ?>
                        <!-- Fransızca aktif ise -->
                        <?php if ($french == "on") { ?>
                            <li class="nav-item"> <a class="nav-link " href="#fransizca" style="padding: 20px;">FRANSIZCA</a></li>
                        <?php } ?>
                        <!-- Arapça aktif ise -->
                        <?php if ($arabic == "on") { ?>
                            <li class="nav-item"> <a class="nav-link " href="#arapca" style="padding: 20px;">ARAPÇA</a></li>
                        <?php } ?>

                        <!-- Geri dönme butonu -->
                        <li class="nav-item ml-auto">
                            <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()" style="margin: 10px;  padding: 10px;">GERİ DÖN</button>
                        </li>
                    </ul>
                    <div class="block-content tab-content">
                        <!-- Türkçe content ekleme alanı -->
                        <?php if ($turkish == "on") { ?>
                            <div class="tab-pane active" id="turkce" role="tabpanel">
                                <form action="../operations/controllers/haberlerController" method="post" name="addPage" id="cpr" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <div class="col-6">
                                            <label class="css-control css-control-warning css-switch">
                                                <input type="checkbox" class="css-control-input" name="aktif_tr" value="1" checked>
                                                <span class="css-control-indicator"></span> Türkçe İçerik Aktif
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" for="example-hf-email">Başlık</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" id="example-hf-email" name="baslik_tr" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" for="example-hf-email">İçerik</label>
                                        <div class="col-lg-10">
                                            <textarea class="js-summernote" id="example-textarea-input" name="icerik_tr" rows="6" placeholder="İçerik açıklaması.."> </textarea>
                                        </div>
                                    </div>
                            </div>
                        <?php } ?>

                        <!-- İngilizce content düzenleme alanı -->
                        <?php if ($english == "on") { ?>
                            <div class="tab-pane >" id="ingilizce" role="tabpanel">
                                <div class="form-group row">
                                    <div class="col-6">
                                        <label class="css-control css-control-warning css-switch">
                                            <input type="checkbox" class="css-control-input" name="aktif_en" value="1">
                                            <span class="css-control-indicator"></span> İngilizce İçerik Aktif
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="example-hf-email">Başlık</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" id="example-hf-email" name="baslik_en" placeholder="Lütfen Doldurun">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="example-hf-email">İçerik</label>
                                    <div class="col-lg-10">
                                        <textarea class="js-summernote" id="example-textarea-input" name="icerik_en" rows="6" placeholder="İçerik açıklaması.."> </textarea>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <!-- İspanyolca content düzenleme alanı -->
                        <?php if ($spanish == "on") { ?>
                            <div class="tab-pane >" id="ispanyolca" role="tabpanel">
                                <div class="form-group row">
                                    <div class="col-6">
                                        <label class="css-control css-control-warning css-switch">
                                            <input type="checkbox" class="css-control-input" name="aktif_es" value="1">
                                            <span class="css-control-indicator"></span> İspanyolca İçerik Aktif
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="example-hf-email">Başlık</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" id="example-hf-email" name="baslik_es" placeholder="Lütfen Doldurun">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="example-hf-email">İçerik</label>
                                    <div class="col-lg-10">
                                        <textarea class="js-summernote" id="example-textarea-input" name="icerik_es" rows="6" placeholder="İçerik açıklaması.."> </textarea>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <!-- Fransızca content düzenleme alanı -->
                        <?php if ($french == "on") { ?>
                            <div class="tab-pane >" id="fransizca" role="tabpanel">
                                <div class="form-group row">
                                    <div class="col-6">
                                        <label class="css-control css-control-warning css-switch">
                                            <input type="checkbox" class="css-control-input" name="aktif_fr" value="1">
                                            <span class="css-control-indicator"></span> Fransızca İçerik Aktif
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="example-hf-email">Başlık</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" id="example-hf-email" name="baslik_fr" placeholder="Lütfen Doldurun">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="example-hf-email">İçerik</label>
                                    <div class="col-lg-10">
                                        <textarea class="js-summernote" id="example-textarea-input" name="icerik_fr" rows="6" placeholder="İçerik açıklaması.."> </textarea>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <!-- Arapça content düzenleme alanı -->
                        <?php if ($arabic == "on") { ?>
                            <div class="tab-pane >" id="arapca" role="tabpanel">
                                <div class="form-group row">
                                    <div class="col-6">
                                        <label class="css-control css-control-warning css-switch">
                                            <input type="checkbox" class="css-control-input" name="aktif_ar" value="1">
                                            <span class="css-control-indicator"></span> Arapça İçerik Aktif
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="example-hf-email">Başlık</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" id="example-hf-email" name="baslik_ar" placeholder="Lütfen Doldurun">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="example-hf-email">İçerik</label>
                                    <div class="col-lg-10">
                                        <textarea class="js-summernote" id="example-textarea-input" name="icerik_ar" rows="6" placeholder="İçerik açıklaması.."> </textarea>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <!-- Video link alanı -->
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label" for="example-hf-email">Video</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="example-hf-email" name="video" placeholder="Lütfen Doldurun">
                            </div>
                            <div class="col-lg-2" style="display: flex;">
                                <label class="css-control css-control-warning css-switch">
                                    <input type="checkbox" class="css-control-input" name="video_aktif" value="1" checked>
                                    <span class="css-control-indicator"></span> Youtube Linki
                                </label>
                            </div>

                        </div>
                        <!-- görsel alanı -->
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Görsel</label>
                            <div class="col-lg-4">
                                <img src="../../uploads/noimage.jpg" class="w-100 upload-slider">                                
                                <div class="custom-file">
                                    <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                    <input type="file" class="custom-file-input" name="resim" size="42" accept="image/*" data-toggle="custom-file-input" oninput="imgSlider()">
                                    <label class="custom-file-label">Bir dosya seçin</label>
                                </div>
                            </div>
                        </div>

                        <!-- durum belirtme alanı(default aktif) -->
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Aktif</label>
                            <div class="col-lg-2" style="display: flex;">
                                <label class="css-control css-control-warning css-switch">
                                    <input type="checkbox" class="css-control-input" name="aktif" value="1" checked>
                                    <span class="css-control-indicator"></span> Haber Aktif
                                </label>
                            </div>
                        </div>
                        
                        <!-- Türkçe dil hata mesajı -->
                        <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                    </div>
                    <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                        <div class="block-options">
                            <div class="block-options-item">
                            <button type="submit" name="add" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                            <a href="haberler"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>



        <?php }

        #Content düzenleme alanı ($_GET['perform']=="edit" ise aşağıdaki kod bloğu çalışacak)
        if ($perform == "edit") {

            $getContent = $db->prepare("SELECT * FROM tbl_haberler WHERE id=?");
            $getContent->execute(array($contentID));
            $result = $getContent->fetch(PDO::FETCH_ASSOC);

        ?>

            <div class="block block-fx-shadow">
                <div class="block">
                    <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                        <!-- Türkçe aktif ise -->
                        <?php if ($turkish == "on") { ?>
                            <li class="nav-item"><a class="nav-link active" href="#turkce" style="padding: 20px;">TÜRKÇE</a> </li>
                        <?php } ?>
                        <!-- İngilizce aktif ise -->
                        <?php if ($english == "on") { ?>
                            <li class="nav-item"> <a class="nav-link " href="#ingilizce" style="padding: 20px;">
                                    <span class="sidebar-mini-visible">İNG</span><span class="sidebar-mini-hidden">İNGİLİZCE</span></a></li>
                        <?php } ?>
                        <!-- İspanyolca aktif ise -->
                        <?php if ($spanish == "on") { ?>
                            <li class="nav-item"> <a class="nav-link " href="#ispanyolca" style="padding: 20px;">İSPANYOLCA</a></li>
                        <?php } ?>
                        <!-- Fransızca aktif ise -->
                        <?php if ($french == "on") { ?>
                            <li class="nav-item"> <a class="nav-link " href="#fransizca" style="padding: 20px;">FRANSIZCA</a></li>
                        <?php } ?>
                        <!-- Arapça aktif ise -->
                        <?php if ($arabic == "on") { ?>
                            <li class="nav-item"> <a class="nav-link " href="#arapca" style="padding: 20px;">ARAPÇA</a></li>
                        <?php } ?>

                        <!-- Geri dönme butonu -->
                        <li class="nav-item ml-auto">
                            <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()" style="margin: 10px;  padding: 10px;">GERİ DÖN</button>
                        </li>
                    </ul>
                    <div class="block-content tab-content">
                        <!-- Türkçe content ekleme alanı -->
                        <?php if ($turkish == "on") { ?>
                            <div class="tab-pane active" id="turkce" role="tabpanel">
                                <form action="../operations/controllers/haberlerController" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <div class="col-6">
                                            <label class="css-control css-control-warning css-switch">
                                                <input type="checkbox" class="css-control-input" name="aktif_tr" value="1" <?php if($result['aktif_tr']==1){echo "checked";} ?>>
                                                <span class="css-control-indicator"></span> Türkçe İçerik Aktif
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Başlık</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_tr" placeholder="Lütfen Doldurun" value="<?= $result['baslik_tr']?>" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                            <input type="hidden" name="id" value="<?= $result['id']?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">İçerik</label>
                                        <div class="col-lg-10">
                                            <textarea class="js-summernote" name="icerik_tr" rows="6" placeholder="İçerik açıklaması.."> <?= $result['icerik_tr']?> </textarea>
                                        </div>
                                    </div>
                            </div>
                        <?php } ?>

                        <!-- İngilizce content düzenleme alanı -->
                        <?php if ($english == "on") { ?>
                            <div class="tab-pane" id="ingilizce" role="tabpanel">
                                <div class="form-group row">
                                    <div class="col-6">
                                        <label class="css-control css-control-warning css-switch">
                                            <input type="checkbox" class="css-control-input" name="aktif_en" value="1" <?php if($result['aktif_en']==1){echo "checked";} ?>>
                                            <span class="css-control-indicator"></span> İngilizce İçerik Aktif
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Başlık</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="baslik_en" placeholder="Lütfen Doldurun" value="<?= $result['baslik_en']?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">İçerik</label>
                                    <div class="col-lg-10">
                                        <textarea class="js-summernote" name="icerik_en" rows="6" placeholder="İçerik açıklaması.."><?= $result['icerik_en']?> </textarea>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <!-- İspanyolca content düzenleme alanı -->
                        <?php if ($spanish == "on") { ?>
                            <div class="tab-pane" id="ispanyolca" role="tabpanel">
                                <div class="form-group row">
                                    <div class="col-6">
                                        <label class="css-control css-control-warning css-switch">
                                            <input type="checkbox" class="css-control-input" name="aktif_es" value="1" <?php if($result['aktif_es']==1){echo "checked";} ?>>
                                            <span class="css-control-indicator"></span> İspanyolca İçerik Aktif
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="example-hf-email">Başlık</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" id="example-hf-email" name="baslik_es" placeholder="Lütfen Doldurun" value="<?= $result['baslik_es']?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="example-hf-email">İçerik</label>
                                    <div class="col-lg-10">
                                        <textarea class="js-summernote" id="example-textarea-input" name="icerik_es" rows="6" placeholder="İçerik açıklaması.."><?= $result['icerik_es']?></textarea>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <!-- Fransızca content düzenleme alanı -->
                        <?php if ($french == "on") { ?>
                            <div class="tab-pane" id="fransizca" role="tabpanel">
                                <div class="form-group row">
                                    <div class="col-6">
                                        <label class="css-control css-control-warning css-switch">
                                            <input type="checkbox" class="css-control-input" name="aktif_fr" value="1" <?php if($result['aktif_fr']==1){echo "checked";} ?>>
                                            <span class="css-control-indicator"></span> Fransızca İçerik Aktif
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="example-hf-email">Başlık</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" id="example-hf-email" name="baslik_fr" placeholder="Lütfen Doldurun" value="<?= $result['baslik_fr']?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="example-hf-email">İçerik</label>
                                    <div class="col-lg-10">
                                        <textarea class="js-summernote" id="example-textarea-input" name="icerik_fr" rows="6" placeholder="İçerik açıklaması.."><?= $result['icerik_fr']?></textarea>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <!-- Arapça content düzenleme alanı -->
                        <?php if ($arabic == "on") { ?>
                            <div class="tab-pane" id="arapca" role="tabpanel">
                                <div class="form-group row">
                                    <div class="col-6">
                                        <label class="css-control css-control-warning css-switch">
                                            <input type="checkbox" class="css-control-input" name="aktif_ar" value="1" <?php if($result['aktif_ar']==1){echo "checked";} ?>>
                                            <span class="css-control-indicator"></span> Arapça İçerik Aktif
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="example-hf-email">Başlık</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" id="example-hf-email" name="baslik_ar" placeholder="Lütfen Doldurun" value="<?= $result['baslik_ar']?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="example-hf-email">İçerik</label>
                                    <div class="col-lg-10">
                                        <textarea class="js-summernote" id="example-textarea-input" name="icerik_ar" rows="6" placeholder="İçerik açıklaması.."><?= $result['icerik_ar']?></textarea>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <!-- Video link alanı -->
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label" for="example-hf-email">Video</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="example-hf-email" name="video" placeholder="Lütfen Doldurun">
                            </div>
                            <div class="col-lg-2" style="display: flex;">
                                <label class="css-control css-control-warning css-switch">
                                    <input type="checkbox" class="css-control-input" name="video_aktif" value="1" <?php if($result['aktif']==1){echo "checked";} ?>>
                                    <span class="css-control-indicator"></span> Youtube Linki
                                </label>
                            </div>

                        </div>
                        
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label" >Görsel</label>
                            <div class="col-lg-5">
                                <?php 
                                if ( $result['gorsel']=="noimage.jpg" ) { ?>
                                
                                <img src="../../uploads/noimage.jpg" class="img-fluid upload-slider"><br>

                                <?php 
                                }else {?>

                                <img src="../../uploads/<?= $result['gorsel'] ?>" class="img-fluid upload-slider"><br>

                                <?php }
                                ?>
                                
                                <div class="custom-file">
                                    <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                    <input type="file" class="custom-file-input" name="resim" size="42" accept="image/*" data-toggle="custom-file-input" oninput="imgSlider()">
                                    <input type="hidden" name="old-image" value="<?= $result['gorsel']?>">
                                    <label class="custom-file-label" for="example-file-input-custom">Bir dosya seçin</label>
                                </div>
                            </div>
                        </div>

                        <!-- durum belirtme alanı(default aktif) -->
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Aktif</label>
                            <div class="col-lg-2" style="display: flex;">
                                <label class="css-control css-control-warning css-switch">
                                    <input type="checkbox" class="css-control-input" name="aktif" value="1" <?php if($result['aktif']==1){echo "checked";} ?>>
                                    <span class="css-control-indicator"></span> İçerik Aktif
                                </label>
                            </div>
                        </div>

                        <!-- Türkçe dil hata mesajı -->
                        <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                    </div>
                    <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                        <div class="block-options">
                            <div class="block-options-item">
                            <button type="submit" name="edit" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                            <a href="haberler"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>

        <?php } 

        #Toplu resim yükleme
        if ($perform=="foto") {?>
        <div class="block block-fx-shadow">
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">İÇERİK DÜZENLEME</h3>
                    <div class="block-options">
                        <a href="haberler"> <button class="btn btn-sm btn-hero btn-outline-secondary"> GERİ DÖN</button></a>
                    </div>
                </div>
                <div class="block-content">
                    <div id="drop_file_zone" ondrop="upload_file(event)" ondragover="return false">
                        <div id="drag_upload_file">
                            <p>Birden fazla fotoğrafı sürükle-bırak yaparak yükleyebilir veya <br><br><b>Dosya Seçerek</b> yükleme yapabilirsiniz.</p>
                            <p><input type="button" value="Dosya Seç" onclick="file_explorer();" accept="image/*"></p>
                            <input type="file" id="selectfile" multiple="multiple" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="width: 100%; text-align: center; display: none; margin-top: -126px; margin-bottom: 72px; " id="tamamalandı">
            <div style=" border-radius: 4px; width: 300px; display: inline-block;text-align: center; color: #fff; font-size: 18px;" class="block-header bg-gd-emerald">Fotoğraf Başarıyla Yüklendi </h3>
            </div>
        </div>
        <div class="row items-push" id="bilgiver">

            <?php

            $getImg = $db->prepare('SELECT * FROM tbl_galeri WHERE haber_id=? ORDER BY id DESC');
            $getImg->execute(array($contentID));

            while ($result = $getImg->fetch(PDO::FETCH_ASSOC)) {  ?>

                <div class="col-md-3 animated fadeIn">
                    <div class="options-container fx-item-zoom-in fx-overlay-zoom-in" style=" height: 200px; background-image: url(../../uploads/<?= $result["gorsel"] ?>); background-size: cover;">
                        <div class="options-overlay bg-black-op">
                            <div class="options-overlay-content">
                                <a class="btn btn-sm btn-rounded btn-alt-danger min-width-75" href="../operations/controllers/imageUploadController?perform=deleteImage&id=<?= $result["id"]?>&contentID=<?= $result["haber_id"] ?>&pageName=haberler">
                                    <i class="fa fa-times"></i> Sil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            <?php }
            ?>

        </div>

       <?php }
        
        ?>

    </div>
</main>

<?php

include('layouts/footer.php');

?>


