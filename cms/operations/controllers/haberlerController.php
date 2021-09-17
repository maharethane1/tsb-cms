<?php 

ob_start();

include('../../../connection/connect.php');
include('../functions/functionImgSizer.php');
include('../functions/functionImgExtension.php');
include('../functions/clearCharacter.php');

#Log kayıtları için dataları değişkene aktar
$performName = "Haber Yönetimi";
$userName = $_COOKIE['userName'];
$userID = $_COOKIE['userID'];


#cozumler sayfa içerik kaydetme
if ( isset($_POST['add']) ) { 

    $adi = $_POST['baslik_tr'];
    
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
        $benzersizad = $resimadi . "-haber-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad2 = "t1-" . $resimadi . "-haber-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad3 = "t2-" . $resimadi . "-haber-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;

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
        #Database kaydı
        $savePage = $db->prepare("INSERT INTO tbl_haberler SET
            baslik_tr=:baslik_tr,
            icerik_tr=:icerik_tr,
            aktif_tr=:aktif_tr,

            baslik_en=:baslik_en,
            icerik_en=:icerik_en,
            aktif_en=:aktif_en,

            baslik_es=:baslik_es,
            icerik_es=:icerik_es,
            aktif_es=:aktif_es,

            baslik_fr=:baslik_fr,
            icerik_fr=:icerik_fr,
            aktif_fr=:aktif_fr,

            baslik_ar=:baslik_ar,
            icerik_ar=:icerik_ar,
            aktif_ar=:aktif_ar,

            video_aktif=:video_aktif,
            video=:video,
            gorsel=:gorsel,
            aktif=:aktif
        ");
            
        $savePage->execute(array(
            'baslik_tr' => $_POST['baslik_tr'],
            'icerik_tr' => $_POST['icerik_tr'],
            'aktif_tr' => $_POST['aktif_tr'],

            'baslik_en' => $_POST['baslik_en'],
            'icerik_en' => $_POST['icerik_en'],
            'aktif_en' => $_POST['aktif_en'],

            'baslik_es' => $_POST['baslik_es'],
            'icerik_es' => $_POST['icerik_es'],
            'aktif_es' => $_POST['aktif_es'],

            'baslik_fr' => $_POST['baslik_fr'],
            'icerik_fr' => $_POST['icerik_fr'],
            'aktif_fr' => $_POST['aktif_fr'],

            'baslik_ar' => $_POST['baslik_ar'],
            'icerik_ar' => $_POST['icerik_ar'],
            'aktif_ar' => $_POST['aktif_ar'],

            'video_aktif' => $_POST['video_aktif'],
            'video' => $_POST['video'],
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
                'islem' => 'Yeni içerik ekleme',
                'adi' => $userName,
                'icerik' => ucfirst($adi),
                'uye_id' => $userID
            ));
            
            #Log kaydetme işlemi başarılı ise geri dön
            if($saveLog){
                Header("Location: ../../views/haberler?statu=ok");
            }else{
                Header("Location: ../../views/haberler?statu=logNo");
            }

            
        } else {

            Header("Location: ../../views/haberler?statu=no");
        }
    }catch (PDOException $e) {
        echo $e->getMessage();
    }
    

 }


 #cozumler sayfa içerik düzenleme
 if ( isset($_POST['edit']) ) { 

    $adi = $_POST['baslik_tr'];

    #Eski görsel yüklü ise oldImage değişkenine aktar
    $oldImage = $_POST['old-image'];

    if ( $_FILES['resim']['size']>0 ) { 

        $uploads_dir = '../../../uploads/';
        
        @$tmp_name = $_FILES['resim']["tmp_name"];
        
        @$resimadi = temizle($adi);
        @$dosya = $_FILES['resim']["name"];
        @$uzanti = extens($dosya);
        
        #resim isminin benzersiz olması
        $benzersizsayi1 = rand(20000, 32000);
        $benzersizsayi2 = rand(20000, 32000);
        $benzersizsayi3 = rand(20000, 32000);
        $benzersizad = $resimadi . "-haber-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad2 = "t1-" . $resimadi . "-haber-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad3 = "t2-" . $resimadi . "-haber-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;

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

    try
    {
        #Database kaydı
        $save = $db->prepare("UPDATE tbl_haberler SET
            baslik_tr=:baslik_tr,
            icerik_tr=:icerik_tr,
            aktif_tr=:aktif_tr,

            baslik_en=:baslik_en,
            icerik_en=:icerik_en,
            aktif_en=:aktif_en,

            baslik_es=:baslik_es,
            icerik_es=:icerik_es,
            aktif_es=:aktif_es,

            baslik_fr=:baslik_fr,
            icerik_fr=:icerik_fr,
            aktif_fr=:aktif_fr,

            baslik_ar=:baslik_ar,
            icerik_ar=:icerik_ar,
            aktif_ar=:aktif_ar,

            video_aktif=:video_aktif,
            video=:video,
            gorsel=:gorsel,
            aktif=:aktif

            WHERE id=:id
        ");
            
        $save->execute(array(
            'baslik_tr' => $_POST['baslik_tr'],
            'icerik_tr' => $_POST['icerik_tr'],
            'aktif_tr' => $_POST['aktif_tr'],

            'baslik_en' => $_POST['baslik_en'],
            'icerik_en' => $_POST['icerik_en'],
            'aktif_en' => $_POST['aktif_en'],

            'baslik_es' => $_POST['baslik_es'],
            'icerik_es' => $_POST['icerik_es'],
            'aktif_es' => $_POST['aktif_es'],

            'baslik_fr' => $_POST['baslik_fr'],
            'icerik_fr' => $_POST['icerik_fr'],
            'aktif_fr' => $_POST['aktif_fr'],

            'baslik_ar' => $_POST['baslik_ar'],
            'icerik_ar' => $_POST['icerik_ar'],
            'aktif_ar' => $_POST['aktif_ar'],

            'video_aktif' => $_POST['video_aktif'],
            'video' => $_POST['video'],
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
                uye_id=:uye_id,
                tarih=:tarih
            ");
            
            $saveLog->execute(array(
                'islem_id' => $contentID,
                'sayfa' => $performName,
                'islem' => 'İçerik güncelleme',
                'adi' => $userName,
                'icerik' => $adi,
                'uye_id' => $userID,
                'tarih' => date("Y-m-d H:i:s")
            ));
            
            #Log kaydetme işlemi başarılı ise geri dön
            if($saveLog){
                Header("Location: ../../views/haberler?statu=ok");
            }else{
                Header("Location: ../../views/haberler?statu=logNo");
            }

            
        } else {

            Header("Location: ../../views/haberler?statu=no");
        }
    }catch (PDOException $e) {
        echo $e->getMessage();
    }
    

}

//silme işlemi
if ($_GET["perform"] == "delete") {
    
    $contentID = $_GET["id"];
    $adi = $_GET["adi"];
    
    $delete = $db->exec("DELETE from tbl_haberler where id = $contentID");

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
        if($saveLog){
            Header("Location: ../../views/haberler?statu=ok");
        }else{
            Header("Location: ../../views/haberler?statu=logNo");
        }

        if($saveLog) {
            header("Location: ../../views/haberler?statu=ok");
        }else{
            header("Location: ../../views/haberler?statu=logNo");
        }

    }else{
        header("Location: ../../views/haberler?statu=no");
    }

}

if(isset($_POST['sort'])){
   
    $items = $_POST['sort'];

    foreach ($items as $sira => $id  ) {
        
         #Database kaydı
         $save = $db->prepare("UPDATE tbl_haberler SET sira=:sira WHERE id=$id");
         $save->execute(array(
            'sira' => $sira
        ));

     }
    
    if($save){
        echo "Sıralama işlemi başarılı";
    }else{
        echo "no";
    }
    

}



ob_flush(); 

$db=null;
