<?php

ob_start();

include('../../../connection/connect.php');
include('../functions/functionImgSizer.php');
include('../functions/functionImgExtension.php');
include('../functions/clearCharacter.php');
include('../functions/getInput.php');

#Log kayıtları için dataları değişkene aktar
$performName = "Döküman Yönetimi";
$userName = $_COOKIE['userName'];
$userID = $_COOKIE['userID'];


#ürünler içerik kaydetme
if (isset($_POST['add'])) {

    $adi = $_POST['adi_tr'];

    if ($_FILES['dokuman']['size']>0) {
        #Dosya yükleme yolu belirleme ve dosya adı temizleme
        $uploads_dir = '../../../uploads/';
        @$tmp_name = $_FILES['dokuman']["tmp_name"];
        @$adi = temizle($adi);
        @$dosya = $_FILES['dokuman']["name"];
        @$uzanti = extens($dosya);
        $dosya_boyutu = filesize($tmp_name);
        #Benzersiz oluşturma
        $dokumanbenzersizsayi1 = rand(20000, 32000);
        $dokumanbenzersizsayi2 = rand(20000, 32000);
        $dokumanbenzersizsayi3 = rand(20000, 32000);
        $dokumanbenzersizad = $adi . "-dokuman-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;

        @move_uploaded_file($tmp_name, "$uploads_dir/$dokumanbenzersizad");
    }else {
        $dokumanbenzersizad=NULL;
    }

    try
    {
        ##Database kaydı
        $savePage = $db->prepare("INSERT INTO tbl_slider SET

            baslik_1_tr=:baslik_1_tr,
            aktif_tr=:aktif_tr,
            
            baslik_1_en=:baslik_1_en,
            aktif_en=:aktif_en,

            baslik_1_fr=:baslik_1_fr,
            aktif_fr=:aktif_fr,

            baslik_1_es=:baslik_1_es,
            aktif_es=:aktif_es,

            baslik_1_ar=:baslik_1_ar,
            aktif_ar=:aktif_ar,
            dokuman=:dokuman,
                           
            aktif=:aktif
            ");

        $savePage->execute(array(

            'baslik_1_tr' => $_POST['baslik_1_tr'],
            'aktif_tr' => $_POST['aktif_tr'],

            'baslik_1_en' => $_POST['baslik_1_en'],
            'aktif_en' => $_POST['aktif_en'],

            'baslik_1_fr' => $_POST['baslik_1_fr'],
            'aktif_fr' => $_POST['aktif_fr'],

            'baslik_1_es' => $_POST['baslik_1_es'],
            'aktif_es' => $_POST['aktif_es'],

            'baslik_1_ar' => $_POST['baslik_1_ar'],
            'aktif_ar' => $_POST['aktif_ar'],

            'dokuman' => $dokumanbenzersizad,

            'aktif' => $_POST['aktif']
        ));

        #Kayıt edilen verinin ID sini çek
        $contentID = $db->lastInsertId();

        #Kayıt işlemi başarılı ise işlemi logla
        if ($savePage) {

            #Log kaydını database e kaydet
            $saveLog = $db->prepare("INSERT INTO tbl_log SET
                islem_id=:islem_id,
                sayfa=:sayfa,
                islem=:islem,
                adi=:adi,
                icerik=:icerik,
                uye_id=:uye_id
            ");

            $saveLog->execute(array(
                'islem_id' => $contentID,
                'sayfa' => $performName,
                'islem' => 'Yeni içerik ekleme',
                'adi' => $userName,
                'icerik' => ucfirst($adi),
                'uye_id' => $userID
            ));

            #Log kaydetme işlemi başarılı ise geri dön
            if($saveLog){
                Header("Location: ../../views/dokuman?statu=ok");
            }else{
                Header("Location: ../../views/dokuman?statu=logNo");
            }
        }

    }
    catch(PDOException $e)
    {
        echo $e->getMessage();

    }

}


#Kurumsal sayfa içerik düzenleme
if (isset($_POST['edit'])) {

    $adi = $_POST['adi_tr'];

    $oldDocument = $_POST['old-document'];

    if ($_FILES['dokuman']['size']>0) {
        #Dosya yükleme yolu belirleme ve dosya adı temizleme
        $uploads_dir = '../../../uploads/';
        @$tmp_name = $_FILES['dokuman']["tmp_name"];
        @$adi = temizle($adi);
        @$dosya = $_FILES['dokuman']["name"];
        @$uzanti = extens($dosya);
        $dosya_boyutu = filesize($tmp_name);
        #Benzersiz oluşturma
        $dokumanbenzersizsayi1 = rand(20000, 32000);
        $dokumanbenzersizsayi2 = rand(20000, 32000);
        $dokumanbenzersizsayi3 = rand(20000, 32000);
        $dokumanbenzersizad = $adi . "-dokuman-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;

        @move_uploaded_file($tmp_name, "$uploads_dir/$dokumanbenzersizad");
    }else {
        $dokumanbenzersizad=$oldDocument;
    }

    try
    {
        ##Database kaydı
        $savePage = $db->prepare("UPDATE tbl_slider SET

            baslik_1_tr=:baslik_1_tr,
            aktif_tr=:aktif_tr,
            
            baslik_1_en=:baslik_1_en,
            aktif_en=:aktif_en,

            baslik_1_fr=:baslik_1_fr,
            aktif_fr=:aktif_fr,

            baslik_1_es=:baslik_1_es,
            aktif_es=:aktif_es,

            baslik_1_ar=:baslik_1_ar,
            aktif_ar=:aktif_ar,
            
            dokuman=:dokuman,

            aktif=:aktif
            WHERE id=:id
            ");

        $savePage->execute(array(

            'baslik_1_tr' => $_POST['baslik_1_tr'],
            'aktif_tr' => $_POST['aktif_tr'],

            'baslik_1_en' => $_POST['baslik_1_en'],
            'aktif_en' => $_POST['aktif_en'],

            'baslik_1_fr' => $_POST['baslik_1_fr'],
            'aktif_fr' => $_POST['aktif_fr'],

            'baslik_1_es' => $_POST['baslik_1_es'],
            'aktif_es' => $_POST['aktif_es'],

            'baslik_1_ar' => $_POST['baslik_1_ar'],
            'aktif_ar' => $_POST['aktif_ar'],
            'dokuman' => $_POST['dokuman'],

            'aktif' => $_POST['aktif'],
            'id' => $_POST['id']
        ));

        #Kayıt edilen verinin ID sini çek
        $contentID = $_POST['id'];

        #Kayıt işlemi başarılı ise işlemi logla
        if ($savePage) {

            #Log kaydını database e kaydet
            $saveLog = $db->prepare("INSERT INTO tbl_log SET
                islem_id=:islem_id,
                sayfa=:sayfa,
                islem=:islem,
                adi=:adi,
                icerik=:icerik,
                uye_id=:uye_id
            ");

            $saveLog->execute(array(
                'islem_id' => $contentID,
                'sayfa' => $performName,
                'islem' => 'İçerik güncelleme',
                'adi' => $userName,
                'icerik' => $adi,
                'uye_id' => $userID
            ));

            #Log kaydetme işlemi başarılı ise geri dön
            if($saveLog){
                Header("Location: ../../views/dokuman?statu=ok");
            }else{
                Header("Location: ../../views/dokuman?statu=logNo");
            }
        }

    }
    catch(PDOException $e)
    {
        echo $e->getMessage();

    }
}

//silme işlemi
if ($_GET["perform"] == "delete") {

    $contentID = $_GET["id"];
    $adi = $_GET["adi"];

    $delete = $db->exec("DELETE from tbl_slider where id = $contentID");

    if ($delete) {

        #Log kaydını database e kaydet
        $saveLog = $db->prepare("INSERT INTO tbl_log SET
            islem_id=:islem_id,
            sayfa=:sayfa,
            islem=:islem,
            adi=:adi,
            icerik=:icerik,
            uye_id=:uye_id
        ");

        $saveLog->execute(array(
            'islem_id' => $contentID,
            'sayfa' => $performName,
            'islem' => 'İçerik silme',
            'adi' => $userName,
            'icerik' => $adi,
            'uye_id' => $userID
        ));

        #Log kaydetme işlemi başarılı ise geri dön
        if ($saveLog) {
            Header("Location: ../../views/dokuman?statu=ok");
        } else {
            Header("Location: ../../views/dokuman?statu=logNo");
        }

        if ($saveLog) {
            header("Location: ../../views/dokuman?statu=ok");
        } else {
            header("Location: ../../views/dokuman?statu=logNo");
        }
    } else {
        header("Location: ../../views/dokuman?statu=no");
    }
}

if (isset($_POST['sort'])) {

    $items = $_POST['sort'];

    foreach ($items as $sira => $id) {

        #Database kaydı
        $save = $db->prepare("UPDATE tbl_slider SET sira=:sira WHERE id=$id");
        $save->execute(array(
            'sira' => $sira
        ));
    }

    if ($save) {

        echo "Sıralama işlemi başarılı";
    } else {
        echo "no";
    }
}


ob_flush();

$db = null;
