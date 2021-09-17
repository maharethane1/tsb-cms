<?php

$authPageName = "content";
$activeClass ="ik-basvurular";
$pageTitle = "Maharethane - İK Açık Poziyonlar";
include('layouts/header.php');
include('../operations/middleware/AuthorizationMiddleware.php');
$perform = $_GET['perform'];
$contentID = $_GET['id'];
$controllerName="pozisyon";
?>

<main id="main-container">
    <!-- Page Content -->
    <div class="content">
        <div class="block block-transparent bg-video" data-vide-bg="assets/media/videos/city_night" data-vide-options="posterType: jpg" style="position: relative;"><div style="position: absolute; z-index: -1; inset: 0px; overflow: hidden; background-size: cover; background-color: transparent; background-repeat: no-repeat; background-position: 50% 50%; background-image: none;"><video autoplay="" loop="" muted="" style="margin: auto; position: absolute; z-index: -1; top: 50%; left: 50%; transform: translate(-50%, -50%); visibility: visible; opacity: 1; width: 1154px; height: auto;"><source src="assets/media/videos/city_night.mp4" type="video/mp4"><source src="assets/media/videos/city_night.webm" type="video/webm"><source src="assets/media/videos/city_night.ogv" type="video/ogg"></video></div>
            <div class="block-content bg-primary-dark-op">
                <div class="py-20 text-center">
                    <h1 class="font-w700 text-white mb-10">Başvurular</h1>
                    <h2 class="h4 font-w400 text-white-op">Tarafınıza yapılan iş başvurularını bu sayfadan yönetebilirsiniz.</h2>
                </div>
            </div>
        </div>
        <?php
        #Aksiyon olmadan sayfa açılımı
        if ($perform == "" or $perform == NULL) { ?>
            <!-- Kayıtlı içerikleri görüntüleme -->
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">BAŞVURULAR</h3>
                    <div class="block-options">
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <!-- DataTables functionality is initialized with .js-dataTable-full class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                    <table class="table table-bordered table-striped table-vcenter js-dataTable-full background-white">
                        <thead>
                            <tr>
                                <th>Ad Soyad</th>
                                <th class="d-none d-sm-table-cell text-center">Pozisyon</th>
                                <th class="text-center d-none d-lg-table-cell">Başvuru Tarihi</th>
                                <th class="text-center" style="width: 15%;">İşlem</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            #Sayfa bilgilerini database den çek
                            $pageData = $db->prepare("SELECT a.*, b.adi_tr as pozisyon_adi FROM tbl_basvuru as a LEFT JOIN tbl_pozisyon as b ON a.pozisyon_id=b.id ORDER BY tarih ASC");
                            
                            $pageData->execute();

                            #Sorguya uygun kayıtları döngüye al
                            while ($getData = $pageData->fetch(PDO::FETCH_ASSOC)) { ?>
    
                                <tr>
                                    <td class="font-w600 "><?= $getData['adi'] ?></td>
                                    <td class="font-w600"><?= $getData['pozisyon_adi'] ?> </td>
                                    <td class="font-w600 d-none d-lg-table-cell text-center"><?= $getData['tarih'] ?> </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="?perform=show&id=<?= $getData["id"] ?>"><button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Edit">
                                                    <i class="fa fa-address-card-o"></i>
                                                </button>
                                            </a>
                                            <a href="../operations/controllers/basvuruController?perform=delete&id=<?= $getData["id"]; ?>&adi=<?= $getData["adi_tr"]; ?>" onclick="return confirm('<?= $getData['adi_tr']; ?> Adlı Kaydı Silmek İstediğinize Eminmisiniz? ')">
                                                <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Delete" style="margin-left: 10px;">
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

        #Content düzenleme alanı ($_GET['perform']=="edit" ise aşağıdaki kod bloğu çalışacak)
        if ($perform == "show") {

            $getContent = $db->prepare("SELECT a.*, b.adi_tr as pozisyon_adi FROM tbl_basvuru as a LEFT JOIN tbl_pozisyon as b ON a.pozisyon_id=b.id WHERE a.id=$contentID");
            $getContent->execute();
            $result = $getContent->fetch(PDO::FETCH_ASSOC);

        ?>

        <div class="col-lg-8 offset-lg-2">
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Başvuru Görüntüleme</h3>
                        <div class="block-options">
                            <div class="block-options-item">
                                <?php 
                                if($result['dosya']!==NULL OR $result['dosya']!==""){?>
                                    <a href="ik-basvurular"><button type="button" class="btn btn-block-option font-size-xl" data-toggle="tooltip" data-placement="bottom" title="CV Görüntüle" ><i class="fa fa-file-pdf-o"></i> </button></a>
                                <?php }
                                ?>
                                <a href="ik-basvurular"><button type="button" class="btn btn-block-option font-size-xl" data-toggle="tooltip" data-placement="bottom" title="Geri Dön" ><i class="si si-action-undo"></i> </button></a>
                            </div>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="form-group row">
                            <label class="offset-lg-2 col-lg-3 col-form-label " >Başvurulan Pozisyon</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control disabled"  value="<?= $result['pozisyon_adi'] ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="offset-lg-2 col-lg-3 col-form-label " >Ad Soyad</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control disabled"  value="<?= $result['adi'] ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="offset-lg-2 col-lg-3 col-form-label " >Telefon</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control disabled"  value="<?= $result['telefon'] ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="offset-lg-2 col-lg-3 col-form-label " >E-mail</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control disabled"  value="<?= $result['email'] ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="offset-lg-2 col-lg-3 col-form-label " >Başvuru Tarihi</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control disabled"  value="<?= $result['tarih'] ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="offset-lg-2 col-lg-3 col-form-label " >Başvurulan Pozisyon</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control disabled"  value="<?= $result['pozisyon_adi'] ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="offset-lg-2 col-lg-3 col-form-label " >Bilgi</label>
                            <div class="col-lg-5">
                                <textarea class="form-control" rows="6" placeholder="İçerik açıklaması.." disabled> <?= $result['bilgi'] ?> </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                    </div>
                </div>
            </div>

        <?php } 
        
        ?>

    </div>
</main>

<?php

include('layouts/footer.php');

?>


