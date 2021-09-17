<?php

ob_start();

include('../../../connection/connect.php');
include('../functions/functionImgSizer.php');
include('../functions/functionImgExtension.php');
include('../functions/clearCharacter.php');

#Log kayıtları için dataları değişkene aktar
$performName = "İK Açık Pozisyon Yönetimi";
$userName = $_COOKIE['userName'];
$userID = $_COOKIE['userID'];


#içerik kaydetme
if (isset($_POST['add'])) {

    $adi = $_POST['adi_tr'];
    try
    {
        $savePage = $db->prepare("INSERT INTO tbl_pozisyon SET

            adi_tr=:adi_tr,
            aciklama_tr=:aciklama_tr,
            aktif_tr=:aktif_tr,

            adi_en=:adi_en,
            aciklama_en=:aciklama_en,
            aktif_en=:aktif_en,

            adi_es=:adi_es,
            aciklama_es=:aciklama_es,
            aktif_es=:aktif_es,

            adi_fr=:adi_fr,
            aciklama_fr=:aciklama_fr,
            aktif_fr=:aktif_fr,

            adi_ar=:adi_ar,
            aciklama_ar=:aciklama_ar,
            aktif_ar=:aktif_ar,

            aktif=:aktif
        ");

        $savePage->execute(array(

            'adi_tr' => $_POST['adi_tr'],
            'aciklama_tr' => $_POST['aciklama_tr'],
            'aktif_tr' => $_POST['aktif_tr'],

            'adi_en' => $_POST['adi_en'],
            'aciklama_en' => $_POST['aciklama_en'],
            'aktif_en' => $_POST['aktif_en'],

            'adi_es' => $_POST['adi_es'],
            'aciklama_es' => $_POST['aciklama_es'],
            'aktif_es' => $_POST['aktif_es'],

            'adi_fr' => $_POST['adi_fr'],
            'aciklama_fr' => $_POST['aciklama_fr'],
            'aktif_fr' => $_POST['aktif_fr'],

            'adi_ar' => $_POST['adi_ar'],
            'aciklama_ar' => $_POST['aciklama_ar'],
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
                'islem' => 'Açık pozisyon ekleme',
                'adi' => $userName,
                'icerik' => $adi,
                'uye_id' => $userID
            ));

            #Log kaydetme işlemi başarılı ise geri dön
            if ($saveLog) {
                Header("Location: ../../views/ik-acik-pozisyonlar?statu=ok");
            } else {
                Header("Location: ../../views/ik-acik-pozisyonlar?statu=logNo");
            }
        } else {

            Header("Location: ../../views/ik-acik-pozisyonlar?statu=no");
        }
    }catch (PDOException $e) {
        echo $e->getMessage();
    }
    
}

#içerik düzenleme
if (isset($_POST['edit'])) {

    $adi = $_POST['adi_tr'];

    try
    {
        #Database kaydı
        $save = $db->prepare("UPDATE tbl_pozisyon SET

            adi_tr=:adi_tr,
            aciklama_tr=:aciklama_tr,
            aktif_tr=:aktif_tr,
        
            adi_en=:adi_en,
            aciklama_en=:aciklama_en,
            aktif_en=:aktif_en,

            adi_es=:adi_es,
            aciklama_es=:aciklama_es,
            aktif_es=:aktif_es,

            adi_fr=:adi_fr,
            aciklama_fr=:aciklama_fr,
            aktif_fr=:aktif_fr,

            adi_ar=:adi_ar,
            aciklama_ar=:aciklama_ar,
            aktif_ar=:aktif_ar,

            aktif=:aktif

            WHERE id=:id
        ");

        $save->execute(array(

            'adi_tr' => $_POST['adi_tr'],
            'aciklama_tr' => $_POST['aciklama_tr'],
            'aktif_tr' => $_POST['aktif_tr'],

            'adi_en' => $_POST['adi_en'],
            'aciklama_en' => $_POST['aciklama_en'],
            'aktif_en' => $_POST['aktif_en'],

            'adi_es' => $_POST['adi_es'],
            'aciklama_es' => $_POST['aciklama_es'],
            'aktif_es' => $_POST['aktif_es'],

            'adi_fr' => $_POST['adi_fr'],
            'aciklama_fr' => $_POST['aciklama_fr'],
            'aktif_fr' => $_POST['aktif_fr'],

            'adi_ar' => $_POST['adi_ar'],
            'aciklama_ar' => $_POST['aciklama_ar'],
            'aktif_ar' => $_POST['aktif_ar'],

            'aktif' => $_POST['aktif'],

            'id' => $_POST['id']
        ));

        #Kayıt edilen verinin ID sini çek
        $contentID = $_POST['id'];

        #Kayıt işlemi başarılı ise işlemi logla
        if ($save) {

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
                'islem' => 'Açık pozisyon güncelleme',
                'adi' => $userName,
                'icerik' => $adi,
                'uye_id' => $userID
            ));

            #Log kaydetme işlemi başarılı ise geri dön
            if ($saveLog) {
                Header("Location: ../../views/ik-acik-pozisyonlar?statu=ok");
            } else {
                Header("Location: ../../views/hik-acik-pozisyonlar?statu=logNo");
            }
        } else {

            Header("Location: ../../views/ik-acik-pozisyonlar?statu=no");
        }
    }catch (PDOException $e) {
        echo $e->getMessage();
    }
    
}

//silme işlemi
if ($_GET["perform"] == "delete") {

    $contentID = $_GET["id"];
    $adi = $_GET["adi"];

    $checkCat = $db->query("SELECT COUNT(*) FROM tbl_basvuru WHERE pozisyon_id=$contentID");
    $checkCat = $checkCat->fetchColumn();

    if($checkCat>0){
        return  Header("Location: ../../views/ik-acik-pozisyonlar?statu=hasComp");
    }

    $delete = $db->exec("DELETE from tbl_pozisyon where id = $contentID");

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
            'islem' => 'Açık pozisyon silme',
            'adi' => $userName,
            'icerik' => $adi,
            'uye_id' => $userID
        ));

        #Log kaydetme işlemi başarılı ise geri dön
        if ($saveLog) {
            Header("Location: ../../views/ik-acik-pozisyonlar?statu=ok");
        } else {
            Header("Location: ../../views/ik-acik-pozisyonlar?statu=logNo");
        }

    } else {
        header("Location: ../../views/ik-acik-pozisyonlar?statu=no");
    }
}

if (isset($_POST['sort'])) {

    $items = $_POST['sort'];

    foreach ($items as $sira => $id) {

        #Database kaydı
        $save = $db->prepare("UPDATE tbl_hizmet_kategori SET sira=:sira WHERE id=$id");
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
