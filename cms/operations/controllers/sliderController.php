<?php

ob_start();

include('../../../connection/connect.php');
include('../functions/functionImgSizer.php');
include('../functions/functionImgExtension.php');
include('../functions/clearCharacter.php');
include('../functions/getInput.php');

#Log kayıtları için dataları değişkene aktar
$performName = "Slider Yönetimi";
$userName = $_COOKIE['userName'];
$userID = $_COOKIE['userID'];


#ürünler içerik kaydetme
if (isset($_POST['add'])) {

    $adi = $_POST['adi_tr'];

    $benzersizadtr = uploadImage("slider", "resim", "tr");
    $benzersizaden = uploadImage("slider", "resim", "en");
    $benzersizadfr = uploadImage("slider", "resim", "fr");
    $benzersizades = uploadImage("slider", "resim", "es");
    $benzersizadar = uploadImage("slider", "resim", "ar");

    try
    {
        ##Database kaydı
        $savePage = $db->prepare("INSERT INTO tbl_slider SET

            baslik_1_tr=:baslik_1_tr,
            baslik_2_tr=:baslik_2_tr,
            buton_tr=:buton_tr,
            link_tr=:link_tr,
            gorsel_tr=:gorsel_tr,
            aktif_tr=:aktif_tr,
            
            baslik_1_en=:baslik_1_en,
            baslik_2_en=:baslik_2_en,
            buton_en=:buton_en,
            link_en=:link_en,
            gorsel_en=:gorsel_en,
            aktif_en=:aktif_en,

            baslik_1_fr=:baslik_1_fr,
            baslik_2_fr=:baslik_2_fr,
            buton_fr=:buton_fr,
            link_fr=:link_fr,
            gorsel_fr=:gorsel_fr,
            aktif_fr=:aktif_fr,

            baslik_1_es=:baslik_1_es,
            baslik_2_es=:baslik_2_es,
            buton_es=:buton_es,
            link_es=:link_es,
            gorsel_es=:gorsel_es,
            aktif_es=:aktif_es,

            baslik_1_ar=:baslik_1_ar,
            baslik_2_ar=:baslik_2_ar,
            buton_ar=:buton_ar,
            link_ar=:link_ar,
            gorsel_ar=:gorsel_ar,
            aktif_ar=:aktif_ar,

            aktif=:aktif
            ");

        $savePage->execute(array(

            'baslik_1_tr' => $_POST['baslik_1_tr'],
            'baslik_2_tr' => $_POST['baslik_2_tr'],
            'buton_tr' => $_POST['buton_tr'],
            'link_tr' => $_POST['link_tr'],
            'gorsel_tr' => $benzersizadtr,
            'aktif_tr' => $_POST['aktif_tr'],

            'baslik_1_en' => $_POST['baslik_1_en'],
            'baslik_2_en' => $_POST['baslik_2_en'],
            'buton_en' => $_POST['buton_en'],
            'link_en' => $_POST['link_en'],
            'gorsel_en' => $benzersizaden,
            'aktif_en' => $_POST['aktif_en'],

            'baslik_1_fr' => $_POST['baslik_1_fr'],
            'baslik_2_fr' => $_POST['baslik_2_fr'],
            'buton_fr' => $_POST['buton_fr'],
            'link_fr' => $_POST['link_fr'],
            'gorsel_fr' => $benzersizadfr,
            'aktif_fr' => $_POST['aktif_fr'],

            'baslik_1_es' => $_POST['baslik_1_es'],
            'baslik_2_es' => $_POST['baslik_2_es'],
            'buton_es' => $_POST['buton_es'],
            'link_es' => $_POST['link_es'],
            'gorsel_es' => $benzersizades,
            'aktif_es' => $_POST['aktif_es'],

            'baslik_1_ar' => $_POST['baslik_1_ar'],
            'baslik_2_ar' => $_POST['baslik_2_ar'],
            'buton_ar' => $_POST['buton_ar'],
            'link_ar' => $_POST['link_ar'],
            'gorsel_ar' => $benzersizadar,
            'aktif_ar' => $_POST['aktif_ar'],

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
                Header("Location: ../../views/slider?statu=ok");
            }else{
                Header("Location: ../../views/slider?statu=logNo");
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

    $benzersizadtr = editImage("slider", "resim", "0");
    $benzersizaden = editImage("slider", "resim", "1");
    $benzersizadfr = editImage("slider", "resim", "2");
    $benzersizades = editImage("slider", "resim", "3");
    $benzersizadar = editImage("slider", "resim", "4");

    try
    {
        ##Database kaydı
        $savePage = $db->prepare("UPDATE tbl_slider SET

            baslik_1_tr=:baslik_1_tr,
            baslik_2_tr=:baslik_2_tr,
            buton_tr=:buton_tr,
            link_tr=:link_tr,
            gorsel_tr=:gorsel_tr,
            aktif_tr=:aktif_tr,
            
            baslik_1_en=:baslik_1_en,
            baslik_2_en=:baslik_2_en,
            buton_en=:buton_en,
            link_en=:link_en,
            gorsel_en=:gorsel_en,
            aktif_en=:aktif_en,

            baslik_1_fr=:baslik_1_fr,
            baslik_2_fr=:baslik_2_fr,
            buton_fr=:buton_fr,
            link_fr=:link_fr,
            gorsel_fr=:gorsel_fr,
            aktif_fr=:aktif_fr,

            baslik_1_es=:baslik_1_es,
            baslik_2_es=:baslik_2_es,
            buton_es=:buton_es,
            link_es=:link_es,
            gorsel_es=:gorsel_es,
            aktif_es=:aktif_es,

            baslik_1_ar=:baslik_1_ar,
            baslik_2_ar=:baslik_2_ar,
            buton_ar=:buton_ar,
            link_ar=:link_ar,
            gorsel_ar=:gorsel_ar,
            aktif_ar=:aktif_ar,

            aktif=:aktif
            WHERE id=:id
            ");

        $savePage->execute(array(

            'baslik_1_tr' => $_POST['baslik_1_tr'],
            'baslik_2_tr' => $_POST['baslik_2_tr'],
            'buton_tr' => $_POST['buton_tr'],
            'link_tr' => $_POST['link_tr'],
            'gorsel_tr' => $benzersizadtr,
            'aktif_tr' => $_POST['aktif_tr'],

            'baslik_1_en' => $_POST['baslik_1_en'],
            'baslik_2_en' => $_POST['baslik_2_en'],
            'buton_en' => $_POST['buton_en'],
            'link_en' => $_POST['link_en'],
            'gorsel_en' => $benzersizaden,
            'aktif_en' => $_POST['aktif_en'],

            'baslik_1_fr' => $_POST['baslik_1_fr'],
            'baslik_2_fr' => $_POST['baslik_2_fr'],
            'buton_fr' => $_POST['buton_fr'],
            'link_fr' => $_POST['link_fr'],
            'gorsel_fr' => $benzersizadfr,
            'aktif_fr' => $_POST['aktif_fr'],

            'baslik_1_es' => $_POST['baslik_1_es'],
            'baslik_2_es' => $_POST['baslik_2_es'],
            'buton_es' => $_POST['buton_es'],
            'link_es' => $_POST['link_es'],
            'gorsel_es' => $benzersizades,
            'aktif_es' => $_POST['aktif_es'],

            'baslik_1_ar' => $_POST['baslik_1_ar'],
            'baslik_2_ar' => $_POST['baslik_2_ar'],
            'buton_ar' => $_POST['buton_ar'],
            'link_ar' => $_POST['link_ar'],
            'gorsel_ar' => $benzersizadar,
            'aktif_ar' => $_POST['aktif_ar'],

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
                Header("Location: ../../views/slider?statu=ok");
            }else{
                Header("Location: ../../views/slider?statu=logNo");
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
            Header("Location: ../../views/slider?statu=ok");
        } else {
            Header("Location: ../../views/slider?statu=logNo");
        }

        if ($saveLog) {
            header("Location: ../../views/slider?statu=ok");
        } else {
            header("Location: ../../views/slider?statu=logNo");
        }
    } else {
        header("Location: ../../views/slider?statu=no");
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
