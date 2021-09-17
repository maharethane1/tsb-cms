<?php

$authPageName = "content";
$activeClass ="portfolio";
$pageTitle = "Maharethane - Portfolio Yönetimi";
include('layouts/header.php');
include('../operations/middleware/AuthorizationMiddleware.php');
$perform = $_GET['perform'];
$contentID = $_GET['id'];

?>

<main id="main-container">
    <!-- Page Content -->
    <div class="content">
        <div class="block block-transparent bg-video" data-vide-bg="assets/media/videos/city_night" data-vide-options="posterType: jpg" style="position: relative;"><div style="position: absolute; z-index: -1; inset: 0px; overflow: hidden; background-size: cover; background-color: transparent; background-repeat: no-repeat; background-position: 50% 50%; background-image: none;"><video autoplay="" loop="" muted="" style="margin: auto; position: absolute; z-index: -1; top: 50%; left: 50%; transform: translate(-50%, -50%); visibility: visible; opacity: 1; width: 1154px; height: auto;"><source src="assets/media/videos/city_night.mp4" type="video/mp4"><source src="assets/media/videos/city_night.webm" type="video/webm"><source src="assets/media/videos/city_night.ogv" type="video/ogg"></video></div>
            <div class="block-content bg-primary-dark-op">
                <div class="py-20 text-center">
                    <h1 class="font-w700 text-white mb-10">Portfolio Yönetimi</h1>
                    <h2 class="h4 font-w400 text-white-op">Portfolio sayfası içeriklerini bu alandan yönetebilirsiniz.</h2>
                </div>
            </div>
        </div>
        <?php
        #Aksiyon olmadan sayfa açılımı
        if ($perform == "" or $perform == NULL) { 
            $controllerName="portfolio";
            ?>
            
            <!-- Kayıtlı içerikleri görüntüleme -->
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">PORTFOLYOLAR</h3>
                    <div class="block-options">
                        <div class="block-options-item">
                            <a href="?perform=add"> <button class="btn btn-sm btn-hero btn-outline-secondary"> YENİ EKLE</button></a>
                        </div>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <table id="sort" class="table table-bordered table-striped table-vcenter js-dataTable-full background-white">
                        <thead>
                            <tr>
                                <th>SIRA</th>
                                <th class="d-none">Firma Adı</th>
                                <th class="d-none d-sm-table-cell">Kategori</th>
                                <th class="d-none d-sm-table-cell">Son Değişiklik Tarihi</th>
                                <th class="d-none d-sm-table-cell">Durum</th>
                                <th class="text-center" style="width: 15%;">İşlem</th>
                                <th class="text-center" style="width: 5%;">Taşı</th>
                            </tr>
                        </thead>
                        <tbody id="sortItems">

                            <?php
                            #Sayfa bilgilerini database den çek
                            $pageData = $db->prepare("SELECT a.*, b.adi_tr as kategori_adi FROM tbl_portfolio as a LEFT JOIN tbl_portfolio_kategori b ON a.kategori_id=b.id ORDER BY sira ASC");
                            $pageData->execute();

                            #Sorguya uygun kayıtları döngüye al
                            while ($getData = $pageData->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr data-id="<?= $getData['id']?>">
                                    <td class="d-none"><?= $getData['sira'] ?></td>
                                    <td class="font-w600"><?= $getData['firma'] ?> </td>
                                    <td class="font-w600 d-none d-sm-table-cell"><?= $getData["kategori_adi"] ?> </td>
                                    <td class="font-w600 d-none d-sm-table-cell"><?= $getData["tarih"] ?> </td>
                                    <td class="font-w600 d-none d-sm-table-cell"><span class="badge  <?php if($getData['aktif']==1){echo "badge-info";}elseif($getData['aktif']==0){echo "badge-danger";} ?>"><?php if($getData['aktif']==1){echo "Aktif";}elseif($getData['aktif']==0){echo "Pasif";} ?></span></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                        <a href="?perform=edit&id=<?= $getData["id"] ?>">
                                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Portfolio Düzenle" data-placement="bottom">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </a>
                                            <a href="?perform=addComp_step1&id=<?= $getData["id"] ?>">
                                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Bileşen Ekle" data-placement="bottom">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </a>
                                            <a href="?perform=sortComp&id=<?= $getData["id"] ?>">
                                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Bileşen Listele" data-placement="bottom">
                                                    <i class="fa fa-list-ol"></i>
                                                </button>
                                            </a>
                                            <a href="../operations/controllers/portfolioController?perform=delete&id=<?= $getData["id"]; ?>&adi=<?= $getData["firma"]; ?>" >
                                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Sil" data-placement="bottom" onclick="return confirm('<?= $getData['adi_tr']; ?> Adlı Kaydı Silmek İstediğinize Eminmisiniz? ')">
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

        // portfolyo ekle
        if($perform == "add"){?>

            <div class="col-lg-12">
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Portfolio Ekle</h3>
                        <div class="block-options">
                            <div class="block-options-item">
                                <a href="portfolio"><button class="btn btn-sm btn-hero btn-outline-secondary">GERİ DÖN</button></a>
                            </div>
                        </div>
                    </div>
                    <div class="block-content">
                        <form action="../operations/controllers/portfolioController" method="post" enctype="multipart/form-data">
                            <!-- kullanıcı statu belirleme alanı -->
                            <div class="form-group row">
                                <div class="col-12">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" checked>
                                        <span class="css-control-indicator"></span> Portfolio Durum
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="vitrin" value="1">
                                        <span class="css-control-indicator"></span> Vitrinde Göster
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label " >Firma Adı</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control"  name="firma" placeholder="Lütfen Doldurun" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label " >Müşteri Adı</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control"  name="musteri" placeholder="Lütfen Doldurun">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Kategori</label>
                                <div class="col-lg-10">
                                    <select class="form-control" name="kategori"  required="" >
                                        <option value="">Lütfen seçin</option>
                                        <?php 
                                        $getData = $db->prepare("SELECT * FROM tbl_portfolio_kategori WHERE aktif=1 ORDER BY sira ASC");
                                        $getData->execute();
                                        while($getCat = $getData->fetch(PDO::FETCH_ASSOC)) {?>
                                        <option value="<?= $getCat['id']?>"><?= $getCat['adi_tr'] ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- Video link alanı -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Video</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="video" placeholder="Lütfen Doldurun">
                                </div>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="video_aktif" value="1" checked>
                                        <span class="css-control-indicator"></span> Video Aktif
                                    </label>
                                </div>
                            </div>
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Görsel</label>
                                <div class="col-lg-4">
                                    <img src="../../uploads/noimage.jpg" class="img-fluid upload-slider">
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim" size="42" accept="image/*" data-toggle="custom-file-input" oninput="imgSlider()">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6 text-right offset-lg-3">
                                    <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                            <div class="block-options">
                                <div class="block-options-item">
                                    <button type="submit" name="add" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                    <a href="?statu=ok"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        <?php }

        // portfolyo düzenleme
        if($perform == "edit"){
            
            $getData = $db->prepare("SELECT * FROM tbl_portfolio WHERE id=?");
            $getData->execute(array($contentID));
            $result = $getData->fetch(PDO::FETCH_ASSOC);
            
            ?>

            <div class="col-lg-12">
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Portfolio Düzenle</h3>
                        <div class="block-options">
                            <div class="block-options-item">
                                <a href="portfolio"><button class="btn btn-sm btn-hero btn-outline-secondary">GERİ DÖN</button></a>
                            </div>
                        </div>
                    </div>
                    <div class="block-content">
                        <form action="../operations/controllers/portfolioController" method="post" enctype="multipart/form-data">
                            <!-- kullanıcı statu belirleme alanı -->
                            <div class="form-group row">
                                <div class="col-12">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" <?php if($result['aktif']==1){echo "checked";} ?>>
                                        <span class="css-control-indicator"></span> Portfolio Durum
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="vitrin" value="1" <?php if($result['vitrin']==1){echo "checked";} ?>>
                                        <span class="css-control-indicator"></span> Vitrinde Göster
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label " >Firma Adı</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control"  name="firma" placeholder="Lütfen Doldurun" value="<?= $result['firma'] ?>" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label " >Müşteri Adı</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control"  name="musteri" placeholder="Lütfen Doldurun" value="<?= $result['musteri'] ?>" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Kategori</label>
                                <div class="col-lg-10">
                                    <select class="form-control" name="kategori"  required="" >
                                        <option value="">Lütfen seçin</option>
                                        <?php 
                                        $getData = $db->prepare("SELECT * FROM tbl_portfolio_kategori WHERE aktif=1 ORDER BY sira ASC");
                                        $getData->execute();
                                        while($getCat = $getData->fetch(PDO::FETCH_ASSOC)) {?>
                                        <option value="<?= $getCat['id']?>" <?php if($getCat['id']==$result['kategori_id']){echo "selected";} ?> ><?= $getCat['adi_tr'] ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- Video link alanı -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Video</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="video" value="<?= $result['video'] ?>" placeholder="Lütfen Doldurun">
                                </div>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="video_aktif" value="1" <?php if($result['video_aktif']==1){echo "checked";} ?>>
                                        <span class="css-control-indicator"></span> Video Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="<?= $result['id']?>" >
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Görsel</label>
                                <div class="col-lg-4">
                                    <?php 
                                    if($result['gorsel']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider">
                                    <?php }
                                    else {?>
                                    <img src="../../uploads/<?=$result['gorsel']?>" class="w-100 upload-slider">
                                    <?php }
                                    ?>
                                    
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim" size="42" accept="image/*" data-toggle="custom-file-input" oninput="imgSlider()">
                                        <input type="hidden" name="old-image" value="<?= $result['gorsel']?>" >
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6 text-right offset-lg-3">
                                    <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                            <div class="block-options">
                                <div class="block-options-item">
                                    <button type="submit" name="edit" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                    <a href="portfolio"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        <?php }

        if ($perform == "sortComp") { 
            $controllerName="portfolioComp";
            $portData = $db->prepare("SELECT * FROM tbl_portfolio WHERE id=$contentID");
            $portData->execute();
            $getPortData = $portData->fetch(PDO::FETCH_ASSOC);
            ?>
                            
            <!-- Kayıtlı içerikleri görüntüleme -->
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">FİRMA ADI: <?= $getPortData['firma'] ?> </h3>
                    <div class="block-options">
                        <div class="block-options-item">
                        <a href="portfolio"> <button class="btn btn-sm btn-hero btn-outline-secondary"> GERİ DÖN</button></a>
                            <a href="?perform=addComp_step1&id=<?= $contentID ?>"> <button class="btn btn-sm btn-hero btn-outline-secondary"> YENİ EKLE</button></a>
                        </div>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <table id="sort" class="table table-bordered table-striped table-vcenter js-dataTable-full background-white">
                        <thead>
                            <tr>
                                <th>Bileşen</th>
                                <th class="d-none d-sm-table-cell">Son Değişiklik Tarihi</th>
                                <th class="d-none d-sm-table-cell">Durum</th>
                                <th class="text-center" style="width: 15%;">İşlem</th>
                                <th class="text-center" style="width: 5%;">Taşı</th>
                            </tr>
                        </thead>
                        <tbody id="sortItems">

                            <?php
                            #Sayfa bilgilerini database den çek
                            $pageData = $db->prepare("SELECT * FROM tbl_portfolio_comp WHERE portfolio_id=$contentID ORDER BY sira ASC");
                            $pageData->execute();

                            #Sorguya uygun kayıtları döngüye al
                            while ($getData = $pageData->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr data-id="<?= $getData['id']?>">
                                    <td class="font-w600" style="width: 10%;"><img src="../../uploads/components/comp-<?=$getData['comp']?>.jpg" class="w-100" alt=""></td>
                                    <td class="font-w600 d-none d-sm-table-cell"><?= $getData["tarih"] ?> </td>
                                    <td class="font-w600 d-none d-sm-table-cell"><span class="badge  <?php if($getData['aktif']==1){echo "badge-info";}elseif($getData['aktif']==0){echo "badge-danger";} ?>"><?php if($getData['aktif']==1){echo "Aktif";}elseif($getData['aktif']==0){echo "Pasif";} ?></span></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                        <a href="?perform=editComp&id=<?= $getData["id"]?>&comp=<?=$getData['comp']?>">
                                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Bileşen Düzenle" data-placement="bottom">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </a>
                                            <a href="../operations/controllers/portfolioCompController?perform=deleteComp&id=<?= $getData["id"]?>&portId=<?=$contentID?>&comp=<?=$getData['comp']?>" >
                                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Sil" data-placement="bottom" onclick="return confirm('<?= $getData['adi_tr']; ?> Adlı Kaydı Silmek İstediğinize Eminmisiniz? ')">
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

        #companent ekleme 1. adım
        if ($perform == "addComp_step1") { ?>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Bileşen 1 - About Project</h3>
                            <div class="block-options">
                                <div class="block-options-item">
                                    <a href="?perform=addComp_step2&comp=1&id=<?= $contentID ?>"><button type="button" class="btn btn-block-option" data-toggle="tooltip" data-placement="bottom" title="Bileşeni Uygula" ><i class="si si-action-redo"></i> </button></a>
                                </div>
                            </div>
                        </div>
                        <div class="block-content p-0">
                            <a href="?perform=addComp_step2&comp=1&id=<?= $contentID ?>" class="block block-link-shadow"><img class="w-100" src="../../uploads/components/comp-1.jpg"></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Bileşen 2 - Client Comments</h3>
                            <div class="block-options">
                                <div class="block-options-item">
                                <a href="?perform=addComp_step2&comp=2&id=<?= $contentID ?>"><button type="button" class="btn btn-block-option" data-toggle="tooltip" data-placement="bottom" title="Bileşeni Uygula" ><i class="si si-action-redo"></i> </button></a>
                                </div>
                            </div>
                        </div>
                        <div class="block-content p-0">
                            <a href="?perform=addComp_step2&comp=2&id=<?= $contentID ?>" class="block block-link-shadow"><img class="w-100" src="../../uploads/components/comp-2.jpg"></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Bileşen 3 - 2 Columns with header</h3>
                            <div class="block-options">
                                <div class="block-options-item">
                                <a href="?perform=addComp_step2&comp=3&id=<?= $contentID ?>"><button type="button" class="btn btn-block-option" data-toggle="tooltip" data-placement="bottom" title="Bileşeni Uygula" ><i class="si si-action-redo"></i> </button></a>
                                </div>
                            </div>
                        </div>
                        <div class="block-content p-0">
                            <a href="?perform=addComp_step2&comp=3&id=<?= $contentID ?>" class="block block-link-shadow"><img class="w-100" src="../../uploads/components/comp-3.jpg"></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Bileşen 4 - 2 columns with img and header</h3>
                            <div class="block-options">
                                <div class="block-options-item">
                                <a href="?perform=addComp_step2&comp=4&id=<?= $contentID ?>"><button type="button" class="btn btn-block-option" data-toggle="tooltip" data-placement="bottom" title="Bileşeni Uygula" ><i class="si si-action-redo"></i> </button></a>
                                </div>
                            </div>
                        </div>
                        <div class="block-content p-0">
                            <a href="?perform=addComp_step2&comp=4&id=<?= $contentID ?>" class="block block-link-shadow"><img class="w-100" src="../../uploads/components/comp-4.jpg"></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Bileşen 5 - 3 columns with icons</h3>
                            <div class="block-options">
                                <div class="block-options-item">
                                <a href="?perform=addComp_step2&comp=5&id=<?= $contentID ?>"><button type="button" class="btn btn-block-option" data-toggle="tooltip" data-placement="bottom" title="Bileşeni Uygula" ><i class="si si-action-redo"></i> </button></a>
                                </div>
                            </div>
                        </div>
                        <div class="block-content p-0">
                            <a href="?perform=addComp_step2&comp=5&id=<?= $contentID ?>" class="block block-link-shadow"><img class="w-100" src="../../uploads/components/comp-5.jpg"></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Bileşen 6 - Parallax</h3>
                            <div class="block-options">
                                <div class="block-options-item">
                                <a href="?perform=addComp_step2&comp=6&id=<?= $contentID ?>"><button type="button" class="btn btn-block-option" data-toggle="tooltip" data-placement="bottom" title="Bileşeni Uygula" ><i class="si si-action-redo"></i> </button></a>
                                </div>
                            </div>
                        </div>
                        <div class="block-content p-0">
                            <a href="?perform=addComp_step2&comp=6&id=<?= $contentID ?>" class="block block-link-shadow"><img class="w-100" src="../../uploads/components/comp-6.jpg"></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Bileşen 7 - One image with button</h3>
                            <div class="block-options">
                                <div class="block-options-item">
                                <a href="?perform=addComp_step2&comp=7&id=<?= $contentID ?>"><button type="button" class="btn btn-block-option" data-toggle="tooltip" data-placement="bottom" title="Bileşeni Uygula" ><i class="si si-action-redo"></i> </button></a>
                                </div>
                            </div>
                        </div>
                        <div class="block-content p-0">
                            <a href="?perform=addComp_step2&comp=7&id=<?= $contentID ?>" class="block block-link-shadow"><img class="w-100" src="../../uploads/components/comp-7.jpg"></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Bileşen 8 - 2 Images crossed</h3>
                            <div class="block-options">
                                <div class="block-options-item">
                                <a href="?perform=addComp_step2&comp=8&id=<?= $contentID ?>"><button type="button" class="btn btn-block-option" data-toggle="tooltip" data-placement="bottom" title="Bileşeni Uygula" ><i class="si si-action-redo"></i> </button></a>
                                </div>
                            </div>
                        </div>
                        <div class="block-content p-0">
                            <a href="?perform=addComp_step2&comp=8&id=<?= $contentID ?>" class="block block-link-shadow"><img class="w-100" src="../../uploads/components/comp-8.jpg"></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Bileşen 9 - 5 Images set</h3>
                            <div class="block-options">
                                <div class="block-options-item">
                                <a href="?perform=addComp_step2&comp=9&id=<?= $contentID ?>"><button type="button" class="btn btn-block-option" data-toggle="tooltip" data-placement="bottom" title="Bileşeni Uygula" ><i class="si si-action-redo"></i> </button></a>
                                </div>
                            </div>
                        </div>
                        <div class="block-content p-0">
                            <a href="?perform=addComp_step2&comp=9&id=<?= $contentID ?>" class="block block-link-shadow"><img class="w-100" src="../../uploads/components/comp-9.jpg"></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Bileşen 10 - 7 Images set</h3>
                            <div class="block-options">
                                <div class="block-options-item">
                                <a href="?perform=addComp_step2&comp=10&id=<?= $contentID ?>"><button type="button" class="btn btn-block-option" data-toggle="tooltip" data-placement="bottom" title="Bileşeni Uygula" ><i class="si si-action-redo"></i> </button></a>
                                </div>
                            </div>
                        </div>
                        <div class="block-content p-0">
                            <a href="?perform=addComp_step2&comp=10&id=<?= $contentID ?>" class="block block-link-shadow"><img class="w-100" src="../../uploads/components/comp-10.jpg"></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Bileşen 11 - Related project with 3 images linked</h3>
                            <div class="block-options">
                                <div class="block-options-item">
                                <a href="?perform=addComp_step2&comp=11&id=<?= $contentID ?>"><button type="button" class="btn btn-block-option" data-toggle="tooltip" data-placement="bottom" title="Bileşeni Uygula" ><i class="si si-action-redo"></i> </button></a>
                                </div>
                            </div>
                        </div>
                        <div class="block-content p-0">
                            <a href="?perform=addComp_step2&comp=11&id=<?= $contentID ?>" class="block block-link-shadow"><img class="w-100" src="../../uploads/components/comp-11.jpg"></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Bileşen 12 - One column image, one column text</h3>
                            <div class="block-options">
                                <div class="block-options-item">
                                <a href="?perform=addComp_step2&comp=12&id=<?= $contentID ?>"><button type="button" class="btn btn-block-option" data-toggle="tooltip" data-placement="bottom" title="Bileşeni Uygula" ><i class="si si-action-redo"></i> </button></a>
                                </div>
                            </div>
                        </div>
                        <div class="block-content p-0">
                            <a href="?perform=addComp_step2&comp=12&id=<?= $contentID ?>" class="block block-link-shadow"><img class="w-100" src="../../uploads/components/comp-12.jpg"></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Bileşen 13 - Full width image</h3>
                            <div class="block-options">
                                <div class="block-options-item">
                                <a href="?perform=addComp_step2&comp=13&id=<?= $contentID ?>"><button type="button" class="btn btn-block-option" data-toggle="tooltip" data-placement="bottom" title="Bileşeni Uygula" ><i class="si si-action-redo"></i> </button></a>
                                </div>
                            </div>
                        </div>
                        <div class="block-content p-0">
                            <a href="?perform=addComp_step2&comp=13&id=<?= $contentID ?>" class="block block-link-shadow"><img class="w-100" src="../../uploads/components/comp-13.jpg"></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Bileşen 14 - 3 images set</h3>
                            <div class="block-options">
                                <div class="block-options-item">
                                <a href="?perform=addComp_step2&comp=14&id=<?= $contentID ?>"><button type="button" class="btn btn-block-option" data-toggle="tooltip" data-placement="bottom" title="Bileşeni Uygula" ><i class="si si-action-redo"></i> </button></a>
                                </div>
                            </div>
                        </div>
                        <div class="block-content p-0">
                            <a href="?perform=addComp_step2&comp=14&id=<?= $contentID ?>" class="block block-link-shadow"><img class="w-100" src="../../uploads/components/comp-14.jpg"></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Bileşen 15 - Next project</h3>
                            <div class="block-options">
                                <div class="block-options-item">
                                <a href="?perform=addComp_step2&comp=15&id=<?= $contentID ?>"><button type="button" class="btn btn-block-option" data-toggle="tooltip" data-placement="bottom" title="Bileşeni Uygula" ><i class="si si-action-redo"></i> </button></a>
                                </div>
                            </div>
                        </div>
                        <div class="block-content p-0">
                            <a href="?perform=addComp_step2&comp=15&id=<?= $contentID ?>" class="block block-link-shadow"><img class="w-100" src="../../uploads/components/comp-15.jpg"></a>
                        </div>
                    </div>
                </div>
            </div>

        <?php }

        // companent ekleme 2. adım
        if ($perform == "addComp_step2") {

            $compID = $_GET['comp'];

            switch($compID){
            
                // about us
                case 1: ?>
                <!-- about us bileşeni -->
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

                            <!-- Geri dönme butonu -->
                            <li class="nav-item ml-auto">
                                <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()" style="margin: 10px;  padding: 10px;">GERİ DÖN</button>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            
                            <!-- Türkçe content ekleme alanı -->
                            <?php if ($turkish == "on") { ?>
                                <div class="tab-pane active" id="turkce" role="tabpanel">
                                    <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_1_tr" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Açıklama</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_1_tr" rows="6" placeholder="İçerik açıklaması.." required></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <!-- İngilizce content düzenleme alanı -->
                            <?php if ($english == "on") { ?>
                                <div class="tab-pane >" id="ingilizce" role="tabpanel">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_1_en" placeholder="Lütfen Doldurun">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Açıklama</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_1_en" rows="6" placeholder="İçerik açıklaması.."></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" checked>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $contentID ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="addComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <?php
                break;
                
                // client comments
                case 2: ?>
                <!-- Client Comments -->
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

                            <!-- Geri dönme butonu -->
                            <li class="nav-item ml-auto">
                                <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()" style="margin: 10px;  padding: 10px;">GERİ DÖN</button>
                            </li>
                        </ul>
                        <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                        <div class="block-content tab-content">
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Müşteri Adı</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="baslik_1_tr" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Firma Adı</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="baslik_2_tr" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                </div>
                            </div>
                            <!-- Türkçe content ekleme alanı -->
                            <?php if ($turkish == "on") { ?>
                                <div class="tab-pane active" id="turkce" role="tabpanel">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Açıklama</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_1_tr" rows="6" placeholder="İçerik açıklaması.." required></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- İngilizce content düzenleme alanı -->
                            <?php if ($english == "on") { ?>
                                <div class="tab-pane >" id="ingilizce" role="tabpanel">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Açıklama</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_1_en" rows="6" placeholder="İçerik açıklaması.."></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" checked>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $contentID ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="addComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <?php
                break;
            
                // 2 Columns with header
                case 3: ?>
                <!-- 2 Columns with header -->
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

                            <!-- Geri dönme butonu -->
                            <li class="nav-item ml-auto">
                                <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()" style="margin: 10px;  padding: 10px;">GERİ DÖN</button>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            <!-- Türkçe content ekleme alanı -->
                            <?php if ($turkish == "on") { ?>
                                <div class="tab-pane active" id="turkce" role="tabpanel">
                                    <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 1</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_1_tr" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf 1</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_1_tr" rows="6" placeholder="İçerik açıklaması.." required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 2</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_2_tr" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf 2</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_2_tr" rows="6" placeholder="İçerik açıklaması.." required></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- İngilizce content düzenleme alanı -->
                            <?php if ($english == "on") { ?>
                                <div class="tab-pane >" id="ingilizce" role="tabpanel">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 1</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_1_en" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf 1</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_1_en" rows="6" placeholder="İçerik açıklaması.."></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 2</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_2_en" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf 2</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_2_en" rows="6" placeholder="İçerik açıklaması.."></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" checked>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $contentID ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="addComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio?statu=ok"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                break;

                // 2 columns with img and header
                case 4: ?>
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

                            <!-- Geri dönme butonu -->
                            <li class="nav-item ml-auto">
                                <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()" style="margin: 10px;  padding: 10px;">GERİ DÖN</button>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            <!-- Türkçe content ekleme alanı -->
                            <?php if ($turkish == "on") { ?>
                                <div class="tab-pane active" id="turkce" role="tabpanel">
                                    <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 1</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_1_tr" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 2</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_2_tr" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf</label>
                                        <div class="col-lg-10">
                                            <textarea class="js-summernote" name="aciklama_1_tr" rows="6" placeholder="İçerik açıklaması.." required></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- İngilizce content düzenleme alanı -->
                            <?php if ($english == "on") { ?>
                                <div class="tab-pane >" id="ingilizce" role="tabpanel">
                                <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 1</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_1_en" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 2</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_2_en" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf</label>
                                        <div class="col-lg-10">
                                            <textarea class="js-summernote" name="aciklama_1_en" rows="6" placeholder="İçerik açıklaması.."></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Görsel</label>
                                <div class="col-lg-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider"><br>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" size="42" accept="image/*" data-toggle="custom-file-input" oninput="imgSlider()" required>
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" checked>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $contentID ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="addComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio?statu=ok"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                break;

                // 3 columns with icons
                case 5: ?>
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

                            <!-- Geri dönme butonu -->
                            <li class="nav-item ml-auto">
                                <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()" style="margin: 10px;  padding: 10px;">GERİ DÖN</button>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            <!-- Türkçe content ekleme alanı -->
                            <?php if ($turkish == "on") { ?>
                                <div class="tab-pane active" id="turkce" role="tabpanel">
                                    <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 1</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_1_tr" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf 1</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_1_tr" rows="6" placeholder="İçerik açıklaması.." required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 2</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_2_tr" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf 2</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_2_tr" rows="6" placeholder="İçerik açıklaması.." required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 3</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_3_tr" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf 3</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_3_tr" rows="6" placeholder="İçerik açıklaması.." required></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- İngilizce content düzenleme alanı -->
                            <?php if ($english == "on") { ?>
                                <div class="tab-pane >" id="ingilizce" role="tabpanel">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 1</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_1_en" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf 1</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_1_en" rows="6" placeholder="İçerik açıklaması.."> </textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 2</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_2_en" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf 2</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_2_en" rows="6" placeholder="İçerik açıklaması.."> </textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 3</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_3_en" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf 3</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_3_en" rows="6" placeholder="İçerik açıklaması.."> </textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" checked>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $contentID ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="addComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio?statu=ok"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                break;
                
                // Parallax
                case 6: ?>
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

                            <!-- Geri dönme butonu -->
                            <li class="nav-item ml-auto">
                                <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()" style="margin: 10px;  padding: 10px;">GERİ DÖN</button>
                            </li>
                        </ul>
                        <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                        <div class="block-content tab-content">
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Müşteri Adı</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="baslik_1_tr" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Firma Adı</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="baslik_2_tr" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                </div>
                            </div>
                            <!-- Türkçe content ekleme alanı -->
                            <?php if ($turkish == "on") { ?>
                                <div class="tab-pane active" id="turkce" role="tabpanel">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Yorum</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_1_tr" rows="6" placeholder="İçerik açıklaması.."></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- İngilizce content düzenleme alanı -->
                            <?php if ($english == "on") { ?>
                                <div class="tab-pane >" id="ingilizce" role="tabpanel">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Yorum</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_1_en" rows="6" placeholder="İçerik açıklaması.."></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Görsel</label>
                                <div class="col-lg-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider"><br>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" size="42" accept="image/*" data-toggle="custom-file-input" oninput="imgSlider()">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" checked>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $contentID ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="addComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                break;

                // One image with button
                case 7: ?>
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

                            <!-- Geri dönme butonu -->
                            <li class="nav-item ml-auto">
                                <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()" style="margin: 10px;  padding: 10px;">GERİ DÖN</button>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            
                            <!-- Türkçe content ekleme alanı -->
                            <?php if ($turkish == "on") { ?>
                                <div class="tab-pane active" id="turkce" role="tabpanel">
                                    <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Buton Adı</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_1_tr" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Buton link</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="link_1_tr" placeholder="Lütfen Doldurun" required>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <!-- İngilizce content düzenleme alanı -->
                            <?php if ($english == "on") { ?>
                                <div class="tab-pane >" id="ingilizce" role="tabpanel">
                                <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Buton Adı</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_1_tr" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Buton link</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="link_1_en" placeholder="Lütfen Doldurun">
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Görsel</label>
                                <div class="col-lg-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider"><br>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" size="42" accept="image/*" data-toggle="custom-file-input" oninput="imgSlider()" required>
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" checked>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $contentID ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="addComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                break;

                // 2 Images crossed
                case 8: ?>
                <div class="block block-fx-shadow">
                    <div class="block">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">2 Images crossed</h3>
                            <div class="block-options">
                                <div class="block-options-item">
                                    <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()">GERİ DÖN</button>
                                </div>
                            </div>
                        </div>
                        <div class="block-content tab-content">
                            <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Görsel 1</label>
                                <div class="col-lg-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider"  id="file1"><br>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" multiple="multiple" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file1').src = window.URL.createObjectURL(this.files[0])" required>
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Görsel 2</label>
                                <div class="col-lg-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file2"><br>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" multiple="multiple" size="42" accept="image/*" onchange="document.getElementById('file2').src = window.URL.createObjectURL(this.files[0])" data-toggle="custom-file-input" required>
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" checked>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $contentID ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="addComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                break;

                // 5 Images set
                case 9: ?>
                <div class="block block-fx-shadow">
                    <div class="block">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">5 Images set bileşeni ekle</h3>
                            <div class="block-options">
                                <div class="block-options-item">
                                <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()">GERİ DÖN</button>
                                </div>
                            </div>
                        </div>
                        <div class="block-content tab-content">
                        <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" >Görsel 1</label>
                                <div class="col-md-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file1"><br>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file1').src = window.URL.createObjectURL(this.files[0])" required>
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                                <label class="col-md-2 col-form-label" >Görsel 2</label>
                                <div class="col-md-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file2"><br>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file2').src = window.URL.createObjectURL(this.files[0])" required>
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" >Görsel 3</label>
                                <div class="col-md-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file3"><br>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file3').src = window.URL.createObjectURL(this.files[0])" required>
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                                <label class="col-md-2 col-form-label" >Görsel 4</label>
                                <div class="col-md-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file4"><br>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file4').src = window.URL.createObjectURL(this.files[0])" required>
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" >Görsel 5</label>
                                <div class="col-md-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file5"><br>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file5').src = window.URL.createObjectURL(this.files[0])" required>
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" checked>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $contentID ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="addComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                break;

                // 7 images set
                case 10: ?>
                <div class="block block-fx-shadow">
                    <div class="block">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">7 Images set bileşeni ekle</h3>
                            <div class="block-options">
                                <div class="block-options-item">
                                <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()">GERİ DÖN</button>
                                </div>
                            </div>
                        </div>
                        <div class="block-content tab-content">
                        <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" >Görsel 1</label>
                                <div class="col-md-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file1"><br>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file1').src = window.URL.createObjectURL(this.files[0])" required>
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                                <label class="col-md-2 col-form-label" >Görsel 2</label>
                                <div class="col-md-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file2"><br>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file2').src = window.URL.createObjectURL(this.files[0])" required>
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" >Görsel 3</label>
                                <div class="col-md-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file3"><br>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file3').src = window.URL.createObjectURL(this.files[0])" required>
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                                <label class="col-md-2 col-form-label" >Görsel 4</label>
                                <div class="col-md-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file4"><br>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file4').src = window.URL.createObjectURL(this.files[0])" required>
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" >Görsel 5</label>
                                <div class="col-md-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file5"><br>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file5').src = window.URL.createObjectURL(this.files[0])" required>
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                                <label class="col-md-2 col-form-label" >Görsel 6</label>
                                <div class="col-md-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file6"><br>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file6').src = window.URL.createObjectURL(this.files[0])" required>
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" >Görsel 7</label>
                                <div class="col-md-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file7"><br>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file7').src = window.URL.createObjectURL(this.files[0])" required>
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" checked>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $contentID ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="addComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                break;

                // related project
                case 11: ?>
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

                            <!-- Geri dönme butonu -->
                            <li class="nav-item ml-auto">
                                <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()" style="margin: 10px;  padding: 10px;">GERİ DÖN</button>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            
                            <!-- Türkçe content ekleme alanı -->
                            <?php if ($turkish == "on") { ?>
                                <div class="tab-pane active" id="turkce" role="tabpanel">
                                <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Görsel 1 link</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="link_1_tr" placeholder="Lütfen Doldurun" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Görsel 2 link</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="link_2_tr" placeholder="Lütfen Doldurun" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Görsel 3 link</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="link_3_tr" placeholder="Lütfen Doldurun" >
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <!-- İngilizce content düzenleme alanı -->
                            <?php if ($english == "on") { ?>
                                <div class="tab-pane >" id="ingilizce" role="tabpanel">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Görsel 1 link</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="link_1_en" placeholder="Lütfen Doldurun" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Görsel 2 link</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="link_2_en" placeholder="Lütfen Doldurun" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Görsel 3 link</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="link_3_en" placeholder="Lütfen Doldurun" >
                                        </div>
                                    </div>
                                </div>
                                
                            <?php } ?>
                            
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Görsel 1</label>
                                <div class="col-lg-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file1"><br>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file1').src = window.URL.createObjectURL(this.files[0])" required>
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Görsel 2</label>
                                <div class="col-lg-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file2"><br>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file2').src = window.URL.createObjectURL(this.files[0])" required>
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Görsel 3</label>
                                <div class="col-lg-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file3"><br>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file3').src = window.URL.createObjectURL(this.files[0])" required>
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" checked>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $contentID ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="addComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                break;

                // One column image, one column text
                case 12: ?>
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

                            <!-- Geri dönme butonu -->
                            <li class="nav-item ml-auto">
                                <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()" style="margin: 10px;  padding: 10px;">GERİ DÖN</button>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            <!-- Türkçe content ekleme alanı -->
                            <?php if ($turkish == "on") { ?>
                                <div class="tab-pane active" id="turkce" role="tabpanel">
                                <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_1_tr" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf</label>
                                        <div class="col-lg-10">
                                            <textarea class="js-summernote" name="aciklama_1_tr" rows="6" placeholder="İçerik açıklaması.." required></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- İngilizce content düzenleme alanı -->
                            <?php if ($english == "on") { ?>
                                <div class="tab-pane >" id="ingilizce" role="tabpanel">
                                <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_1_en" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf</label>
                                        <div class="col-lg-10">
                                            <textarea class="js-summernote" name="aciklama_1_en" rows="6" placeholder="İçerik açıklaması.."></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Görsel 1</label>
                                <div class="col-lg-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file1"><br>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file1').src = window.URL.createObjectURL(this.files[0])" required>
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                                <label class="col-lg-2 col-form-label" >Görsel 2</label>
                                <div class="col-lg-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file2"><br>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file2').src = window.URL.createObjectURL(this.files[0])" required>
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Görsel 3</label>
                                <div class="col-lg-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file3"><br>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file3').src = window.URL.createObjectURL(this.files[0])" required>
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>    
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" checked>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $contentID ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="addComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio?statu=ok"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                break;

                // Full width image
                case 13: ?>
                <div class="block block-fx-shadow">
                    <div class="block">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Full width image bileşeni ekle</h3>
                            <div class="block-options">
                                <div class="block-options-item">
                                <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()">GERİ DÖN</button>
                                </div>
                            </div>
                        </div>
                        <div class="block-content tab-content">
                        <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Görsel</label>
                                <div class="col-lg-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider"><br>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" size="42" accept="image/*" data-toggle="custom-file-input" oninput="imgSlider()" required>
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" checked>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $contentID ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="addComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                break;

                case 14: ?>
                <div class="block block-fx-shadow">
                    <div class="block">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Full width image bileşeni ekle</h3>
                            <div class="block-options">
                                <div class="block-options-item">
                                    <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()">GERİ DÖN</button>
                                </div>
                            </div>
                        </div>
                        <div class="block-content tab-content">
                        <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Görsel 1</label>
                                <div class="col-lg-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file1"><br>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file1').src = window.URL.createObjectURL(this.files[0])" required>
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                                <label class="col-lg-2 col-form-label" >Görsel 2</label>
                                <div class="col-lg-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file2"><br>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file2').src = window.URL.createObjectURL(this.files[0])" required>
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Görsel 3</label>
                                <div class="col-lg-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file3"><br>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file3').src = window.URL.createObjectURL(this.files[0])" required>
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" checked>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $contentID ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="addComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                break;

                // Next project
                case 15: ?>
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

                            <!-- Geri dönme butonu -->
                            <li class="nav-item ml-auto">
                                <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()" style="margin: 10px;  padding: 10px;">GERİ DÖN</button>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            
                            <!-- Türkçe content ekleme alanı -->
                            <?php if ($turkish == "on") { ?>
                                <div class="tab-pane active" id="turkce" role="tabpanel">
                                    <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Buton link</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="link_1_tr" placeholder="Lütfen Doldurun" required>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <!-- İngilizce content düzenleme alanı -->
                            <?php if ($english == "on") { ?>
                                <div class="tab-pane >" id="ingilizce" role="tabpanel">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Buton link</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="link_1_en" placeholder="Lütfen Doldurun" required>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" checked>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $contentID ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="addComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                break;

            }

            


        ?>

        <?php } 

        // companent düzenleme 2. adım
        if ($perform == "editComp") {

            $compID = $_GET['comp'];
            $id = $_GET['id'];

            $getData = $db->prepare("SELECT * FROM tbl_portfolio_comp WHERE id=?");
            $getData->execute(array($id));
            $result = $getData->fetch(PDO::FETCH_ASSOC);

            switch($compID){
            
                // about us
                case 1: ?>
                <!-- about us bileşeni -->
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

                            <!-- Geri dönme butonu -->
                            <li class="nav-item ml-auto">
                                <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()" style="margin: 10px;  padding: 10px;">GERİ DÖN</button>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            
                            <!-- Türkçe content ekleme alanı -->
                            <?php if ($turkish == "on") { ?>
                                <div class="tab-pane active" id="turkce" role="tabpanel">
                                    <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_1_tr" value="<?=$result['baslik_1_tr']?>" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Açıklama</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_1_tr" rows="6" placeholder="İçerik açıklaması.." required><?=$result['aciklama_1_tr']?></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <!-- İngilizce content düzenleme alanı -->
                            <?php if ($english == "on") { ?>
                                <div class="tab-pane >" id="ingilizce" role="tabpanel">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_1_en" value="<?=$result['baslik_1_en']?>" placeholder="Lütfen Doldurun">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Açıklama</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_1_en" rows="6" placeholder="İçerik açıklaması.."><?=$result['aciklama_1_en']?></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" <?php if($result['aktif']==1){echo "checked";} ?>>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $result['portfolio_id'] ?>">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="editComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <?php
                break;
                
                // client comments
                case 2: ?>
                <!-- Client Comments -->
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

                            <!-- Geri dönme butonu -->
                            <li class="nav-item ml-auto">
                                <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()" style="margin: 10px;  padding: 10px;">GERİ DÖN</button>
                            </li>
                        </ul>
                        <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                        <div class="block-content tab-content">
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Müşteri Adı</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="baslik_1_tr" value="<?=$result['baslik_1_tr']?>" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Firma Adı</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="baslik_2_tr" value="<?=$result['baslik_2_tr']?>" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                </div>
                            </div>
                            <!-- Türkçe content ekleme alanı -->
                            <?php if ($turkish == "on") { ?>
                                <div class="tab-pane active" id="turkce" role="tabpanel">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Açıklama</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_1_tr" rows="6" placeholder="İçerik açıklaması.." required><?=$result['aciklama_1_tr']?></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- İngilizce content düzenleme alanı -->
                            <?php if ($english == "on") { ?>
                                <div class="tab-pane >" id="ingilizce" role="tabpanel">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Açıklama</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_1_en" rows="6" placeholder="İçerik açıklaması.."><?=$result['aciklama_1_en']?></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" <?php if($result['aktif']==1){echo "checked";} ?>>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $result['portfolio_id'] ?>">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="editComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <?php
                break;
            
                // 2 Columns with header
                case 3: ?>
                <!-- 2 Columns with header -->
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

                            <!-- Geri dönme butonu -->
                            <li class="nav-item ml-auto">
                                <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()" style="margin: 10px;  padding: 10px;">GERİ DÖN</button>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            <!-- Türkçe content ekleme alanı -->
                            <?php if ($turkish == "on") { ?>
                                <div class="tab-pane active" id="turkce" role="tabpanel">
                                    <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 1</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_1_tr" value="<?=$result['baslik_1_tr']?>" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf 1</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_1_tr" rows="6" placeholder="İçerik açıklaması.." required><?=$result['aciklama_1_tr']?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 2</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_2_tr" value="<?=$result['baslik_2_tr']?>" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf 2</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_2_tr" rows="6" placeholder="İçerik açıklaması.." required><?=$result['aciklama_2_tr']?></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- İngilizce content düzenleme alanı -->
                            <?php if ($english == "on") { ?>
                                <div class="tab-pane >" id="ingilizce" role="tabpanel">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 1</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_1_en" value="<?=$result['baslik_1_en']?>" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf 1</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_1_en" rows="6" placeholder="İçerik açıklaması.."><?=$result['aciklama_1_en']?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 2</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_2_en" value="<?=$result['baslik_2_en']?>" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf 2</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_2_en" rows="6" placeholder="İçerik açıklaması.."><?=$result['aciklama_2_en']?></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" <?php if($result['aktif']==1){echo "checked";} ?>>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $result['portfolio_id'] ?>">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="editComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio?statu=ok"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                break;

                // 2 columns with img and header
                case 4: ?>
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

                            <!-- Geri dönme butonu -->
                            <li class="nav-item ml-auto">
                                <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()" style="margin: 10px;  padding: 10px;">GERİ DÖN</button>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            <!-- Türkçe content ekleme alanı -->
                            <?php if ($turkish == "on") { ?>
                                <div class="tab-pane active" id="turkce" role="tabpanel">
                                    <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 1</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_1_tr" value="<?=$result['baslik_1_tr']?>" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 2</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_2_tr" value="<?=$result['baslik_2_tr']?>" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf</label>
                                        <div class="col-lg-10">
                                            <textarea class="js-summernote" name="aciklama_1_tr" rows="6" placeholder="İçerik açıklaması.." required><?=$result['aciklama_1_tr']?></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- İngilizce content düzenleme alanı -->
                            <?php if ($english == "on") { ?>
                                <div class="tab-pane >" id="ingilizce" role="tabpanel">
                                <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 1</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_1_en" value="<?=$result['baslik_1_en']?>" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 2</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_2_en" value="<?=$result['baslik_2_en']?>" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf</label>
                                        <div class="col-lg-10">
                                            <textarea class="js-summernote" name="aciklama_1_en" rows="6" placeholder="İçerik açıklaması.."><?=$result['aciklama_1_en']?></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Görsel</label>
                                <div class="col-lg-4">
                                    <?php 
                                    if($resul['gorsel_1']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider"><br>
                                    <?php } else {?>
                                    <img src="../../uploads/<?=$result['gorsel_1']?>" class="w-100 upload-slider"><br>
                                    <?php }
                                    ?>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[0]" size="42" accept="image/*" data-toggle="custom-file-input" oninput="imgSlider()" >
                                        <input type="hidden" name="old-image[0]" value="<?=$result['gorsel_1']?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" checked>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $result['portfolio_id'] ?>">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="editComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio?statu=ok"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                break;

                // 3 columns with icons
                case 5: ?>
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

                            <!-- Geri dönme butonu -->
                            <li class="nav-item ml-auto">
                                <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()" style="margin: 10px;  padding: 10px;">GERİ DÖN</button>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            <!-- Türkçe content ekleme alanı -->
                            <?php if ($turkish == "on") { ?>
                                <div class="tab-pane active" id="turkce" role="tabpanel">
                                    <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 1</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_1_tr" value="<?=$result['baslik_1_tr']?>" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf 1</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_1_tr" rows="6" placeholder="İçerik açıklaması.." required><?=$result['aciklama_1_tr']?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 2</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_2_tr" value="<?=$result['baslik_2_tr']?>" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf 2</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_2_tr" rows="6" placeholder="İçerik açıklaması.." required><?=$result['aciklama_2_tr']?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 3</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_3_tr" value="<?=$result['baslik_3_tr']?>" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf 3</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_3_tr" rows="6" placeholder="İçerik açıklaması.." required><?=$result['aciklama_3_tr']?></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- İngilizce content düzenleme alanı -->
                            <?php if ($english == "on") { ?>
                                <div class="tab-pane >" id="ingilizce" role="tabpanel">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 1</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_1_en" value="<?=$result['baslik_1_en']?>" placeholder="Lütfen Doldurun" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf 1</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_1_en" rows="6" placeholder="İçerik açıklaması.."><?=$result['aciklama_1_en']?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 2</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_2_en" value="<?=$result['baslik_2_en']?>" placeholder="Lütfen Doldurun" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf 2</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_2_en" rows="6" placeholder="İçerik açıklaması.."><?=$result['aciklama_2_en']?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık 3</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_3_en" value="<?=$result['baslik_3_en']?>" placeholder="Lütfen Doldurun" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf 3</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_3_en" rows="6" placeholder="İçerik açıklaması.."><?=$result['aciklama_3_en']?></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" <?php if($result['aktif']==1){echo "checked";} ?>>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $result['portfolio_id'] ?>">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="editComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio?statu=ok"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                break;
                
                // Parallax
                case 6: ?>
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

                            <!-- Geri dönme butonu -->
                            <li class="nav-item ml-auto">
                                <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()" style="margin: 10px;  padding: 10px;">GERİ DÖN</button>
                            </li>
                        </ul>
                        <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                        <div class="block-content tab-content">
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Müşteri Adı</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="baslik_1_tr" value="<?=$result['baslik_1_tr']?>" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Firma Adı</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="baslik_2_tr" value="<?=$result['baslik_2_tr']?>" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                </div>
                            </div>
                            <!-- Türkçe content ekleme alanı -->
                            <?php if ($turkish == "on") { ?>
                                <div class="tab-pane active" id="turkce" role="tabpanel">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Yorum</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_1_tr" rows="6" placeholder="İçerik açıklaması.." required><?=$result['aciklama_1_tr']?></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- İngilizce content düzenleme alanı -->
                            <?php if ($english == "on") { ?>
                                <div class="tab-pane >" id="ingilizce" role="tabpanel">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Yorum</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" name="aciklama_1_en" rows="6" placeholder="İçerik açıklaması.."><?=$result['aciklama_1_en']?></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Görsel</label>
                                <div class="col-lg-4">
                                    <?php 
                                    if($resul['gorsel_1']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider"><br>
                                    <?php } else {?>
                                    <img src="../../uploads/<?=$result['gorsel_1']?>" class="w-100 upload-slider"><br>
                                    <?php }
                                    ?>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[0]" size="42" accept="image/*" data-toggle="custom-file-input" oninput="imgSlider()">
                                        <input type="hidden" name="old-image[0]" value="<?=$result['gorsel_1']?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" <?php if($result['aktif']==1){echo "checked";} ?>>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $result['portfolio_id'] ?>">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="editComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                break;

                // One image with button
                case 7: ?>
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

                            <!-- Geri dönme butonu -->
                            <li class="nav-item ml-auto">
                                <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()" style="margin: 10px;  padding: 10px;">GERİ DÖN</button>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            
                            <!-- Türkçe content ekleme alanı -->
                            <?php if ($turkish == "on") { ?>
                                <div class="tab-pane active" id="turkce" role="tabpanel">
                                    <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Buton Adı</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_1_tr" value="<?=$result['baslik_1_tr']?>" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Buton link</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="link_1_tr" value="<?=$result['link_1_tr']?>" placeholder="Lütfen Doldurun" required>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <!-- İngilizce content düzenleme alanı -->
                            <?php if ($english == "on") { ?>
                                <div class="tab-pane >" id="ingilizce" role="tabpanel">
                                <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Buton Adı</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_1_en" value="<?=$result['baslik_1_en']?>" placeholder="Lütfen Doldurun" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Buton link</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="link_1_en" value="<?=$result['link_1_en']?>" placeholder="Lütfen Doldurun">
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Görsel</label>
                                <div class="col-lg-4">
                                    <?php 
                                    if($result['gorsel_1']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider"><br>
                                    <?php } else {?>
                                    <img src="../../uploads/<?=$result['gorsel_1']?>" class="w-100 upload-slider"><br>
                                    <?php }

                                    ?>
                                    
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[]" size="42" accept="image/*" data-toggle="custom-file-input" oninput="imgSlider()">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" checked>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $result['portfolio_id'] ?>">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="editComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                break;

                // 2 Images crossed
                case 8: ?>
                <div class="block block-fx-shadow">
                    <div class="block">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">2 Images crossed</h3>
                            <div class="block-options">
                                <div class="block-options-item">
                                <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()">GERİ DÖN</button>
                                </div>
                            </div>
                        </div>
                        <div class="block-content tab-content">
                            <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Görsel 1</label>
                                <div class="col-lg-4">
                                <?php 
                                    if($result['gorsel_1']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file1"><br>
                                    <?php } else {?>
                                    <img src="../../uploads/<?=$result['gorsel_1']?>" class="w-100 upload-slider" id="file1"><br>
                                    <?php }

                                    ?>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[0]" multiple="multiple" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file1').src = window.URL.createObjectURL(this.files[0])" >
                                        <input type="hidden" name="old-image[0]" value="<?=$result['gorsel_1']?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Görsel 2</label>
                                <div class="col-lg-4">
                                    <?php 
                                    if($result['gorsel_2']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file2"><br>
                                    <?php } else {?>
                                    <img src="../../uploads/<?=$result['gorsel_2']?>" class="w-100 upload-slider" id="file2"><br>
                                    <?php }
                                    ?>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[1]" multiple="multiple" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file2').src = window.URL.createObjectURL(this.files[0])" >
                                        <input type="hidden" name="old-image[1]" value="<?=$result['gorsel_2']?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" <?php if($result['aktif']==1){echo "checked";} ?>>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $result['portfolio_id'] ?>">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="editComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                break;

                // 5 Images set
                case 9: ?>
                <div class="block block-fx-shadow">
                    <div class="block">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">5 Images set bileşeni ekle</h3>
                            <div class="block-options">
                                <div class="block-options-item">
                                    <button type="button" class="btn btn-block-option font-size-xl" data-toggle="tooltip" data-placement="bottom" title="Geri Dön" onclick="goBack()"><i class="si si-action-undo"></i> </button>
                                </div>
                            </div>
                        </div>
                        <div class="block-content tab-content">
                        <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" >Görsel 1</label>
                                <div class="col-md-4">
                                    <?php 
                                    if($result['gorsel_1']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file1"><br>
                                    <?php } else {?>
                                    <img src="../../uploads/<?=$result['gorsel_1']?>" class="w-100 upload-slider" id="file1"><br>
                                    <?php }
                                    ?>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[0]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file1').src = window.URL.createObjectURL(this.files[0])" >
                                        <input type="hidden" name="old-image[0]" value="<?=$result['gorsel_1']?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                                <label class="col-md-2 col-form-label" >Görsel 2</label>
                                <div class="col-md-4">
                                    <?php 
                                    if($result['gorsel_2']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file2"><br>
                                    <?php } else {?>
                                    <img src="../../uploads/<?=$result['gorsel_2']?>" class="w-100 upload-slider" id="file2"><br>
                                    <?php }
                                    ?>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[1]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file2').src = window.URL.createObjectURL(this.files[0])">
                                        <input type="hidden" name="old-image[1]" value="<?=$result['gorsel_2']?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" >Görsel 3</label>
                                <div class="col-md-4">
                                    <?php 
                                    if($result['gorsel_3']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file3"><br>
                                    <?php } else {?>
                                    <img src="../../uploads/<?=$result['gorsel_3']?>" class="w-100 upload-slider" id="file3"><br>
                                    <?php }
                                    ?>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[2]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file3').src = window.URL.createObjectURL(this.files[0])">
                                        <input type="hidden" name="old-image[2]" value="<?=$result['gorsel_3']?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                                <label class="col-md-2 col-form-label" >Görsel 4</label>
                                <div class="col-md-4">
                                    <?php 
                                    if($result['gorsel_4']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file4"><br>
                                    <?php } else {?>
                                    <img src="../../uploads/<?=$result['gorsel_4']?>" class="w-100 upload-slider" id="file4"><br>
                                    <?php }
                                    ?>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[3]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file4').src = window.URL.createObjectURL(this.files[0])">
                                        <input type="hidden" name="old-image[3]" value="<?=$result['gorsel_4']?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" >Görsel 5</label>
                                <div class="col-md-4">
                                    <?php 
                                    if($result['gorsel_5']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file5"><br>
                                    <?php } else {?>
                                    <img src="../../uploads/<?=$result['gorsel_5']?>" class="w-100 upload-slider" id="file5"><br>
                                    <?php }
                                    ?>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[4]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file5').src = window.URL.createObjectURL(this.files[0])">
                                        <input type="hidden" name="old-image[4]" value="<?=$result['gorsel_5']?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" <?php if($result['aktif']==1){echo "checked";} ?>>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $result['portfolio_id'] ?>">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="editComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                break;

                // 7 images set
                case 10: ?>
                <div class="block block-fx-shadow">
                    <div class="block">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">7 Images set bileşeni ekle</h3>
                            <div class="block-options">
                                <div class="block-options-item">
                                    <button type="button" class="btn btn-block-option font-size-xl" data-toggle="tooltip" data-placement="bottom" title="Geri Dön" onclick="goBack()"><i class="si si-action-undo"></i> </button>
                                </div>
                            </div>
                        </div>
                        <div class="block-content tab-content">
                        <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" >Görsel 1</label>
                                <div class="col-md-4">
                                    <?php 
                                    if($result['gorsel_1']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file1"><br>
                                    <?php } else {?>
                                    <img src="../../uploads/<?=$result['gorsel_1']?>" class="w-100 upload-slider" id="file1"><br>
                                    <?php }
                                    ?>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[0]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file1').src = window.URL.createObjectURL(this.files[0])">
                                        <input type="hidden" name="old-image[0]" value="<?=$result['gorsel_1']?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                                <label class="col-md-2 col-form-label" >Görsel 2</label>
                                <div class="col-md-4">
                                    <?php 
                                    if($result['gorsel_2']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file2"><br>
                                    <?php } else {?>
                                    <img src="../../uploads/<?=$result['gorsel_2']?>" class="w-100 upload-slider" id="file2"><br>
                                    <?php }
                                    ?>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[1]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file2').src = window.URL.createObjectURL(this.files[0])">
                                        <input type="hidden" name="old-image[1]" value="<?=$result['gorsel_2']?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" >Görsel 3</label>
                                <div class="col-md-4">
                                    <?php 
                                    if($result['gorsel_3']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file3"><br>
                                    <?php } else {?>
                                    <img src="../../uploads/<?=$result['gorsel_3']?>" class="w-100 upload-slider" id="file3"><br>
                                    <?php }
                                    ?>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[2]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file3').src = window.URL.createObjectURL(this.files[0])">
                                        <input type="hidden" name="old-image[2]" value="<?=$result['gorsel_3']?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                                <label class="col-md-2 col-form-label" >Görsel 4</label>
                                <div class="col-md-4">
                                    <?php 
                                    if($result['gorsel_4']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file4"><br>
                                    <?php } else {?>
                                    <img src="../../uploads/<?=$result['gorsel_4']?>" class="w-100 upload-slider" id="file4"><br>
                                    <?php }
                                    ?>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[3]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file4').src = window.URL.createObjectURL(this.files[0])">
                                        <input type="hidden" name="old-image[3]" value="<?=$result['gorsel_4']?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" >Görsel 5</label>
                                <div class="col-md-4">
                                    <?php 
                                    if($result['gorsel_5']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file5"><br>
                                    <?php } else {?>
                                    <img src="../../uploads/<?=$result['gorsel_5']?>" class="w-100 upload-slider" id="file5"><br>
                                    <?php }
                                    ?>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[4]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file5').src = window.URL.createObjectURL(this.files[0])">
                                        <input type="hidden" name="old-image[4]" value="<?=$result['gorsel_5']?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                                <label class="col-md-2 col-form-label" >Görsel 6</label>
                                <div class="col-md-4">
                                    <?php 
                                    if($result['gorsel_6']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file6"><br>
                                    <?php } else {?>
                                    <img src="../../uploads/<?=$result['gorsel_6']?>" class="w-100 upload-slider" id="file6"><br>
                                    <?php }
                                    ?>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[5]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file6').src = window.URL.createObjectURL(this.files[0])">
                                        <input type="hidden" name="old-image[5]" value="<?=$result['gorsel_6']?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" >Görsel 7</label>
                                <div class="col-md-4">
                                    <?php 
                                    if($result['gorsel_7']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file7"><br>
                                    <?php } else {?>
                                    <img src="../../uploads/<?=$result['gorsel_7']?>" class="w-100 upload-slider" id="file7"><br>
                                    <?php }
                                    ?>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[6]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file7').src = window.URL.createObjectURL(this.files[0])">
                                        <input type="hidden" name="old-image[6]" value="<?=$result['gorsel_7']?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" <?php if($result['aktif']==1){echo "checked";} ?>>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $result['portfolio_id'] ?>">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="editComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                break;

                // related project
                case 11: ?>
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

                            <!-- Geri dönme butonu -->
                            <li class="nav-item ml-auto">
                                <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()" style="margin: 10px;  padding: 10px;">GERİ DÖN</button>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            
                            <!-- Türkçe content ekleme alanı -->
                            <?php if ($turkish == "on") { ?>
                                <div class="tab-pane active" id="turkce" role="tabpanel">
                                <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Görsel 1 link</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="link_1_tr" value="<?=$result['link_1_en']?>" placeholder="Lütfen Doldurun" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Görsel 2 link</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="link_2_tr" value="<?=$result['link_1_en']?>" placeholder="Lütfen Doldurun" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Görsel 3 link</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="link_3_tr" value="<?=$result['link_1_en']?>" placeholder="Lütfen Doldurun" >
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <!-- İngilizce content düzenleme alanı -->
                            <?php if ($english == "on") { ?>
                                <div class="tab-pane >" id="ingilizce" role="tabpanel">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Görsel 1 link</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="link_1_en" value="<?=$result['link_1_en']?>" placeholder="Lütfen Doldurun" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Görsel 2 link</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="link_2_en" value="<?=$result['link_1_en']?>" placeholder="Lütfen Doldurun" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Görsel 3 link</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="link_3_en" value="<?=$result['link_1_en']?>" placeholder="Lütfen Doldurun" >
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Görsel 1</label>
                                <div class="col-lg-4">
                                    <?php 
                                    if($result['gorsel_1']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file1"><br>
                                    <?php } else {?>
                                    <img src="../../uploads/<?=$result['gorsel_1']?>" class="w-100 upload-slider" id="file1"><br>
                                    <?php }
                                    ?>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[0]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file1').src = window.URL.createObjectURL(this.files[0])">
                                        <input type="hidden" name="old-image[0]" value="<?=$result['gorsel_1']?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Görsel 2</label>
                                <div class="col-lg-4">
                                    <?php 
                                    if($result['gorsel_2']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file2"><br>
                                    <?php } else {?>
                                    <img src="../../uploads/<?=$result['gorsel_2']?>" class="w-100 upload-slider" id="file2"><br>
                                    <?php }
                                    ?>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[1]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file2').src = window.URL.createObjectURL(this.files[0])">
                                        <input type="hidden" name="old-image[1]" value="<?=$result['gorsel_2']?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Görsel 3</label>
                                <div class="col-lg-4">
                                    <?php 
                                    if($result['gorsel_3']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file3"><br>
                                    <?php } else {?>
                                    <img src="../../uploads/<?=$result['gorsel_3']?>" class="w-100 upload-slider" id="file3"><br>
                                    <?php }
                                    ?>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[2]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file3').src = window.URL.createObjectURL(this.files[0])">
                                        <input type="hidden" name="old-image[2]" value="<?=$result['gorsel_3']?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" <?php if($result['aktif']==1){echo "checked";} ?>>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $result['portfolio_id'] ?>">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="editComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                break;

                // One column image, one column text
                case 12: ?>
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

                            <!-- Geri dönme butonu -->
                            <li class="nav-item ml-auto">
                                <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()" style="margin: 10px;  padding: 10px;">GERİ DÖN</button>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            <!-- Türkçe content ekleme alanı -->
                            <?php if ($turkish == "on") { ?>
                                <div class="tab-pane active" id="turkce" role="tabpanel">
                                <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_1_tr" value="<?=$result['baslik_1_tr']?>" placeholder="Lütfen Doldurun" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf</label>
                                        <div class="col-lg-10">
                                            <textarea class="js-summernote" name="aciklama_1_tr" rows="6" placeholder="İçerik açıklaması.." required><?=$result['aciklama_1_tr']?></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- İngilizce content düzenleme alanı -->
                            <?php if ($english == "on") { ?>
                                <div class="tab-pane >" id="ingilizce" role="tabpanel">
                                <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Başlık</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="baslik_1_en" value="<?=$result['baslik_1_en']?>" placeholder="Lütfen Doldurun" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Paragraf</label>
                                        <div class="col-lg-10">
                                            <textarea class="js-summernote" name="aciklama_1_en" rows="6" placeholder="İçerik açıklaması.."><?=$result['aciklama_1_en']?><</textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Görsel 1</label>
                                <div class="col-lg-4">
                                    <?php 
                                    if($result['gorsel_1']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file1"><br>
                                    <?php } else {?>
                                    <img src="../../uploads/<?=$result['gorsel_1']?>" class="w-100 upload-slider" id="file1"><br>
                                    <?php }
                                    ?>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[0]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file1').src = window.URL.createObjectURL(this.files[0])">
                                        <input type="hidden" name="old-image[0]" value="<?=$result['gorsel_1']?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                                <label class="col-lg-2 col-form-label" >Görsel 2</label>
                                <div class="col-lg-4">
                                    <?php 
                                    if($result['gorsel_2']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file2"><br>
                                    <?php } else {?>
                                    <img src="../../uploads/<?=$result['gorsel_2']?>" class="w-100 upload-slider" id="file2"><br>
                                    <?php }
                                    ?>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[1]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file2').src = window.URL.createObjectURL(this.files[0])">
                                        <input type="hidden" name="old-image[1]" value="<?=$result['gorsel_2']?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Görsel 3</label>
                                <div class="col-lg-4">
                                    <?php 
                                    if($result['gorsel_3']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file3"><br>
                                    <?php } else {?>
                                    <img src="../../uploads/<?=$result['gorsel_3']?>" class="w-100 upload-slider" id="file3"><br>
                                    <?php }
                                    ?>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[2]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file3').src = window.URL.createObjectURL(this.files[0])">
                                        <input type="hidden" name="old-image[2]" value="<?=$result['gorsel_3']?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>    
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" <?php if($result['aktif']==1){echo "checked";} ?>>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $result['portfolio_id'] ?>">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="editComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio?statu=ok"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                break;

                // Full width image
                case 13: ?>
                <div class="block block-fx-shadow">
                    <div class="block">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Full width image bileşeni ekle</h3>
                            <div class="block-options">
                                <div class="block-options-item">
                                <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()" style="margin: 10px;  padding: 10px;">GERİ DÖN</button>
                                </div>
                            </div>
                        </div>
                        <div class="block-content tab-content">
                        <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Görsel</label>
                                <div class="col-lg-4">
                                    <?php 
                                    if($result['gorsel_1']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider"><br>
                                    <?php } else {?>
                                    <img src="../../uploads/<?=$result['gorsel_1']?>" class="w-100 upload-slider"><br>
                                    <?php }
                                    ?>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[0]" size="42" accept="image/*" data-toggle="custom-file-input" oninput="imgSlider()" >
                                        <input type="hidden" name="old-image[0]" value="<?=$result['gorsel_1']?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" <?php if($result['aktif']==1){echo "checked";} ?>>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $result['portfolio_id'] ?>">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="editComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                break;

                case 14: ?>
                <div class="block block-fx-shadow">
                    <div class="block">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Full width image bileşeni ekle</h3>
                            <div class="block-options">
                                <div class="block-options-item">
                                    <button type="button" class="btn btn-block-option font-size-xl" data-toggle="tooltip" data-placement="bottom" title="Geri Dön" onclick="goBack()"><i class="si si-action-undo"></i> </button>
                                </div>
                            </div>
                        </div>
                        <div class="block-content tab-content">
                        <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Görsel 1</label>
                                <div class="col-lg-4">
                                    <?php 
                                    if($result['gorsel_1']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file1"><br>
                                    <?php } else {?>
                                    <img src="../../uploads/<?=$result['gorsel_1']?>" class="w-100 upload-slider" id="file1"><br>
                                    <?php }
                                    ?>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[0]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file1').src = window.URL.createObjectURL(this.files[0])">
                                        <input type="hidden" name="old-image[0]" value="<?=$result['gorsel_1']?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                                <label class="col-lg-2 col-form-label" >Görsel 2</label>
                                <div class="col-lg-4">
                                    <?php 
                                    if($result['gorsel_2']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file2"><br>
                                    <?php } else {?>
                                    <img src="../../uploads/<?=$result['gorsel_2']?>" class="w-100 upload-slider" id="file2"><br>
                                    <?php }
                                    ?>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[1]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file2').src = window.URL.createObjectURL(this.files[0])">
                                        <input type="hidden" name="old-image[1]" value="<?=$result['gorsel_2']?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" >Görsel 3</label>
                                <div class="col-lg-4">
                                    <?php 
                                    if($result['gorsel_3']=="noimage.jpg"){?>
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider" id="file3"><br>
                                    <?php } else {?>
                                    <img src="../../uploads/<?=$result['gorsel_3']?>" class="w-100 upload-slider" id="file3"><br>
                                    <?php }
                                    ?>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim[2]" size="42" accept="image/*" data-toggle="custom-file-input" onchange="document.getElementById('file3').src = window.URL.createObjectURL(this.files[0])">
                                        <input type="hidden" name="old-image[2]" value="<?=$result['gorsel_3']?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" <?php if($result['aktif']==1){echo "checked";} ?>>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $result['portfolio_id'] ?>">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="editComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                break;

                // Next project
                case 15: ?>
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

                            <!-- Geri dönme butonu -->
                            <li class="nav-item ml-auto">
                                <button class="btn btn-sm btn-hero btn-outline-secondary" onclick="goBack()" style="margin: 10px;  padding: 10px;">GERİ DÖN</button>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            
                            <!-- Türkçe content ekleme alanı -->
                            <?php if ($turkish == "on") { ?>
                                <div class="tab-pane active" id="turkce" role="tabpanel">
                                    <form action="../operations/controllers/portfolioCompController" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Buton link</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="link_1_tr" value="<?=$result['link_1_tr']?>" placeholder="Lütfen Doldurun" required>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <!-- İngilizce content düzenleme alanı -->
                            <?php if ($english == "on") { ?>
                                <div class="tab-pane >" id="ingilizce" role="tabpanel">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" >Buton link</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="link_1_en" value="<?=$result['link_1_en']?>"  placeholder="Lütfen Doldurun" required>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            
                            <!-- durum -->
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Aktif</label>
                                <div class="col-lg-2" style="display: flex;">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" <?php if($result['aktif']==1){echo "checked";} ?>>
                                        <span class="css-control-indicator"></span> Bileşen Aktif
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="<?= $_GET['comp'] ?>">
                            <input type="hidden" name="portfolio_id" value="<?= $result['portfolio_id'] ?>">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <!-- Türkçe dil hata mesajı -->
                            <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <button type="submit" name="editComp" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                        <a href="portfolio"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                break;

            }

            


        ?>

        <?php }

        #Toplu resim yükleme
        if ($perform=="foto") {?>
        <div class="block block-fx-shadow">
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">İÇERİK DÜZENLEME</h3>
                    <div class="block-options">
                        <a href="hizmetler"> <button class="btn btn-sm btn-hero btn-outline-secondary"> GERİ DÖN</button></a>
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

            $getImg = $db->prepare('SELECT * FROM tbl_galeri WHERE hizmet_id=? ORDER BY id DESC');
            $getImg->execute(array($contentID));

            while ($result = $getImg->fetch(PDO::FETCH_ASSOC)) {  ?>

                <div class="col-md-3 animated fadeIn">
                    <div class="options-container fx-item-zoom-in fx-overlay-zoom-in" style=" height: 200px; background-image: url(../../uploads/<?= $result["gorsel"] ?>); background-size: cover;">
                        <div class="options-overlay bg-black-op">
                            <div class="options-overlay-content">
                                <a class="btn btn-sm btn-rounded btn-alt-danger min-width-75" href="../operations/controllers/imageUploadController?perform=deleteImage&id=<?= $result["id"]?>&contentID=<?= $result["hizmet_id"] ?>&pageName=hizmet">
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


