<?php

$authPageName = "setting";
$activeClass ="bulten";
$pageTitle = "Maharethane - E-posta Bülten Yönetimi";
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
                    <h1 class="font-w700 text-white mb-10">E-posta Bülten Yönetimi</h1>
                    <h2 class="h4 font-w400 text-white-op">Sistemde bulunan e-posta bülten üyelerini bu sayfadan yönetebilirsiniz.</h2>
                </div>
            </div>
        </div>
        <?php
        #Aksiyon olmadan sayfa açılımı
        if ($perform == "" or $perform == NULL) { ?>
            <!-- Kayıtlı içerikleri görüntüleme -->
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">BÜLTEN ÜYELERİ</h3>
                </div>
                <div class="block-content block-content-full">
                    <!-- DataTables functionality is initialized with .js-dataTable-full class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                    <table class="table table-bordered table-striped table-vcenter js-dataTable-full background-white ">
                        <thead>
                            <tr>
                                <th>E-mail</th>
                                <th>Kayıt Tarihi</th>
                                <th class="d-none d-sm-table-cell" style="width: 5%">Durum</th>
                                <th class="text-center" style="width: 7%;">Düzenle</th>
                                <th class="text-center" style="width: 7%;">Sil</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            #Sayfa bilgilerini database den çek
                            $pageData = $db->prepare("SELECT * FROM tbl_email ORDER BY tarih ASC");
                            $pageData->execute();

                            #Sorguya uygun kayıtları döngüye al
                            while ($getData = $pageData->fetch(PDO::FETCH_ASSOC)) { ?>

                                <tr>
                                    <td class="font-w600"><?= $getData['email'] ?> </td>
                                    <td class="font-w600"><?= $getData["tarih"] ?></td>
                                    <td class="font-w600 d-none d-sm-table-cell text-center"><span class="badge  <?php if($getData['durum']==1){echo "badge-info";}elseif($getData['durum']==0){echo "badge-danger";} ?>"><?php if($getData['durum']==1){echo "Aktif";}elseif($getData['durum']==0){echo "Pasif";} ?></span></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="?perform=edit&id=<?= $getData["id"] ?>"><button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Edit">
                                                    <i class="fa fa-pencil"></i>
                                                </button></a>
                                            
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="../operations/controllers/bultenController?perform=delete&id=<?= $getData["id"]; ?>" onclick="return confirm('<?= $getData['email']; ?> Adlı Kaydı Silmek İstediğinize Eminmisiniz? ')">
                                            <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Delete">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </a>
                                    </td>
                                </tr>

                            <?php }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php }

        #Content düzenleme alanı ($_GET['perform']=="edit" ise aşağıdaki kod bloğu çalışacak)
        if ($perform == "edit") {

            $getContent = $db->prepare("SELECT * FROM tbl_email WHERE id=?");
            $getContent->execute(array($contentID));
            $result = $getContent->fetch(PDO::FETCH_ASSOC);

        ?>

        <div class="block block-fx-shadow">
            <div class="block">
                <div class="block-content tab-content">
                    <!-- Türkçe content düzenleme alanı -->
                    <div class="tab-pane active" id="turkce" role="tabpanel">
                        <form action="../operations/controllers/bultenController" method="post" >
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">E-mail Adresi</label>
                                <div class="col-lg-10">
                                    <input type="email" class="form-control" name="email"  value="<?= $result['email']; ?>" oninvalid="invalidFunction(event, 'Lütfen içerik alanlarını doldurunuz.')" required="">
                                    <input type="hidden" name="id" value="<?= $result['id'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Kayıt olma tarihi</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="tarih" value="<?= $result['tarih']; ?>" readonly>
                                </div>
                            </div>
                    </div>
                    
                    <!-- durum belirtme alanı(default aktif) -->
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label" for="example-hf-email">Durum</label>
                        <div class="col-lg-2" style="display: flex;">
                            <label class="css-control css-control-warning css-switch">
                                <input type="checkbox" class="css-control-input" name="durum" value="1" <?php if($result['durum']==1){echo "checked";} ?>>
                                <span class="css-control-indicator"></span> 
                            </label>
                        </div>
                    </div>
                    <?php if ($turkish == "on") { ?> <div id="hataMesaji" style="margin-bottom: 10px; font-size: 14px;"> </div> <?php } ?>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                    <div class="block-options">
                        <div class="block-options-item">
                        <button type="submit" name="update" class="btn btn-sm btn-alt-primary"><i class="fa fa-check"></i> Kaydet</button>
                        <a href="ana-sayfa"><button type="button" class="btn btn-sm btn-alt-danger"><i class="fa fa-close"></i> İptal</button></a>
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


