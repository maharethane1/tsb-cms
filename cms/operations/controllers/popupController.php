<?php

ob_start();

include('../../../connection/connect.php');
include('../functions/functionImgSizer.php');
include('../functions/functionImgExtension.php');
include('../functions/clearCharacter.php');

#Log kayıtları için dataları değişkene aktar
$performName = "Pop-up ayarları";
$userName = $_COOKIE['userName'];
$userID = $_COOKIE['userID'];


#cozumler sayfa içerik kaydetme
if (isset($_POST['update'])) {
    
    $name = $_POST['baslik'];
    #Eski görsel yüklü ise oldImage değişkenine aktar
    $oldImage = $_POST['old-image'];
    
    if ( $_FILES['resim']['size']>0 ) { 
        
        $uploads_dir = '../../../uploads/';
        
        @$tmp_name = $_FILES['resim']["tmp_name"];
       
        @$resimadi = temizle($name);
        print_r($_FILES);
        @$dosya = $_FILES['resim']["name"];
        @$uzanti = extens($dosya);
        
        #resim isminin benzersiz olması
        $benzersizsayi1 = rand(20000, 32000);
        $benzersizsayi2 = rand(20000, 32000);
        $benzersizsayi3 = rand(20000, 32000);
        $benzersizad = $resimadi . "-popup-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad2 = "t1-" . $resimadi . "-popup-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad3 = "t2-" . $resimadi . "-popup-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;

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

     }else{
         $benzersizad = $oldImage;
     }
    
    try {
        #Database kaydı
        $savePage = $db->prepare("UPDATE tbl_site SET

        popup_baslik=:popup_baslik,
        popup_gorsel=:popup_gorsel,
        popup_aktif=:popup_aktif
        WHERE id=1

        ");

        $savePage->execute(array(
            'popup_baslik' => $_POST['baslik'],
            'popup_gorsel' => $benzersizad,
            'popup_aktif' => $_POST['aktif']
        ));

        #Kayıt edilen verinin ID sini çek
        $contentID = 1;

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
                'islem' => 'Ayarlar güncellendi',
                'adi' => $userName,
                'icerik' => $adi,
                'uye_id' => $userID
            ));

            #Log kaydetme işlemi başarılı ise geri dön
            if ($saveLog) {
                Header("Location: ../../views/pop-up-ayarlari?statu=ok");
            } else {
                Header("Location: ../../views/pop-up-ayarlari?statu=logNo");
            }
        } else {

            Header("Location: ../../views/pop-up-ayarlari?statu=no");
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

ob_flush();

$db = null;
