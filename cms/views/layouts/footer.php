<script src="assets/js/core/jquery.min.js"></script>
<script src="assets/js/plugins/sortable/Sortable.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="assets/js/codebase.core.min.js"></script>
<script src="assets/js/codebase.app.min.js"></script>
<script src="assets/js/plugins/chartjs/Chart.bundle.min.js"></script>
<script src="assets/js/plugins/summernote/summernote-bs4.min.js"></script>
<script src="assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js"></script>
<!-- <script src="assets/js/pages/be_ui_activity.min.js"></script> -->
<script src="assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/js/plugins/datatables/dataTables.bootstrap4.min.js"></script>
<script src="assets/js/pages/be_tables_datatables.min.js"></script>
<script src="assets/js/plugins/jquery-vide/jquery.vide.min.js"></script>
<script src="assets/js/script.js"></script>
<script>
    jQuery(function() {
        Codebase.helpers(['summernote']);
    });
    $(".js-summernote").on("summernote.enter", function(we, e) {
        $(this).summernote("pasteHTML", "<br><br>");
        e.preventDefault();
    });

    function invalidFunction(e, message) {
        e.preventDefault();
        document.getElementById('hataMesaji').innerText = message;
        document.getElementById('hataMesaji').className = "badge badge-danger";
    }
</script>

<?php
if (!$controllerName == NULL) { ?>
    <script>
        var _sortable = Sortable.create(sortItems, {
            handle: '.handle-sort',
            animation: 150,
            dataIdAttr: 'data-id',
            ghostClass: "sortable-ghost",
            chosenClass: "sortable-chosen",
            dragClass: "sortable-drag",
            onUpdate: function(evt) {
                var pages = _sortable.toArray();
                //console.log(pages);
                $.post("../operations/controllers/<?=$controllerName?>Controller.php", {
                    sort: pages
                }, function(data) {
                    //console.log(pages)
                    //console.log(data)
                    Codebase.helpers('notify', {
                        align: 'right', // 'right', 'left', 'center'
                        from: 'top', // 'top', 'bottom'
                        type: 'success', // 'info', 'success', 'warning', 'danger'
                        icon: 'fa fa-check mr-5', // Icon class
                        message: 'İşlem başarılı!'
                    });
                });
            },

        });
    </script>
<?php }


// Statu messages
$statu = $_GET['statu'];
if ($statu == 'ok') { ?>

    <script>
        jQuery(function() {
            Codebase.helpers('notify', {
                align: 'right', // 'right', 'left', 'center'
                from: 'top', // 'top', 'bottom'
                type: 'success', // 'info', 'success', 'warning', 'danger'
                icon: 'fa fa-check mr-5', // Icon class
                message: 'İşlem başarılı!'
            });
        });
    </script>

<?php }

if ($statu == 'no') { ?>

    <script>
        jQuery(function() {
            Codebase.helpers('notify', {
                align: 'right', // 'right', 'left', 'center'
                from: 'top', // 'top', 'bottom'
                type: 'danger', // 'info', 'success', 'warning', 'danger'
                icon: 'fa fa-times mr-5', // Icon class
                message: 'İşlem başarısız!'
            });
        });
    </script>

<?php }

if ($statu == 'logNo') { ?>

    <script>
        jQuery(function() {
            Codebase.helpers('notify', {
                align: 'right', // 'right', 'left', 'center'
                from: 'top', // 'top', 'bottom'
                type: 'danger', // 'info', 'success', 'warning', 'danger'
                icon: 'fa fa-times mr-5', // Icon class
                message: 'Loglama hatası!'
            });
        });
    </script>

<?php }

if ($statu == 'passNo') { ?>

    <script>
        jQuery(function() {
            Codebase.helpers('notify', {
                align: 'right', // 'right', 'left', 'center'
                from: 'top', // 'top', 'bottom'
                type: 'danger', // 'info', 'success', 'warning', 'danger'
                icon: 'fa fa-times mr-5', // Icon class
                message: 'Parola doğrulama hatası!'
            });
        });
    </script>

<?php }

if ($statu == 'usrNo') { ?>

    <script>
        jQuery(function() {
            Codebase.helpers('notify', {
                align: 'right', // 'right', 'left', 'center'
                from: 'top', // 'top', 'bottom'
                type: 'danger', // 'info', 'success', 'warning', 'danger'
                icon: 'fa fa-times mr-5', // Icon class
                message: 'Kullanıcı adı bir başkası tarafından kullanılıyor!'
            });
        });
    </script>

<?php }

if ($statu == 'hasComp') { ?>

    <script>
        jQuery(function() {
            Codebase.helpers('notify', {
                align: 'right', // 'right', 'left', 'center'
                from: 'top', // 'top', 'bottom'
                type: 'warning', // 'info', 'success', 'warning', 'danger'
                icon: 'fa fa-times mr-5', // Icon class
                message: 'Bu kategoriye ait kayıtlı içerik bulunmaktadır! Lütfen önce içerikleri silin.'
            });
        });
    </script>

<?php }

if ($statu == 'hasSubCat') { ?>

    <script>
        jQuery(function() {
            Codebase.helpers('notify', {
                align: 'right', // 'right', 'left', 'center'
                from: 'top', // 'top', 'bottom'
                type: 'warning', // 'info', 'success', 'warning', 'danger'
                icon: 'fa fa-times mr-5', // Icon class
                message: 'Bu kategoriye bağlı alt kategori bulunmaktadır! Lütfen önce alt kategoriyi silin.'
            });
        });
    </script>

<?php }

if ($statu == 'imgNo') { ?>

    <script>
        jQuery(function() {
            Codebase.helpers('notify', {
                align: 'right', // 'right', 'left', 'center'
                from: 'top', // 'top', 'bottom'
                type: 'danger', // 'info', 'success', 'warning', 'danger'
                icon: 'fa fa-times mr-5', // Icon class
                message: 'Resim yüklenirken bir hata oluştu!'
            });
        });
    </script>

<?php }

?>

</body>

</html>


<?php

#Database bağlantısı kapat
$db = null;
ob_flush();

?>