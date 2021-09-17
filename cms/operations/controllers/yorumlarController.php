<?php 

ob_start();

include('../../../connection/connect.php');
include('../functions/functionImgSizer.php');
include('../functions/functionImgExtension.php');
include('../functions/clearCharacter.php');

#Log kayıtları için dataları değişkene aktar
$performName = "Müşteri Yorumları Yönetimi";
$userName = $_COOKIE['userName'];
$userID = $_COOKIE['userID'];


#yorumlar sayfa içerik kaydetme
if ( isset($_POST['add']) ) { 

    $adi = $_POST['adi_tr'];

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
        $benzersizad = $resimadi . "-yorum-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad2 = "t1-" . $resimadi . "-yorum-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad3 = "t2-" . $resimadi . "-yorum-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;

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
        $savePage = $db->prepare("INSERT INTO tbl_musteri_yorumlari SET
            adi_tr=:adi_tr,
            aciklama_tr=:aciklama_tr,
            unvan_tr=:unvan_tr,
            firma_tr=:firma_tr,
            aktif_tr=:aktif_tr,

            adi_en=:adi_en,
            aciklama_en=:aciklama_en,
            unvan_en=:unvan_en,
            firma_en=:firma_en,
            aktif_en=:aktif_en,

            adi_fr=:adi_fr,
            aciklama_fr=:aciklama_fr,
            unvan_fr=:unvan_fr,
            firma_fr=:firma_fr,
            aktif_fr=:aktif_fr,

            adi_es=:adi_es,
            aciklama_es=:aciklama_es,
            unvan_es=:unvan_es,
            firma_es=:firma_es,
            aktif_es=:aktif_es,

            adi_ar=:adi_ar,
            aciklama_ar=:aciklama_ar,
            unvan_ar=:unvan_ar,
            firma_ar=:firma_ar,
            aktif_ar=:aktif_ar,

            gorsel=:gorsel,
            aktif=:aktif
        ");
            
        $savePage->execute(array(
            'adi_tr' => $_POST['adi_tr'],
            'aciklama_tr' => $_POST['aciklama_tr'],
            'unvan_tr' => $_POST['unvan_tr'],
            'firma_tr' => $_POST['firma_tr'],
            'aktif_tr' => $_POST['aktif_tr'],

            'adi_en' => $_POST['adi_en'],
            'aciklama_en' => $_POST['aciklama_en'],
            'unvan_en' => $_POST['unvan_en'],
            'firma_en' => $_POST['firma_en'],
            'aktif_en' => $_POST['aktif_en'],
            
            'adi_fr' => $_POST['adi_fr'],
            'aciklama_fr' => $_POST['aciklama_fr'],
            'unvan_fr' => $_POST['unvan_fr'],
            'firma_fr' => $_POST['firma_fr'],
            'aktif_fr' => $_POST['aktif_fr'],

            'adi_es' => $_POST['adi_es'],
            'aciklama_es' => $_POST['aciklama_es'],
            'unvan_es' => $_POST['unvan_es'],
            'firma_es' => $_POST['firma_es'],
            'aktif_es' => $_POST['aktif_es'],

            'adi_ar' => $_POST['adi_ar'],
            'aciklama_ar' => $_POST['aciklama_ar'],
            'unvan_ar' => $_POST['unvan_ar'],
            'firma_ar' => $_POST['firma_ar'],
            'aktif_ar' => $_POST['aktif_ar'],

            'gorsel' => $benzersizad,
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
                'icerik' => $adi,
                'uye_id' => $userID
            ));
            
            #Log kaydetme işlemi başarılı ise geri dön
            if($saveLog){
                Header("Location: ../../views/kullanici-yorumlari?statu=ok");
            }else{
                Header("Location: ../../views/kullanici-yorumlari?statu=logNo");
            }

            
        } else {

            Header("Location: ../../views/kullanici-yorumlari?statu=no");
        }
    }catch (PDOException $e) {
        echo $e->getMessage();
    }
    
 }


 #yorumlar sayfa içerik düzenleme
 if ( isset($_POST['edit']) ) { 

    $adi = $_POST['adi_tr'];
    $oldImage = $_POST['old-image'];

    if ( $_FILES['resim']['size']>0 ) { 
        $uploads_dir = '../../../uploads/';
        
        @$tmp_name = $_FILES['resim']["tmp_name"];
        
        @$resimadi = temizle($adi);
        @$dosya = $_FILES['resim']["name"];
        echo "ok";
        @$uzanti = extens($dosya);
        
        #resim isminin benzersiz olması
        $benzersizsayi1 = rand(20000, 32000);
        $benzersizsayi2 = rand(20000, 32000);
        $benzersizsayi3 = rand(20000, 32000);
        $benzersizad = $resimadi . "-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        @move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad");
    }else{
        $benzersizad = $oldImage;
    }

    try
    {
        #Database kaydı
        $save = $db->prepare("UPDATE tbl_musteri_yorumlari SET
            adi_tr=:adi_tr,
            aciklama_tr=:aciklama_tr,
            unvan_tr=:unvan_tr,
            firma_tr=:firma_tr,
            aktif_tr=:aktif_tr,

            adi_en=:adi_en,
            aciklama_en=:aciklama_en,
            unvan_en=:unvan_en,
            firma_en=:firma_en,
            aktif_en=:aktif_en,

            adi_fr=:adi_fr,
            aciklama_fr=:aciklama_fr,
            unvan_fr=:unvan_fr,
            firma_fr=:firma_fr,
            aktif_fr=:aktif_fr,

            adi_es=:adi_es,
            aciklama_es=:aciklama_es,
            unvan_es=:unvan_es,
            firma_es=:firma_es,
            aktif_es=:aktif_es,

            adi_ar=:adi_ar,
            aciklama_ar=:aciklama_ar,
            unvan_ar=:unvan_ar,
            firma_ar=:firma_ar,
            aktif_ar=:aktif_ar,

            gorsel=:gorsel,
            aktif=:aktif
            WHERE id=:id
        ");
            
        $save->execute(array(
            'adi_tr' => $_POST['adi_tr'],
            'aciklama_tr' => $_POST['aciklama_tr'],
            'unvan_tr' => $_POST['unvan_tr'],
            'firma_tr' => $_POST['firma_tr'],
            'aktif_tr' => $_POST['aktif_tr'],

            'adi_en' => $_POST['adi_en'],
            'aciklama_en' => $_POST['aciklama_en'],
            'unvan_en' => $_POST['unvan_en'],
            'firma_en' => $_POST['firma_en'],
            'aktif_en' => $_POST['aktif_en'],
            
            'adi_fr' => $_POST['adi_fr'],
            'aciklama_fr' => $_POST['aciklama_fr'],
            'unvan_fr' => $_POST['unvan_fr'],
            'firma_fr' => $_POST['firma_fr'],
            'aktif_fr' => $_POST['aktif_fr'],

            'adi_es' => $_POST['adi_es'],
            'aciklama_es' => $_POST['aciklama_es'],
            'unvan_es' => $_POST['unvan_es'],
            'firma_es' => $_POST['firma_es'],
            'aktif_es' => $_POST['aktif_es'],

            'adi_ar' => $_POST['adi_ar'],
            'aciklama_ar' => $_POST['aciklama_ar'],
            'unvan_ar' => $_POST['unvan_ar'],
            'firma_ar' => $_POST['firma_ar'],
            'aktif_ar' => $_POST['aktif_ar'],

            'gorsel' => $benzersizad,
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
                'islem' => 'İçerik güncelleme',
                'adi' => $userName,
                'icerik' => $adi,
                'uye_id' => $userID
            ));
            
            #Log kaydetme işlemi başarılı ise geri dön
            if($saveLog){
                Header("Location: ../../views/kullanici-yorumlari?statu=ok");
            }else{
                Header("Location: ../../views/kullanici-yorumlari?statu=logNo");
            }

            
        } else {

            Header("Location: ../../views/kullanici-yorumlari?statu=no");
        }
    }catch (PDOException $e) {
        echo $e->getMessage();
    }
    

}

//silme işlemi
if ($_GET["perform"] == "delete") {
    
    $contentID = $_GET["id"];
    $adi = $_GET["adi"];
    
    $delete = $db->exec("DELETE from tbl_musteri_yorumlari where id = $contentID");

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
            Header("Location: ../../views/kullanici-yorumlari?statu=ok");
        }else{
            Header("Location: ../../views/kullanici-yorumlari?statu=logNo");
        }

        if($saveLog) {
            header("Location: ../../views/kullanici-yorumlari?statu=ok");
        }else{
            header("Location: ../../views/kullanici-yorumlari?statu=logNo");
        }

    }else{
        header("Location: ../../views/kullanici-yorumlari?statu=no");
    }

}

if(isset($_POST['sort'])){
   
    $items = $_POST['sort'];

    foreach ($items as $sira => $id  ) {
        
         #Database kaydı
         $save = $db->prepare("UPDATE tbl_musteri_yorumlari SET sira=:sira WHERE id=$id");
         $save->execute(array(
            'sira' => $sira
        ));

     }
    
    if($save){
        echo "Sıralama işlemi başarılı";
    }
    

}



ob_flush(); 

$db=null;
