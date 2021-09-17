<?php

ob_start();

include('../../../connection/connect.php');
include('../functions/functionImgSizer.php');
include('../functions/functionImgExtension.php');
include('../functions/clearCharacter.php');

#Log kayıtları için dataları değişkene aktar
$performName = "Haberler Kategori Yönetimi";
$userName = $_COOKIE['userName'];
$userID = $_COOKIE['userID'];


#içerik kaydetme
if (isset($_POST['add'])) {

    $adi = $_POST['adi_tr'];

    #Eski görsel yüklü ise oldImage değişkenine aktar
    $oldImage = $_POST['old-image'];

    // gorsel yükleme
    if ($_FILES['resim']['size']>0) {
        
        #Dosya yükleme yolu belirleme ve dosya adı temizleme
        $uploads_dir = '../../../uploads/';
        @$tmp_name = $_FILES['resim']["tmp_name"];
        @$resimadi = temizle($adi);
        @$dosya = $_FILES['resim']["name"];
        @$uzanti = extens($dosya);

        $dosya_boyutu = filesize($tmp_name);

        #Benzersiz oluşturma
        $benzersizsayi1 = rand(20000, 32000);
        $benzersizsayi2 = rand(20000, 32000);
        $benzersizsayi3 = rand(20000, 32000);
        $benzersizad = $resimadi . "-hizmet-kategori-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad2 = "t1-" . $resimadi . "-hizmet-kategori-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad3 = "t2-" . $resimadi . "-hizmet-kategori-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;

        #thumbnail
        $image = new SimpleImage();
        $image->load($_FILES['resim']['tmp_name']);
        $image->resizeToWidth(500);
        $image->save("$uploads_dir/$benzersizad2");
        $image = new SimpleImage();
        $image->load($_FILES['resim']['tmp_name']);
        $image->resizeToWidth(1000);
        $image->save("$uploads_dir/$benzersizad3");

        @move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad");
    } else {
        $benzersizad = $oldImage;
    }

    try
    {
        $savePage = $db->prepare("INSERT INTO tbl_hizmet_kategori SET

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

            aktif=:aktif,

            gorsel=:gorsel
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

            'aktif' => $_POST['aktif'],

            'gorsel' => $benzersizad
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
                'islem' => 'Yeni kategori ekleme',
                'adi' => $userName,
                'icerik' => $adi,
                'uye_id' => $userID
            ));

            #Log kaydetme işlemi başarılı ise geri dön
            if ($saveLog) {
                Header("Location: ../../views/haber-kategori?statu=ok");
            } else {
                Header("Location: ../../views/haber-kategori?statu=logNo");
            }
        } else {

            Header("Location: ../../views/haber-kategori?statu=no");
        }
    }catch (PDOException $e) {
        echo $e->getMessage();
    }
    
}

#kategori sayfa içerik düzenleme
if (isset($_POST['edit'])) {

    $adi = $_POST['adi_tr'];

    #Eski görsel yüklü ise oldImage değişkenine aktar
    $oldImage = $_POST['old-image'];

    // gorsel yükleme
    if ($_FILES['resim']['size']>0) {
        
        #Dosya yükleme yolu belirleme ve dosya adı temizleme
        $uploads_dir = '../../../uploads/';
        @$tmp_name = $_FILES['resim']["tmp_name"];
        @$resimadi = temizle($adi);
        @$dosya = $_FILES['resim']["name"];
        @$uzanti = extens($dosya);

        $dosya_boyutu = filesize($tmp_name);

        #Benzersiz oluşturma
        $benzersizsayi1 = rand(20000, 32000);
        $benzersizsayi2 = rand(20000, 32000);
        $benzersizsayi3 = rand(20000, 32000);
        $benzersizad = $resimadi . "-hizmet-kategori-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad2 = "t1-" . $resimadi . "-hizmet-kategori-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad3 = "t2-" . $resimadi . "-hizmet-kategori-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;

        #thumbnail
        $image = new SimpleImage();
        $image->load($_FILES['resim']['tmp_name']);
        $image->resizeToWidth(500);
        $image->save("$uploads_dir/$benzersizad2");
        $image = new SimpleImage();
        $image->load($_FILES['resim']['tmp_name']);
        $image->resizeToWidth(1000);
        $image->save("$uploads_dir/$benzersizad3");

        @move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad");
    } else {
        $benzersizad = $oldImage;
    }

    try
    {
        #Database kaydı
        $save = $db->prepare("UPDATE tbl_hizmet_kategori SET

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

            aktif=:aktif,

            gorsel=:gorsel
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

            'gorsel' => $benzersizad,
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
                'islem' => 'Kategori güncelleme',
                'adi' => $userName,
                'icerik' => $adi,
                'uye_id' => $userID
            ));

            #Log kaydetme işlemi başarılı ise geri dön
            if ($saveLog) {
                Header("Location: ../../views/haber-kategori?statu=ok");
            } else {
                Header("Location: ../../views/haber-kategori?statu=logNo");
            }
        } else {

            Header("Location: ../../views/haber-kategori?statu=no");
        }
    }catch (PDOException $e) {
        echo $e->getMessage();
    }
    
}

//silme işlemi
if ($_GET["perform"] == "delete") {

    $contentID = $_GET["id"];
    $adi = $_GET["adi"];

    $checkService = $db->query("SELECT COUNT(*) FROM tbl_hizmetler WHERE kategori_id=$contentID");
    $countService = $checkService->fetchColumn();

    if ($countService>0) {
        return Header("Location: ../../views/hizmet-kategori?statu=hasService");
    }
    
    $checkCat = $db->query("SELECT COUNT(*) FROM tbl_hizmet_alt_kategori WHERE kategori_id=$contentID");
    $countCat = $checkCat->fetchColumn();

    if ($countCat>0) {
        return Header("Location: ../../views/haber-kategori?statu=hasSubCat");
    }

    try
    {
    $delete = $db->exec("DELETE from tbl_hizmet_kategori where id = $contentID");

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
            'islem' => 'Kategori silme',
            'adi' => $userName,
            'icerik' => $adi,
            'uye_id' => $userID
        ));

        #Log kaydetme işlemi başarılı ise geri dön
        if ($saveLog) {
            Header("Location: ../../views/haber-kategori?statu=ok");
        } else {
            Header("Location: ../../views/haber-kategori?statu=logNo");
        }

    } else {
        header("Location: ../../views/haber-kategori?statu=no");
    }}catch (PDOException $e) {
        echo $e->getMessage();
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
