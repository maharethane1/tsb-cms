<?php

ob_start();

include('../../../connection/connect.php');
include('../functions/functionImgSizer.php');
include('../functions/functionImgExtension.php');
include('../functions/clearCharacter.php');

#Log kayıtları için dataları değişkene aktar
$performName = "Portfolio Yönetimi";
$userName = $_COOKIE['userName'];
$userID = $_COOKIE['userID'];


#içerik kaydetme
if (isset($_POST['add'])) {

    $adi = $_POST['firma'];

    #uzantı jpg jpeg png yada gif ise aşağıdaki kod bloğunu çalıştır
    if ($_FILES['resim']['size']>0) {
        
        #Dosya yükleme yolu belirleme ve dosya adı temizleme
        $uploads_dir = '../../../uploads/';
        @$tmp_name = $_FILES['resim']["tmp_name"];
        @$resimadi = temizle($adi);
        @$dosya = $_FILES['resim']["name"];
        @$uzanti = extens($dosya);

        #Benzersiz oluşturma
        $benzersizsayi1 = rand(20000, 32000);
        $benzersizsayi2 = rand(20000, 32000);
        $benzersizsayi3 = rand(20000, 32000);
        $benzersizad = $resimadi . "-portfolio-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad2 = "t1-" . $resimadi . "-portfolio-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad3 = "t2-" . $resimadi . "-portfolio-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;

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
        $benzersizad = "noimage.jpg";
    }

    try
    {
        $savePage = $db->prepare("INSERT INTO tbl_portfolio SET

            firma=:firma,
            musteri=:musteri,
            kategori_id=:kategori_id,

            video_aktif=:video_aktif,
            video=:video,
            gorsel=:gorsel,
            vitrin=:vitrin,
            aktif=:aktif
        ");

        $savePage->execute(array(

            'firma' => $_POST['firma'],
            'musteri' => $_POST['musteri'],
            'kategori_id' => $_POST['kategori'],

            'video_aktif' => $_POST['video_aktif'],
            'video' => $_POST['video'],
            'gorsel' => $benzersizad,
            'vitrin' => $_POST['vitrin'],

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
                'islem' => 'Yeni portfolio ekleme',
                'adi' => $userName,
                'icerik' => $adi,
                'uye_id' => $userID
            ));

            #Log kaydetme işlemi başarılı ise geri dön
            if ($saveLog) {
                Header("Location: ../../views/portfolio?statu=ok");
            } else {
                Header("Location: ../../views/portfolio?statu=logNo");
            }
        } else {

            Header("Location: ../../views/portfolio?statu=no");
        }
    }catch (PDOException $e) {
        echo $e->getMessage();
    }
    
}

#içerik düzenleme
if (isset($_POST['edit'])) {

    $adi = $_POST['firma'];
    $oldImage = $_POST['old-image'];
    $id = $_POST['id'];

    #uzantı jpg jpeg png yada gif ise aşağıdaki kod bloğunu çalıştır
    if ($_FILES['resim']['size']>0) {
        
        #Dosya yükleme yolu belirleme ve dosya adı temizleme
        $uploads_dir = '../../../uploads/';
        @$tmp_name = $_FILES['resim']["tmp_name"];
        @$resimadi = temizle($adi);
        @$dosya = $_FILES['resim']["name"];
        @$uzanti = extens($dosya);

        #Benzersiz oluşturma
        $benzersizsayi1 = rand(20000, 32000);
        $benzersizsayi2 = rand(20000, 32000);
        $benzersizsayi3 = rand(20000, 32000);
        $benzersizad = $resimadi . "-portfolio-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad2 = "t1-" . $resimadi . "-portfolio-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad3 = "t2-" . $resimadi . "-portfolio-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;

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
        $savePage = $db->prepare("UPDATE tbl_portfolio SET

            firma=:firma,
            musteri=:musteri,
            kategori_id=:kategori_id,

            video_aktif=:video_aktif,
            video=:video,
            gorsel=:gorsel,
            vitrin=:vitrin,
            aktif=:aktif
            WHERE id=:id
        ");

        $savePage->execute(array(

            'firma' => $_POST['firma'],
            'musteri' => $_POST['musteri'],
            'kategori_id' => $_POST['kategori'],

            'video_aktif' => $_POST['video_aktif'],
            'video' => $_POST['video'],
            'gorsel' => $benzersizad,
            'vitrin' => $_POST['vitrin'],

            'aktif' => $_POST['aktif'],
            'id' => $_POST['id']
        ));


        #Kayıt edilen verinin ID sini çek
        $contentID = $id;

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
                'islem' => 'Portfolio güncelleme',
                'adi' => $userName,
                'icerik' => $adi,
                'uye_id' => $userID
            ));

            #Log kaydetme işlemi başarılı ise geri dön
            if ($saveLog) {
                Header("Location: ../../views/portfolio?statu=ok");
            } else {
                Header("Location: ../../views/portfolio?statu=logNo");
            }
        } else {

            Header("Location: ../../views/portfolio?statu=no");
        }
    }catch (PDOException $e) {
        echo $e->getMessage();
    }
    
}


//silme işlemi
if ($_GET["perform"] == "delete") {

    $contentID = $_GET["id"];
    $adi = $_GET["adi"];

    $checkComp = $db->query("SELECT COUNT(*) FROM tbl_portfolio_comp WHERE portfolio_id=$contentID");
    $checkComp = $checkComp->fetchColumn();

    if ($checkComp>0) {
        return Header("Location: ../../views/portfolio?statu=hasComp");
    }

    try
    {
    $delete = $db->exec("DELETE from tbl_portfolio where id = $contentID");

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
            'islem' => 'Portfolio silme',
            'adi' => $userName,
            'icerik' => $adi,
            'uye_id' => $userID
        ));

        #Log kaydetme işlemi başarılı ise geri dön
        if ($saveLog) {
            Header("Location: ../../views/portfolio?statu=ok");
        } else {
            Header("Location: ../../views/portfolio?statu=logNo");
        }

    } else {
        header("Location: ../../views/portfolio?statu=no");
    }}catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if (isset($_POST['sort'])) {

    $items = $_POST['sort'];

    foreach ($items as $sira => $id) {

        #Database kaydı
        $save = $db->prepare("UPDATE tbl_portfolio SET sira=:sira WHERE id=$id");
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
