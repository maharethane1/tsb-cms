<?php

$authPageName = "content";
$activeClass ="sube";
$pageTitle = "Maharethane - Şube Yönetimi";
include('layouts/header.php');
include('../operations/middleware/AuthorizationMiddleware.php');
$perform = $_GET['perform'];
$contentID = $_GET['id'];
$controllerName ="sube";

?>

<main id="main-container">
    <!-- Page Content -->
    <div class="content">
        <div class="block block-transparent bg-video" data-vide-bg="assets/media/videos/city_night" data-vide-options="posterType: jpg" style="position: relative;"><div style="position: absolute; z-index: -1; inset: 0px; overflow: hidden; background-size: cover; background-color: transparent; background-repeat: no-repeat; background-position: 50% 50%; background-image: none;"><video autoplay="" loop="" muted="" style="margin: auto; position: absolute; z-index: -1; top: 50%; left: 50%; transform: translate(-50%, -50%); visibility: visible; opacity: 1; width: 1154px; height: auto;"><source src="assets/media/videos/city_night.mp4" type="video/mp4"><source src="assets/media/videos/city_night.webm" type="video/webm"><source src="assets/media/videos/city_night.ogv" type="video/ogg"></video></div>
            <div class="block-content bg-primary-dark-op">
                <div class="py-20 text-center">
                    <h1 class="font-w700 text-white mb-10">Şube Yönetimi</h1>
                    <h2 class="h4 font-w400 text-white-op">Sistemde bulunan ya da bulunacak şubelerinizi bu sayfadan yönetebilirsiniz.</h2>
                </div>
            </div>
        </div>
        <?php
        #Aksiyon olmadan sayfa açılımı
        if ($perform == "" or $perform == NULL) { ?>
            <!-- Kayıtlı içerikleri görüntüleme -->
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">ŞUBELER</h3>
                    <div class="block-options">
                        <div class="block-options-item">
                            <a href="?perform=add"> <button class="btn btn-sm btn-hero btn-outline-secondary"> YENİ EKLE</button></a>
                        </div>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <!-- DataTables functionality is initialized with .js-dataTable-full class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                    <table id="sort" class="table table-bordered table-striped table-vcenter js-dataTable-full background-white" >
                        <thead>
                            <tr>
                                <th class="d-none">Sıra</th>
                                <th>Şube Adı</th>
                                <th class="d-none d-sm-table-cell">Adres</th>
                                <th class="d-none d-sm-table-cell" style="width: 5%">Durum</th>
                                <th class="text-center" style="width: 7%;">İşlem</th>
                                <th class="text-center" style="width: 5%;">Taşı</th>
                            </tr>
                        </thead>
                        <tbody id="sortItems">

                            <?php
                            #Sayfa bilgilerini database den çek
                            $pageData = $db->prepare("SELECT * FROM tbl_sube ORDER BY sira ASC");
                            $pageData->execute();

                            #Sorguya uygun kayıtları döngüye al
                            while ($getData = $pageData->fetch(PDO::FETCH_ASSOC)) { ?>

                                <tr data-id="<?= $getData['id']?>">
                                    <td class="d-none"><?=$getData['sira']?></td>
                                    <td class="font-w600"><?= $getData['adi'] ?> </td>
                                    <td class="font-w600 d-none d-sm-table-cell"><?= substr($getData["adres"], 0, 90 )."..."; ?></td>
                                    <td class="font-w600 d-none d-sm-table-cell text-center"><span class="badge  <?php if($getData['aktif']==1){echo "badge-info";}else{echo "badge-danger";} ?>"><?php if($getData['aktif']==1){echo "Aktif";}else{echo "Pasif";} ?></span></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="?perform=edit&id=<?= $getData["id"] ?>"><button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="İçerik Düzenle" data-placement="bottom">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                            </a>
                                            <a href="../operations/controllers/subeController?perform=delete&id=<?= $getData["id"]; ?>&adi=<?= $getData["adi"]; ?>" onclick="return confirm('<?= $getData['adi']; ?> adlı kullanıcı sistemdem kalıcı olarak silinecek. İşlemi onaylıyor musunuz? ')">
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
            <div class="col-lg-12">
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Şube Ekle</h3>
                        <div class="block-options">
                            <div class="block-options-item">
                                <a href="subeler"><button class="btn btn-sm btn-hero btn-outline-secondary">GERİ DÖN</button></a>
                            </div>
                        </div>
                    </div>
                    <div class="block-content">
                        <form action="../operations/controllers/subeController" method="post" enctype="multipart/form-data">
                            <!-- kullanıcı statu belirleme alanı -->
                            <div class="form-group row">
                                <div class="col-12">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" checked>
                                        <span class="css-control-indicator"></span> Şube Aktif
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >Şube Adı</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control"  name="adi" placeholder="Lütfen Doldurun" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >Adresi</label>
                                <div class="col-lg-10">
                                <textarea class="form-control" name="adres" rows="6" placeholder="Lütfen doldurun.."></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >Telefon</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control"  name="telefon" placeholder="Lütfen Doldurun">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >Fax</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control"  name="fax" placeholder="Lütfen Doldurun"  >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >E-mail</label>
                                <div class="col-lg-10">
                                    <input type="email" class="form-control"  name="email" placeholder="Lütfen Doldurun"  >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >Konum</label>
                                <div class="col-lg-10">
                                <textarea class="form-control" name="konum" rows="6" placeholder="Lütfen Doldurun.."></textarea>
                                </div>
                            </div>
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >Görsel</label>
                                <div class="col-lg-5">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider">
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim" size="42" accept="image/*" data-toggle="custom-file-input" oninput="imgSlider()">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-10 text-right offset-lg-3">
                                    <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                            <div class="block-options">
                                <div class="block-options-item">
                                    <button type="submit" name="add" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                    <a href="subeler?statu=ok"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php }

        #Content düzenleme alanı ($_GET['perform']=="edit" ise aşağıdaki kod bloğu çalışacak)
        if ($perform == "edit") {

            $getContent = $db->prepare("SELECT * FROM tbl_sube WHERE id=?");
            $getContent->execute(array($contentID));
            $result = $getContent->fetch(PDO::FETCH_ASSOC);

        ?>

            <div class="col-lg-12 ">
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Şube Düzenle</h3>
                        <div class="block-options">
                            <div class="block-options-item">
                            <a href="subeler"><button class="btn btn-sm btn-hero btn-outline-secondary">GERİ DÖN</button></a>
                            </div>
                        </div>
                    </div>
                    <div class="block-content">
                        <form action="../operations/controllers/subeController" method="post" enctype="multipart/form-data">
                            <!-- kullanıcı statu belirleme alanı -->
                            <div class="form-group row">
                                <div class="col-12">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="aktif" value="1" <?php if($result['aktif']==1){echo "checked";} ?>>
                                        <span class="css-control-indicator"></span> Şube Aktif
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >Şube Adı</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control"  name="adi" placeholder="Lütfen Doldurun" value="<?= $result['adi'] ?>" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >Adresi</label>
                                <div class="col-lg-10">
                                <textarea class="form-control" name="adres" rows="6" placeholder="Lütfen doldurun.."><?= $result['adres'] ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >Telefon</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control"  name="telefon" placeholder="Lütfen Doldurun" value="<?= $result['telefon'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >Fax</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control"  name="fax" placeholder="Lütfen Doldurun"  value="<?= $result['fax'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >E-mail</label>
                                <div class="col-lg-10">
                                    <input type="email" class="form-control"  name="email" placeholder="Lütfen Doldurun"  value="<?= $result['email'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >Konum</label>
                                <div class="col-lg-10">
                                <textarea class="form-control" name="konum" rows="6" placeholder="Lütfen Doldurun.."><?= $result['konum'] ?></textarea>
                                </div>
                            </div>
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >Görsel</label>
                                <div class="col-lg-5">
                                <?php 
                                    if ( $result['gorsel']=="noimage.jpg" ) { ?>
                                    
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider"><br>

                                    <?php 
                                    }else {?>

                                    <img src="../../uploads/<?= $result['gorsel'] ?>" class="w-100 upload-slider"><br>

                                    <?php }
                                    ?>
                                    
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="resim" size="42" accept="image/*" data-toggle="custom-file-input" oninput="imgSlider()">
                                        <input type="hidden" name="old-image" value="<?= $result['gorsel']?>">
                                        <input type="hidden" name="id" value="<?= $result['id']?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-10 text-right offset-lg-3">
                                    <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                            <div class="block-options">
                                <div class="block-options-item">
                                    <button type="submit" name="edit" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                    <a href="subeler"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
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


