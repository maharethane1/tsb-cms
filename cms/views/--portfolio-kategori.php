<?php

$authPageName = "content";
$activeClass ="portfoliocat";
$pageTitle = "Maharethane - Portfolio Kategori Yönetimi";
include('layouts/header.php');
include('../operations/middleware/AuthorizationMiddleware.php');
$perform = $_GET['perform'];
$contentID = $_GET['id'];
$controllerName="portCat";
?>

<main id="main-container">
    <!-- Page Content -->
    <div class="content">
        <div class="block block-transparent bg-video" data-vide-bg="assets/media/videos/city_night" data-vide-options="posterType: jpg" style="position: relative;"><div style="position: absolute; z-index: -1; inset: 0px; overflow: hidden; background-size: cover; background-color: transparent; background-repeat: no-repeat; background-position: 50% 50%; background-image: none;"><video autoplay="" loop="" muted="" style="margin: auto; position: absolute; z-index: -1; top: 50%; left: 50%; transform: translate(-50%, -50%); visibility: visible; opacity: 1; width: 1154px; height: auto;"><source src="assets/media/videos/city_night.mp4" type="video/mp4"><source src="assets/media/videos/city_night.webm" type="video/webm"><source src="assets/media/videos/city_night.ogv" type="video/ogg"></video></div>
            <div class="block-content bg-primary-dark-op">
                <div class="py-20 text-center">
                    <h1 class="font-w700 text-white mb-10">Portfolio Kategori Yönetimi</h1>
                    <h2 class="h4 font-w400 text-white-op">Sistemde bulunan portfolyolara ait kategorileri bu sayfadan yönetebilirsiniz.</h2>
                </div>
            </div>
        </div>
        <?php
        #Aksiyon olmadan sayfa açılımı
        if ($perform == "" or $perform == NULL) { ?>
            <!-- Kayıtlı içerikleri görüntüleme -->
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">KATEGORİLER</h3>
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
                                <th class="text-center d-none d-lg-table-cell">Dil Durum</th>
                                <th>Kategori Adı</th>
                                <th class="text-center d-none d-lg-table-cell">Son Değişiklik Tarihi</th>
                                <th class="d-none d-sm-table-cell">Durum</th>
                                <th class="text-center" style="width: 15%;">İşlem</th>
                                <th class="text-center" style="width: 5%;">Taşı</th>
                            </tr>
                        </thead>
                        <tbody id="sortItems">

                            <?php
                            #Sayfa bilgilerini database den çek
                            $pageData = $db->prepare("SELECT * FROM tbl_portfolio_kategori ORDER BY sira");
                            
                            $pageData->execute();

                            #Sorguya uygun kayıtları döngüye al
                            while ($getData = $pageData->fetch(PDO::FETCH_ASSOC)) { ?>
    
                                <tr data-id="<?= $getData['id']?>">
                                    <td class="font-w600  d-none d-lg-table-cell text-center">
                                        <span class="badge  <?php if ($getData['aktif_tr'] == 1) {echo "badge-success";} else {echo "badge-danger";} ?>">TR</span>
                                        <span class="badge  <?php if ($getData['aktif_en'] == 1) {echo "badge-success";} else {echo "badge-danger";} ?>">EN</span>
                                        <span class="badge  <?php if ($getData['aktif_es'] == 1) {echo "badge-success";} else {echo "badge-danger";} ?>">ES</span>
                                        <span class="badge  <?php if ($getData['aktif_fr'] == 1) {echo "badge-success";} else {echo "badge-danger";} ?>">FR</span>
                                        <span class="badge  <?php if ($getData['aktif_ar'] == 1) {echo "badge-success";} else {echo "badge-danger";} ?>">AR</span>
                                    </td>
                                    <td class="font-w600"><?= $getData['adi_tr'] ?> </td>
                                    <td class="font-w600 d-none d-lg-table-cell text-center"><?= $getData['tarih'] ?> </td>
                                    <td class="font-w600 d-none d-sm-table-cell"><span class="badge  <?php if($getData['aktif']==1){echo "badge-success";}else{echo "badge-danger";} ?>"><?php if($getData['aktif']==1){echo "Aktif";}else{echo "Pasif";} ?></span></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="?perform=edit&id=<?= $getData["id"] ?>"><button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="İçerik Düzenle" data-placement="bottom">
                                                    <i class="fa fa-pencil"></i>
                                                </button></a>
                                            <a href="../operations/controllers/portCatController?perform=delete&id=<?= $getData["id"]; ?>&adi=<?= $getData["adi_tr"]; ?>" onclick="return confirm('<?= $getData['adi_tr']; ?> Adlı Kaydı Silmek İstediğinize Eminmisiniz? ')">
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
                                <form action="../operations/controllers/portCatController" method="post" name="addPage"  enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <div class="col-6">
                                            <label class="css-control css-control-warning css-switch">
                                                <input type="checkbox" class="css-control-input" name="aktif_tr" value="1" checked>
                                                <span class="css-control-indicator"></span> Türkçe İçerik Aktif
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Başlık</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="adi_tr" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Açıklama</label>
                                        <div class="col-lg-10">
                                            <textarea class="js-summernote" name="aciklama_tr" rows="6" placeholder="İçerik açıklaması.."> </textarea>
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
                                    <label class="col-lg-2 col-form-label">Başlık</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control"name="adi_en" placeholder="Lütfen Doldurun">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Açıklama</label>
                                    <div class="col-lg-10">
                                        <textarea class="js-summernote" name="aciklama_en" rows="6" placeholder="İçerik açıklaması.."> </textarea>
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
                                        <input type="text" class="form-control" name="adi_es" placeholder="Lütfen Doldurun">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" >Açıklama</label>
                                    <div class="col-lg-10">
                                        <textarea class="js-summernote" name="aciklama_es" rows="6" placeholder="İçerik açıklaması.."> </textarea>
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
                                    <label class="col-lg-2 col-form-label">Başlık</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="adi_fr" placeholder="Lütfen Doldurun">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Açıklama</label>
                                    <div class="col-lg-10">
                                        <textarea class="js-summernote" name="aciklama_fr" rows="6" placeholder="İçerik açıklaması.."> </textarea>
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
                                    <label class="col-lg-2 col-form-label">Başlık</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" id="example-hf-email" name="adi_ar" placeholder="Lütfen Doldurun">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Açıklama</label>
                                    <div class="col-lg-10">
                                        <textarea class="js-summernote" name="aciklama_ar" rows="6" placeholder="İçerik açıklaması.."> </textarea>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                                                
                        <!-- kategori durum seçme alanı -->
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label" >Durum</label>
                            <div class="col-lg-5">
                                <label class="css-control css-control-warning css-switch">
                                    <input type="checkbox" class="css-control-input" name="aktif" value="1" checked>
                                    <span class="css-control-indicator"></span> Kategori Aktif
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
                                <a href="portfolio-kategori?statu=ok"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>



        <?php }

        #Content düzenleme alanı ($_GET['perform']=="edit" ise aşağıdaki kod bloğu çalışacak)
        if ($perform == "edit") {

            $getContent = $db->prepare("SELECT * FROM tbl_portfolio_kategori WHERE id=?");
            $getContent->execute(array($contentID));
            $result = $getContent->fetch(PDO::FETCH_ASSOC);

        ?>

        <div class="block block-fx-shadow">
            <div class="block">
                <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                    <!-- Sitenin türkçe dili aktif ise -->
                    <?php if ($turkish == "on") { ?>
                        <li class="nav-item"><a class="nav-link active" href="#turkce" style="padding: 20px;">TÜRKÇE</a> </li>
                    <?php } ?>
                    <!-- Sitenin ingilizce dili aktif ise -->
                    <?php if ($english == "on") { ?>
                        <li class="nav-item"> <a class="nav-link" href="#ingilizce" style="padding: 20px;">
                                <span class="sidebar-mini-visible">İNG</span><span class="sidebar-mini-hidden">İNGİLİZCE</span></a></li>
                    <?php } ?>
                    <!-- Sitenin ispanyolca dili aktif ise -->
                    <?php if ($spanish == "on") { ?>
                        <li class="nav-item"> <a class="nav-link"  href="#ispanyolca" style="padding: 20px;">İSPANYOLCA</a></li>
                    <?php } ?>
                    <!-- Sitenin fransızca dili aktif ise -->
                    <?php if ($french == "on") { ?>
                        <li class="nav-item"> <a class="nav-link " href="#fransizca" style="padding: 20px;">FRANSIZCA</a></li>
                    <?php } ?>
                    <!-- Sitenin arapça dili aktif ise -->
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
                            <form action="../operations/controllers/portCatController" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <div class="col-6">
                                        <label class="css-control css-control-warning css-switch">
                                            <input type="checkbox" class="css-control-input" name="aktif_tr" value="1" <?php if ($result['aktif_tr'] == 1) { echo "checked"; } ?>>
                                            <span class="css-control-indicator"></span> Türkçe İçerik Aktif 
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Başlık</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="adi_tr" placeholder="Lütfen Doldurun" value="<?= $result['adi_tr']; ?>" required="">
                                        <input type="hidden" class="form-control" name="id" placeholder="Lütfen Doldurun" value="<?= $result['id']; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Açıklama</label>
                                    <div class="col-lg-10">
                                        <textarea class="js-summernote" name="aciklama_tr" rows="6" placeholder="İçerik açıklaması.."><?= $result['aciklama_tr']; ?></textarea>
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
                                <label class="col-lg-2 col-form-label">Başlık</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="adi_en" value="<?= $result['adi_en']; ?>" placeholder="Lütfen Doldurun">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Açıklama</label>
                                <div class="col-lg-10">
                                    <textarea class="js-summernote" name="aciklama_en" rows="6" placeholder="İçerik açıklaması.."><?= $result['aciklama_en']; ?></textarea>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- İspanyolca content düzenleme alanı -->
                    <?php if ($spanish == "on") { ?>
                        <div class="tab-pane " id="ispanyolca" role="tabpanel">
                            <div class="form-group row">
                                <div class="col-6">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif_es" value="1" <?php if ($result['aktif_es'] == 1) { echo "checked"; } ?>>
                                        <span class="css-control-indicator"></span> İspanyolca İçerik Aktif
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Başlık</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="adi_es" placeholder="Lütfen Doldurun" value="<?= $result['adi_es'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Açıklama</label>
                                <div class="col-lg-10">
                                    <textarea class="js-summernote" name="aciklama_es" rows="6" placeholder="İçerik açıklaması.."><?= $result['aciklama_es'] ?></textarea>
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
                                        <input type="checkbox" class="css-control-input" name="aktif_fr" value="1" <?php if ($result['aktif_fr'] == 1) { echo "checked"; } ?>>
                                        <span class="css-control-indicator"></span> Fransızca İçerik Aktif
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Başlık</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="adi_fr" value="<?= $result['adi_fr'] ?>" placeholder="Lütfen Doldurun">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Açıklama</label>
                                <div class="col-lg-10">
                                    <textarea class="js-summernote" name="aciklama_fr" rows="6" placeholder="İçerik açıklaması.."><?= $result['aciklama_fr'] ?></textarea>
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
                                        <input type="checkbox" class="css-control-input" name="aktif_ar" value="1" <?php if ($result['aktif_ar'] == 1) { echo "checked"; } ?>>
                                        <span class="css-control-indicator"></span> Arapça İçerik Aktif
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Başlık</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="example-hf-email" value="<?= $result['adi_ar'] ?>" name="adi_ar" placeholder="Lütfen Doldurun">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Açıklama</label>
                                <div class="col-lg-10">
                                    <textarea class="js-summernote" name="aciklama_ar" rows="6" placeholder="İçerik açıklaması.."><?= $result['aciklama_ar'] ?></textarea>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <!-- kategori durum seçme alanı -->
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label" >Durum</label>
                        <div class="col-lg-5">
                            <label class="css-control css-control-warning css-switch">
                                <input type="checkbox" class="css-control-input" name="aktif" value="1" <?php if($result['aktif']==1){echo "checked";} ?>>
                                <span class="css-control-indicator"></span> Kategori Aktif
                            </label>
                        </div>
                    </div>
                    <!-- türkçe dil hata mesajı -->
                    <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>                    
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                    <div class="block-options">
                        <div class="block-options-item">
                            <button type="submit" name="edit" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                            <a href="portfolio-kategori?statu=ok"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
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


