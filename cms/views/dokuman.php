<?php

$authPageName = "content";
$activeClass ="slider";
$pageTitle = "Maharethane - Döküman Yönetimi";
include('layouts/header.php');
include('../operations/middleware/AuthorizationMiddleware.php');
$perform = $_GET['perform'];
$contentID = $_GET['id'];
$controllerName="slider";

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
                    <h1 class="font-w700 text-white mb-10">Döküman Yönetimi</h1>
                    <h2 class="h4 font-w400 text-white-op">Sistemde bulunan ve sisteme eklenecek dökümanları bu alandan yönetebilirsiniz.</h2>
                </div>
            </div>
        </div>
        <?php        
        #Aksiyon olmadan sayfa açılımı
        if ($perform == "" or $perform == NULL) { ?>
            <!-- Kayıtlı içerikleri görüntüleme -->
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">DÖKÜMANLAR</h3>
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
                                <th class="text-center d-none d-sm-table-cell" style="width: 5%;">Dil Durum</th>
                                <th class="d-none d-sm-table-cell">Başlık</th>
                                <th class="d-none d-sm-table-cell" style="width: 5%;">Durum</th>
                                <th class="text-center" style="width: 15%;">İşlem</th>
                                <th class="text-center" style="width: 5%;">Taşı</th>
                            </tr>
                        </thead>
                        <tbody id="sortItems">

                            <?php
                            #Sayfa bilgilerini database den çek
                            $pageData = $db->prepare("SELECT * FROM tbl_slider ORDER BY sira ASC");
                            $pageData->execute();

                            #Sorguya uygun kayıtları döngüye al
                            while ($getData = $pageData->fetch(PDO::FETCH_ASSOC)) { ?>

                                <tr data-id="<?= $getData['id']?>">
                                    <td class="font-w600  d-none d-sm-table-cell text-center">
                                        <span class="badge  <?php if ($getData['aktif_tr'] == 1) {echo "badge-success";} else {echo "badge-danger";} ?>">TR</span>
                                        <span class="badge  <?php if ($getData['aktif_en'] == 1) {echo "badge-success";} else {echo "badge-danger";} ?>">EN</span>
                                    </td>
                                    <td class="font-w600 d-none d-sm-table-cell"> <?= $getData["baslik_1_tr"]." ".$getData['baslik_2_tr'] ?> </td>
                                    <td class="font-w600 d-none d-sm-table-cell"><span class="badge  <?php if($getData['aktif']==1){echo "badge-info";}else{echo "badge-danger";} ?>"><?php if($getData['aktif']==1){echo "Aktif";}else{echo "Pasif";} ?></span></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="?perform=edit&id=<?= $getData["id"] ?>"><button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="İçerik Düzenle" data-placement="bottom">
                                                    <i class="fa fa-pencil"></i>
                                                </button></a>
                                            <a href="../operations/controllers/sliderController?perform=delete&id=<?= $getData["id"]; ?>&adi=<?= $getData["baslik_1_tr"]; ?>" onclick="return confirm('<?= $getData['adi_tr']; ?> Adlı Kaydı Silmek İstediğinize Eminmisiniz? ')">
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
                                <form action="../operations/controllers/sliderController" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <div class="col-6">
                                        <label class="css-control css-control-warning css-switch">
                                            <input type="checkbox" class="css-control-input" name="aktif_tr" value="1" checked>
                                            <span class="css-control-indicator"></span> Türkçe İçerik Aktif
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" >Başlık </label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control"  name="baslik_1_tr" placeholder="Lütfen Doldurun" required>
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
                                    <label class="col-lg-2 col-form-label" >Başlık</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control"  name="baslik_1_en" placeholder="Lütfen Doldurun">
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
                                    <label class="col-lg-2 col-form-label" >Başlık</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control"  name="baslik_1_fr" placeholder="Lütfen Doldurun">
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
                                    <label class="col-lg-2 col-form-label" >Başlık</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control"  name="baslik_1_es" placeholder="Lütfen Doldurun">
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
                                            <span class="css-control-indicator"></span> İspanyolca İçerik Aktif
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" >Başlık</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control"  name="baslik_1_ar" placeholder="Lütfen Doldurun">
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Döküman</label>
                            <div class="col-lg-4">
                                <div class="custom-file">
                                    <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                    <input type="file" class="custom-file-input" name="dokuman" size="42" accept=".doc, .docx, .xls, .xlsx, .pdf" data-toggle="custom-file-input" required>
                                    <label class="custom-file-label">Bir dosya seçin</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- slider durum belirtme alanı(default aktif) -->
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Aktif</label>
                            <div class="col-lg-2" style="display: flex;">
                                <label class="css-control css-control-warning css-switch">
                                    <input type="checkbox" class="css-control-input" name="aktif" value="1" checked>
                                    <span class="css-control-indicator"></span> Döküman Aktif
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
                            <a href="slider"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>

        <?php }

        #Content düzenleme alanı ($_GET['perform']=="edit" ise aşağıdaki kod bloğu çalışacak)
        if ($perform == "edit") {

            $getContent = $db->prepare("SELECT * FROM tbl_slider WHERE id=?");
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
                    <!-- Türkçe content düzenleme alanı -->
                    <?php if ($turkish == "on") { ?>
                        <div class="tab-pane active" id="turkce" role="tabpanel">
                            <form action="../operations/controllers/sliderController" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <div class="col-6">
                                        <label class="css-control css-control-warning css-switch">
                                            <input type="checkbox" class="css-control-input" name="aktif_tr" value="1" <?php if ($result['aktif_tr'] == 1) { echo "checked"; } ?>>
                                            <span class="css-control-indicator"></span> Türkçe İçerik Aktif
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" >Başlık</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control"  name="baslik_1_tr" placeholder="Lütfen Doldurun" value="<?= $result['baslik_1_tr']; ?>" required="">
                                        <input type="hidden" class="form-control"  name="id" placeholder="Lütfen Doldurun" value="<?= $result['id']; ?>">
                                    </div>
                                </div>

                        </div>
                    <?php } ?>
                    <!-- İngilizce content düzenleme alanı -->
                    <?php if ($english == "on") { ?>
                        <div class="tab-pane <?php if ($turkish != "on") { echo  "active"; } ?>" id="ingilizce" role="tabpanel">
                            <div class="form-group row">
                                <div class="col-6">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif_en" value="1" <?php if ($result['aktif_en'] == 1) { echo "checked";  } ?>>
                                        <span class="css-control-indicator"></span> İngilizce İçerik Aktif
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Başlık</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control"  name="baslik_1_en" placeholder="Lütfen Doldurun" value="<?= $result['baslik_1_en']; ?>">
                                </div>
                            </div>

                        </div>
                    <?php } ?>
                    <!-- Fransızca content düzenleme alanı -->
                    <?php if ($french == "on") { ?>
                        <div class="tab-pane <?php if ($turkish != "on") { echo  "active"; } ?>" id="fransizca" role="tabpanel">
                            <div class="form-group row">
                                <div class="col-6">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif_fr" value="1" <?php if ($result['aktif_fr'] == 1) { echo "checked";  } ?>>
                                        <span class="css-control-indicator"></span> Fransızca İçerik Aktif
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Başlık</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control"  name="baslik_1_fr" placeholder="Lütfen Doldurun" value="<?= $result['baslik_1_fr']; ?>">
                                </div>
                            </div>

                        </div>
                    <?php } ?>
                    <!-- İspanyolca content düzenleme alanı -->
                    <?php if ($spanish == "on") { ?>
                        <div class="tab-pane <?php if ($turkish != "on") { echo  "active"; } ?>" id="ispanyolca" role="tabpanel">
                            <div class="form-group row">
                                <div class="col-6">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif_es" value="1" <?php if ($result['aktif_es'] == 1) { echo "checked";  } ?>>
                                        <span class="css-control-indicator"></span> İspanyolca İçerik Aktif
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Başlık</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control"  name="baslik_1_es" placeholder="Lütfen Doldurun" value="<?= $result['baslik_1_es']; ?>">
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- Arapça content düzenleme alanı -->
                    <?php if ($arabic == "on") { ?>
                        <div class="tab-pane <?php if ($turkish != "on") { echo  "active"; } ?>" id="arapca" role="tabpanel">
                            <div class="form-group row">
                                <div class="col-6">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif_ar" value="1" <?php if ($result['aktif_ar'] == 1) { echo "checked";  } ?>>
                                        <span class="css-control-indicator"></span> Arapça İçerik Aktif
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Başlık</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control"  name="baslik_1_ar" placeholder="Lütfen Doldurun" value="<?= $result['baslik_1_ar']; ?>">
                                </div>
                            </div>

                        </div>
                    <?php } ?>
                    <input type="hidden" name="id" value="<?=$result['id']?>">

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Döküman</label>
                        <div class="col-lg-4">
                            <div class="custom-file">
                                <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                <a href="<?="../../uploads/".$result['dokuman']?>"></a>
                                <input type="file" class="custom-file-input" name="dokuman" size="42" accept=".doc, .docx, .xls, .xlsx, .pdf" data-toggle="custom-file-input">
                                <input type="hidden" name="old-document" value="<?=$result['dokuman']?>">
                                <label class="custom-file-label">Bir dosya seçin</label>
                            </div>
                        </div>
                        <?php if ($result['dokuman'] !==NUL) { ?>
                            <div class="col-lg-6">
                                <a target="_blank" href="<?="../../uploads/".$result['dokuman']?>">Mevcut Dökümanı Görüntüle</a>
                            </div>
                        <?php }
                        ?>
                    </div>

                    <!-- slider durum belirtme alanı(default aktif) -->
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Aktif</label>
                        <div class="col-lg-2" style="display: flex;">
                            <label class="css-control css-control-warning css-switch">
                                <input type="checkbox" class="css-control-input" name="aktif" value="1" <?php if($result['aktif']==1){echo "checked";} ?>>
                                <span class="css-control-indicator"></span> Döküman Aktif
                            </label>
                        </div>
                    </div>

                    <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                    <div class="block-options">
                        <div class="block-options-item">
                        <button type="submit" name="edit" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                        <a href="slider"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>

        <?php } 
        
        ?>

    </div>
</main>

<?php

include('layouts/footer.php');

?>


