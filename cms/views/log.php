<?php

$authPageName = "content";
$activeClass = "log";
$pageTitle = "Maharethane - Log Kayıtları";
include('layouts/header.php');
include('../operations/middleware/AuthorizationMiddleware.php');
$perform = $_GET['perform'];
$contentID = $_GET['id'];

if($_COOKIE['authorization']!=="admin"){
    return header('Location:errors/auth');
}

?>

<main id="main-container">
    <div class="content">
        <div class="block block-transparent bg-video" data-vide-bg="assets/media/videos/city_night" data-vide-options="posterType: jpg" style="position: relative;"><div style="position: absolute; z-index: -1; inset: 0px; overflow: hidden; background-size: cover; background-color: transparent; background-repeat: no-repeat; background-position: 50% 50%; background-image: none;"><video autoplay="" loop="" muted="" style="margin: auto; position: absolute; z-index: -1; top: 50%; left: 50%; transform: translate(-50%, -50%); visibility: visible; opacity: 1; width: 1154px; height: auto;"><source src="assets/media/videos/city_night.mp4" type="video/mp4"><source src="assets/media/videos/city_night.webm" type="video/webm"><source src="assets/media/videos/city_night.ogv" type="video/ogg"></video></div>
            <div class="block-content bg-primary-dark-op">
                <div class="py-20 text-center">
                    <h1 class="font-w700 text-white mb-10">Güncel Log Kayıtları</h1>
                </div>
            </div>
        </div>
        
        <?php
        if ($_GET['durum'] == "ok") { ?>
            <div class="alert alert-success alert-dismissable" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h3 class="alert-heading font-size-h4 font-w400" style="margin: 0px;">İşlem Başarılı</h3>
            </div>
        <?php } elseif ($_GET['durum'] == "no") { ?>

            <div class="alert alert-danger alert-dismissable" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h3 class="alert-heading font-size-h4 font-w400" style="margin: 0px;">İşlem Başarısız</h3>
            </div>

        <?php } ?>

        <div class="block">
            <div class="block-content block-content-full">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full" data-order='[[ 0, "desc" ]]' >
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tarih</th>
                            <th>Sayfa</th>
                            <th>İşlem</th>
                            <th>İçerik / ID</th>
                            <th>İşlemi Yapan / ID</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $getLog = $db->prepare("SELECT * from tbl_log ORDER BY tarih DESC");
                        $getLog->execute();
                        while ($result = $getLog->fetch(PDO::FETCH_ASSOC)) {
                        ?>

                            <tr>
                                <td><?= $result["id"] ?></td>
                                <td><?= $result["tarih"] ?></td>
                                <td><?= $result["sayfa"] ?></td>
                                <td><?= $result['islem'] ?> </td>
                                <td><?= $result["icerik"] ?> / <?= $result['islem_id'] ?></td>
                                <td><?= $result["adi"] ?> / <?= $result["uye_id"] ?></td>
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
</main>

<!-- <script type="text/javascript">
    $(document).ready(function() {
        $('#kayitlar').DataTable({
            'orderFixed': [
                [3, "desc"]
            ]
        });
    });
</script> -->


<?php include("layouts/footer.php") ?>