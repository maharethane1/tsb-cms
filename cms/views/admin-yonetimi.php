<?php

$activeClass ="admin";
$pageTitle = "Maharethane - Admin Yönetimi";
include('layouts/header.php');
$perform = $_GET['perform'];
$contentID = $_GET['id'];

if($_COOKIE['authorization']!=="admin"){
    return header('Location:errors/auth');
}

?>

<main id="main-container">
    <!-- Page Content -->
    <div class="content">
        <div class="block block-transparent bg-video" data-vide-bg="assets/media/videos/city_night" data-vide-options="posterType: jpg" style="position: relative;"><div style="position: absolute; z-index: -1; inset: 0px; overflow: hidden; background-size: cover; background-color: transparent; background-repeat: no-repeat; background-position: 50% 50%; background-image: none;"><video autoplay="" loop="" muted="" style="margin: auto; position: absolute; z-index: -1; top: 50%; left: 50%; transform: translate(-50%, -50%); visibility: visible; opacity: 1; width: 1154px; height: auto;"><source src="assets/media/videos/city_night.mp4" type="video/mp4"><source src="assets/media/videos/city_night.webm" type="video/webm"><source src="assets/media/videos/city_night.ogv" type="video/ogg"></video></div>
            <div class="block-content bg-primary-dark-op">
                <div class="py-20 text-center">
                    <h1 class="font-w700 text-white mb-10">Admin Yönetimi</h1>
                    <h2 class="h4 font-w400 text-white-op">Sistemde bulunan ya da bulunacak kullanıcıları bu sayfadan yönetebilirsiniz.</h2>
                </div>
            </div>
        </div>
        <?php
        #Aksiyon olmadan sayfa açılımı
        if ($perform == "" or $perform == NULL) { ?>
            <!-- Kayıtlı içerikleri görüntüleme -->
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">KULLANICILAR</h3>
                    <div class="block-options">
                        <div class="block-options-item">
                            <a href="?perform=add"> <button class="btn btn-sm btn-hero btn-outline-secondary"> YENİ EKLE</button></a>
                        </div>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <!-- DataTables functionality is initialized with .js-dataTable-full class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                    <table id="sort" class="table table-bordered table-striped table-vcenter js-dataTable-full background-white ">
                        <thead>
                            <tr>
                                <th style="width: 5%">ID</th>
                                <th>Ad Soyad</th>
                                <th class="d-none d-sm-table-cell">Kullanıcı Adı</th>
                                <th class="d-none d-sm-table-cell">E-mail</th>
                                <th class="d-none d-sm-table-cell">Rol</th>
                                <th class="d-none d-sm-table-cell" style="width: 5%">Durum</th>
                                <th class="text-center" style="width: 7%;">İşlem</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            #Sayfa bilgilerini database den çek
                            $pageData = $db->prepare("SELECT * FROM tbl_admin ORDER BY id ASC");
                            $pageData->execute();

                            #Sorguya uygun kayıtları döngüye al
                            while ($getData = $pageData->fetch(PDO::FETCH_ASSOC)) { ?>

                                <tr>
                                    <td class="font-w600"><?= $getData['id'] ?> </td>
                                    <td class="font-w600"><?= $getData['adi'] ?> </td>
                                    <td class="font-w600 d-none d-sm-table-cell"><?= $getData['kullanici'] ?> </td>
                                    <td class="font-w600 d-none d-sm-table-cell"><?= $getData["email"] ?></td>
                                    <td class="font-w600 d-none d-sm-table-cell text-center"><span class="badge badge-pill <?php if($getData['rol']=="admin"){echo "badge-primary";}if($getData['rol']=="yonetici"){echo "badge-info";} if($getData['rol']=="editor"){echo "badge-success";}?>"><?php if($getData['rol']=="admin"){echo "Admin";}if($getData['rol']=="yonetici"){echo "Yönetici";} if($getData['rol']=="editor"){echo "Editor";}?></span></td>
                                    <td class="font-w600 d-none d-sm-table-cell text-center"><span class="badge  <?php if($getData['durum']==1){echo "badge-info";}else{echo "badge-danger";} ?>"><?php if($getData['durum']==1){echo "Aktif";}else{echo "Pasif";} ?></span></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="?perform=edit&id=<?= $getData["id"] ?>"><button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="bottom" title="Kullanıcıyı düzenle">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                            </a>
                                            <a href="../operations/controllers/adminController?perform=delete&id=<?= $getData["id"]; ?>" onclick="return confirm('<?= $getData['adi']; ?> adlı kullanıcı sistemdem kalıcı olarak silinecek. İşlemi onaylıyor musunuz? ')">
                                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="bottom" title="Kullanıcıyı sil">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </a>
                                            
                                        </div>
                                    </td>
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
                        <h3 class="block-title">Kullanıcı Ekle</h3>
                        <div class="block-options">
                            <div class="block-options-item">
                                <a href="admin-yonetimi"><button class="btn btn-sm btn-hero btn-outline-secondary">GERİ DÖN</button></a>
                            </div>
                        </div>
                    </div>
                    <div class="block-content">
                        <form action="../operations/controllers/adminController" method="post" enctype="multipart/form-data" data-parsley-validate>
                            <!-- kullanıcı statu belirleme alanı -->
                            <div class="form-group row">
                                <div class="col-12">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="durum" value="1" checked>
                                        <span class="css-control-indicator"></span> Kullanıcı durumu
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >Ünvan</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control"  name="unvan" placeholder="Lütfen Doldurun" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >Ad Soyad</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control"  name="adi" placeholder="Lütfen Doldurun"  required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >Kullanıcı Adı</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control"  name="kullanici" placeholder="Lütfen Doldurun"  required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >E-mail</label>
                                <div class="col-lg-10">
                                    <input type="email" class="form-control"  name="email" placeholder="Lütfen Doldurun"  required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label" >Kullanıcı Rolü</label>
                                <div class="col-lg-4">
                                    <select class="form-control" name="rol"  required="" >
                                        <option value="">Lütfen seçin</option>
                                        <option value="admin">Admin</option>
                                        <option value="yonetici">Yönetici</option>
                                        <option value="editor">Editor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >Parola</label>
                                <div class="col-lg-4">
                                    <input type="password" class="form-control"  name="parola" placeholder="Lütfen Doldurun" minlength="6">
                                    <div class="form-text text-muted"><small>Minumum 6 karakter</small></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >Parolayı Doğrula</label>
                                <div class="col-lg-4">
                                    <input type="password" class="form-control"  name="parola2" placeholder="Lütfen Doldurun" minlength="6">
                                </div>
                            </div>
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >Görsel</label>
                                <div class="col-lg-4">
                                    <img src="../../uploads/noimage.jpg" class="w-100 upload-slider">
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" name="gorsel" size="42" accept="image/*" data-toggle="custom-file-input" oninput="imgSlider()">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >Yetkiler</label>
                                <div class="col-lg-4">
                                    <div class="row no-gutters items-push">
                                        <div class="col-12">
                                            <label class="css-control css-control-warning css-switch">
                                                <input type="checkbox" name="y_sayfa" class="css-control-input" value="1">
                                                <span class="css-control-indicator"></span> Sayfa Yönetimi
                                            </label>
                                        </div>
                                        <div class="col-12">
                                            <label class="css-control css-control-warning css-switch">
                                                <input type="checkbox" name="y_icerik" class="css-control-input" value="1">
                                                <span class="css-control-indicator"></span> İçerik Yönetimi
                                            </label>
                                        </div>
                                        <div class="col-12">
                                            <label class="css-control css-control-warning css-switch">
                                                <input type="checkbox" name="y_site" class="css-control-input" value="1">
                                                <span class="css-control-indicator"></span> Site Yönetimi
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6 text-right ">
                                    <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                            <div class="block-options">
                                <div class="block-options-item">
                                    <button type="submit" name="add" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                    <a href="admin-yonetimi?statu=ok"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php }

        #Content düzenleme alanı ($_GET['perform']=="edit" ise aşağıdaki kod bloğu çalışacak)
        if ($perform == "edit") {

            $getContent = $db->prepare("SELECT * FROM tbl_admin WHERE id=?");
            $getContent->execute(array($contentID));
            $result = $getContent->fetch(PDO::FETCH_ASSOC);

        ?>

            <div class="col-lg-12">
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Kullanıcı Düzenle</h3>
                        <div class="block-options">
                            <div class="block-options-item">
                                <a href="admin-yonetimi"><button class="btn btn-sm btn-hero btn-outline-secondary">GERİ DÖN</button></a>
                            </div>
                        </div>
                    </div>
                    <div class="block-content">
                        <form action="../operations/controllers/adminController" method="post" enctype="multipart/form-data">
                            <!-- kullanıcı statu belirleme alanı -->
                            <div class="form-group row">
                                <div class="col-12">
                                    <label class="css-control css-control-warning css-switch">
                                        <input type="checkbox" class="css-control-input" name="durum" value="1" <?php if($result['durum']==1) {echo "checked";} ?>>
                                        <span class="css-control-indicator"></span> Kullanıcı durumu
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >Ünvan</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control"  name="unvan" placeholder="Lütfen Doldurun" value="<?= $result['unvan'] ?>" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >Ad Soyad</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control"  name="adi" placeholder="Lütfen Doldurun" value="<?= $result['adi'] ?>" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >Kullanıcı Adı</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control"  name="kullanici" placeholder="Lütfen Doldurun" value="<?= $result['kullanici'] ?>" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >E-mail</label>
                                <div class="col-lg-10">
                                    <input type="email" class="form-control"  name="email" placeholder="Lütfen Doldurun" value="<?= $result['email'] ?>" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label" >Kullanıcı Rolü</label>
                                <div class="col-lg-4">
                                    <select class="form-control" name="rol"  required="" >
                                        <option value="">Lütfen seçin</option>
                                        <option value="admin" <?php if($result['rol']=="admin") {echo "selected";} ?>>Admin</option>
                                        <option value="yonetici" <?php if($result['rol']=="yonetici") {echo "selected";} ?>>Yönetici</option>
                                        <option value="editor" <?php if($result['rol']=="editor") {echo "selected";} ?>>Editor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >Parola</label>
                                <div class="col-lg-4">
                                    <input type="password" class="form-control"  name="parola" placeholder="Lütfen Doldurun" minlength="6">
                                    <div class="form-text text-muted"><small>Minumum 6 karakter</small></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >Parolayı Doğrula</label>
                                <div class="col-lg-4">
                                    <input type="password" class="form-control"  name="parola2" placeholder="Lütfen Doldurun" minlength="6">
                                </div>
                            </div>
                            <!-- görsel alanı -->
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >Görsel</label>
                                <div class="col-lg-4 ">
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
                                        <input type="file" class="custom-file-input" name="gorsel" size="42" accept="image/*" data-toggle="custom-file-input" oninput="imgSlider()">
                                        <input type="hidden" name="old-image" value="<?= $result['gorsel'] ?>">
                                        <input type="hidden" name="id" value="<?= $result['id'] ?>">
                                        <label class="custom-file-label">Bir dosya seçin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class=" col-lg-2 col-form-label " >Yetkiler</label>
                                <div class="col-lg-4">
                                    <div class="row no-gutters items-push">
                                        <div class="col-12">
                                            <label class="css-control css-control-warning css-switch">
                                                <input type="checkbox" name="y_sayfa" class="css-control-input" value="1" <?php if($result['y_sayfa']==1) {echo "checked";} ?>>
                                                <span class="css-control-indicator"></span> Sayfa Yönetimi
                                            </label>
                                        </div>
                                        <div class="col-12">
                                            <label class="css-control css-control-warning css-switch">
                                                <input type="checkbox" name="y_icerik" class="css-control-input" value="1" <?php if($result['y_icerik']==1) {echo "checked";} ?>>
                                                <span class="css-control-indicator"></span> İçerik Yönetimi
                                            </label>
                                        </div>
                                        <div class="col-12">
                                            <label class="css-control css-control-warning css-switch">
                                                <input type="checkbox" name="y_site" class="css-control-input" value="1" <?php if($result['y_site']==1) {echo "checked";} ?>>
                                                <span class="css-control-indicator"></span> Site Yönetimi
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6 text-right ">
                                    <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                            <div class="block-options">
                                <div class="block-options-item">
                                    <button type="submit" name="edit" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                                    <a href="admin-yonetimi?statu=ok"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
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


