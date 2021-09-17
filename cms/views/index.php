<?php

$activeClass ="index";
$pageTitle = "Maharethane - Yönetim paneli";

include('layouts/header.php');


?>

<main id="main-container">

    <!-- Page Content -->
    <!-- jQuery Vide for video backgrounds, for more examples you can check out https://github.com/VodkaBears/Vide -->
    <div class="bg-video" data-vide-bg="assets/media/videos/city_night" data-vide-options="posterType: jpg">
        <div class="hero bg-black-op">
            <div class="hero-inner">
                <div class="content content-full text-center">
                    <h1 class="display-4 font-w700 text-white mb-10">Hoş geldiniz.</h1>
                    <h4 class="font-w400 text-white-op mb-20">Maharethane İçerik Yönetim Sistemi version 1.0 </h4>
                    <p class="text-white-op">Sorularınız ve talepleriniz için aşağıda bulunan buton üzerinden destek ekibimizle iletişime geçebilirsiniz.</p>
                    <a class="btn btn-hero btn-noborder btn-rounded btn-success" href="#">
                        <i class="si si-user mr-10"></i> İletişim
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Content -->

</main>

<?php

include('layouts/footer.php');

?>