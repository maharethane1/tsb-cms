<?php 

ob_start();

include('../../../connection/connect.php');
include('../functions/functionImgSizer.php');
include('../functions/functionImgExtension.php');
include('../functions/clearCharacter.php');

#Log kayıtları için dataları değişkene aktar
$performName = "Admin Yönetimi";
$userName = $_COOKIE['userName'];
$userID = $_COOKIE['userID'];


#cozumler sayfa içerik kaydetme
if ( isset($_POST['add']) ) { 

    $adi = $_POST['adi'];

    #uzantı jpg jpeg png yada gif ise aşağıdaki kod bloğunu çalıştır
    if ($_FILES['gorsel']['size']>0) {
        
        #Dosya yükleme yolu belirleme ve dosya adı temizleme
        $uploads_dir = '../../../uploads/';
        @$tmp_name = $_FILES['gorsel']["tmp_name"];
        @$gorseladi = temizle($adi);
        @$dosya = $_FILES['gorsel']["name"];
        @$uzanti = extens($dosya);

        $dosya_boyutu = filesize($tmp_name);

        #Benzersiz oluşturma
        $benzersizsayi1 = rand(20000, 32000);
        $benzersizsayi2 = rand(20000, 32000);
        $benzersizsayi3 = rand(20000, 32000);
        $benzersizad = $gorseladi . "-profil-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;

        #thumbnail
        $image = new SimpleImage();
        $image->load($_FILES['gorsel']['tmp_name']);
        $image->resizeToWidth(500);
        $image->save("$uploads_dir/$benzersizad");


    } else {
        $benzersizad = "noimage.jpg";
    }

    // parolalar eşleşmiyorsa geri döndür
    if ( $_POST['parola'] !== $_POST['parola2']) { 

        return Header("Location: ../../views/admin-yonetimi?perform=add&statu=passNo");
    }
    
    // kullanıcı adı kontrol et
    $userName = $_POST['kullanici'];

    $check = $db->query("SELECT COUNT(*) FROM tbl_admin WHERE kullanici='$userName'");
    $count = $check->fetchColumn();

    if ( $count>0 ) { 
        return Header("Location: ../../views/admin-yonetimi?perform=add&statu=usrNo");
    }

    // parolayı 3 x md5 cryptle
    $parola = md5(md5(md5($_POST['parola'])));
   
    try
    {
        #Database kaydı
        $savePage = $db->prepare("INSERT INTO tbl_admin SET
            durum=:durum,
            gorsel=:gorsel,
            unvan=:unvan,
            adi=:adi,
            kullanici=:kullanici,
            email=:email,
            rol=:rol,
            sifre=:sifre,
            y_sayfa=:y_sayfa,
            y_icerik=:y_icerik,
            y_site=:y_site
        ");
            
        $savePage->execute(array(
            'durum' => $_POST['durum'],
            'gorsel' => $benzersizad,
            'unvan' => $_POST['unvan'],
            'adi' => $userName,
            'kullanici' => $_POST['kullanici'],
            'email' => $_POST['email'],
            'rol' => $_POST['rol'],
            'sifre' => $parola,
            'y_sayfa' => $_POST['y_sayfa'],
            'y_icerik' => $_POST['y_icerik'],
            'y_site' => $_POST['y_site']
          
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
                'islem' => 'Yeni kullanıcı ekleme',
                'adi' => $userName,
                'icerik' => $adi,
                'uye_id' => $userID
            ));
            
            #Log kaydetme işlemi başarılı ise geri dön
            if($saveLog){
                Header("Location: ../../views/admin-yonetimi?statu=ok");
            }else{
                Header("Location: ../../views/admin-yonetimi?statu=logNo");
            }

            
        } else {

            Header("Location: ../../views/admin-yonetimi?statu=no");
        }
    }catch (PDOException $e) {
        echo $e->getMessage();
    }
    

 }


 #admin yönetimi sayfa içerik düzenleme
 if ( isset($_POST['edit']) ) { 

    $adi = $_POST['adi'];
    $oldImg = $_POST['old-image'];
    $id = $_POST['id'];

    #uzantı jpg jpeg png yada gif ise aşağıdaki kod bloğunu çalıştır
    if ($_FILES['gorsel']['size']>0) {
        
        #Dosya yükleme yolu belirleme ve dosya adı temizleme
        $uploads_dir = '../../../uploads/';
        @$tmp_name = $_FILES['gorsel']["tmp_name"];
        @$gorseladi = temizle($adi);
        @$dosya = $_FILES['gorsel']["name"];
        @$uzanti = extens($dosya);

        $dosya_boyutu = filesize($tmp_name);

        #Benzersiz oluşturma
        $benzersizsayi1 = rand(20000, 32000);
        $benzersizsayi2 = rand(20000, 32000);
        $benzersizsayi3 = rand(20000, 32000);
        $benzersizad = $gorseladi . "-profil-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;

        #thumbnail
        $image = new SimpleImage();
        $image->load($_FILES['gorsel']['tmp_name']);
        $image->resizeToWidth(500);
        $image->save("$uploads_dir/$benzersizad");

    } else {
        $benzersizad = $oldImg;
    }

    // parolalar eşleşmiyorsa geri döndür
    if ( $_POST['parola'] !== $_POST['parola2']) { 

        return Header("Location: ../../views/admin-yonetimi?perform=edit&id=$id&statu=passNo");
    }
    
    // kullanıcı adı kontrol et
    $userName = $_POST['kullanici'];

    $check = $db->query("SELECT COUNT(*) FROM tbl_admin WHERE kullanici='$userName'");
    $count = $check->fetchColumn();

    if ( $count>1 ) { 
        return Header("Location: ../../views/admin-yonetimi?perform=edit&id=$id&statu=usrNo");
    }

    // parola doldurulmuş ise parolayı güncelle
    if($_POST['parola'] !== "" AND $_POST['parola2'] !== ""){
        // parolayı 3 x md5 ile cryptle
        $parola = md5(md5(md5($_POST['parola'])));
    }else{
        $getRow = $db->prepare("SELECT * FROM tbl_admin WHERE id=$id LIMIT 1");
        $getRow->execute();
        $getPass = $getRow->fetch();
        $parola = $getPass['sifre'];
    }
   
    try
    {
        #Database kaydı
        $savePage = $db->prepare("UPDATE tbl_admin SET
            durum=:durum,
            gorsel=:gorsel,
            unvan=:unvan,
            adi=:adi,
            kullanici=:kullanici,
            email=:email,
            rol=:rol,
            sifre=:sifre,
            y_sayfa=:y_sayfa,
            y_icerik=:y_icerik,
            y_site=:y_site
            WHERE id=:id
        ");
            
        $savePage->execute(array(
            'durum' => $_POST['durum'],
            'gorsel' => $benzersizad,
            'unvan' => $_POST['unvan'],
            'adi' => $userName,
            'kullanici' => $_POST['kullanici'],
            'email' => $_POST['email'],
            'rol' => $_POST['rol'],
            'sifre' => $parola,
            'y_sayfa' => $_POST['y_sayfa'],
            'y_icerik' => $_POST['y_icerik'],
            'y_site' => $_POST['y_site'],
            'id' => $id
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
                'islem' => 'Kullanıcı güncelleme',
                'adi' => $userName,
                'icerik' => $adi,
                'uye_id' => $userID
            ));
            
            #Log kaydetme işlemi başarılı ise geri dön
            if($saveLog){
                Header("Location: ../../views/admin-yonetimi?statu=ok");
            }else{
                Header("Location: ../../views/admin-yonetimi?statu=logNo");
            }

            
        } else {

            Header("Location: ../../views/admin-yonetimi?statu=no");
        }
    }catch (PDOException $e) {
        echo $e->getMessage();
    }

}

//silme işlemi
if ($_GET["perform"] == "delete") {
    
    $contentID = $_GET["id"];
    $adi = $_GET["adi"];
    
    $delete = $db->exec("DELETE from tbl_admin where id = $contentID");
    $deleteGallery = $db->exec("DELETE from tbl_galeri where haber_id = $contentID");

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
            'islem' => 'Kullanıcı silme',
            'adi' => $userName,
            'icerik' => $adi,
            'uye_id' => $userID
        ));
        
        #Log kaydetme işlemi başarılı ise geri dön
        if($saveLog){
            Header("Location: ../../views/admin-yonetimi?statu=ok");
        }else{
            Header("Location: ../../views/admin-yonetimi?statu=logNo");
        }

        if($saveLog) {
            header("Location: ../../views/admin-yonetimi?statu=ok");
        }else{
            header("Location: ../../views/admin-yonetimi?statu=logNo");
        }

    }else{
        header("Location: ../../views/admin-yonetimi?statu=no");
    }

}



ob_flush(); 

$db=null;
