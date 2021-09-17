<?php 

ob_start();

include('../../../connection/connect.php');
include('../functions/functionImgSizer.php');
include('../functions/functionImgExtension.php');
include('../functions/clearCharacter.php');

#Log kayıtları için dataları değişkene aktar
$performName = "Çözümler Sayfa Yönetimi";
$userName = $_COOKIE['userName'];
$userID = $_COOKIE['userID'];


#cozumler sayfa içerik kaydetme
if ( isset($_POST['addPage']) ) { 

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
        $benzersizad = $resimadi . "-cozumler-icerik-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad2 = "t1-" . $resimadi . "-cozumler-icerik-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad3 = "t2-" . $resimadi . "-cozumler-icerik-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;

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
        $savePage = $db->prepare("INSERT INTO tbl_sayfa SET
            adi_tr= :adi_tr,
            aciklama_tr= :aciklama_tr,
            desc_tr= :desc_tr,
            aktif_tr= :aktif_tr,
            etiket_tr= :etiket_tr,

            adi_en= :adi_en,
            aciklama_en= :aciklama_en,
            desc_en= :desc_en,
            aktif_en= :aktif_en,
            etiket_en= :etiket_en,

            adi_es= :adi_es,
            aciklama_es= :aciklama_es,
            desc_es= :desc_es,
            aktif_es= :aktif_es,
            etiket_es= :etiket_es,

            adi_fr= :adi_fr,
            aciklama_fr= :aciklama_fr,
            desc_fr= :desc_fr,
            aktif_fr= :aktif_fr,
            etiket_fr= :etiket_fr,

            adi_ar= :adi_ar,
            aciklama_ar= :aciklama_ar,
            desc_ar= :desc_ar,
            aktif_ar= :aktif_ar,
            etiket_ar= :etiket_ar,

            video_aktif= :video_aktif,
            video= :video,
            gorsel= :gorsel,
            tarih= :tarih,
            aktif= :aktif,
            cozumler='1'
        ");
            
        $savePage->execute(array(
            'adi_tr' => $_POST['adi_tr'],
            'aciklama_tr' => $_POST['aciklama_tr'],
            'desc_tr' => $_POST['desc_tr'],
            'aktif_tr' => $_POST['aktif_tr'],
            'etiket_tr' => $_POST['etiket_tr'],

            'adi_en' => $_POST['adi_en'],
            'aciklama_en' => $_POST['aciklama_en'],
            'desc_en' => $_POST['desc_en'],
            'aktif_en' => $_POST['aktif_en'],
            'etiket_en' => $_POST['etiket_en'],

            'adi_es' => $_POST['adi_es'],
            'aciklama_es' => $_POST['aciklama_es'],
            'desc_es' => $_POST['desc_es'],
            'aktif_es' => $_POST['aktif_es'],
            'etiket_es' => $_POST['etiket_es'],

            'adi_fr' => $_POST['adi_fr'],
            'aciklama_fr' => $_POST['aciklama_fr'],
            'desc_fr' => $_POST['desc_fr'],
            'aktif_fr' => $_POST['aktif_fr'],
            'etiket_fr' => $_POST['etiket_fr'],

            'adi_ar' => $_POST['adi_ar'],
            'aciklama_ar' => $_POST['aciklama_ar'],
            'desc_ar' => $_POST['desc_ar'],
            'aktif_ar' => $_POST['aktif_ar'],
            'etiket_ar' => $_POST['etiket_ar'],

            'video_aktif' => $_POST['video_aktif'],
            'video' => $_POST['video'],
            'gorsel' => $benzersizad,
            'tarih' => date("Y-m-d H:i:s"),
            'aktif' => $_POST['aktif']
        ));

        #Kayıt edilen verinin ID sini çek
        $contentID = $db->lastInsertId();

        #Kayıt işlemi başarılı ise işlemi logla
        if ($savePage) {
            
            #Log kaydını database e kaydet
            $saveLog = $db->prepare("INSERT INTO tbl_log SET
                islem_id= :islem_id,
                sayfa= :sayfa,
                islem= :islem,
                adi= :adi,
                icerik= :icerik,
                uye_id= :uye_id
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
                Header("Location: ../../views/cozumler?statu=ok");
            }else{
                Header("Location: ../../views/cozumler?statu=logNo");
            }

            
        } else {

            Header("Location: ../../views/cozumler?statu=no");
        }
    }catch (PDOException $e) {
        echo $e->getMessage();
    }
    

 }


 #cozumler sayfa içerik düzenleme
 if ( isset($_POST['editPage']) ) { 

    $adi = $_POST['adi_tr'];
    $oldImage = $_POST['resim2'];

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
        $benzersizad = $resimadi . "-cozumler-icerik-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad2 = "t1-" . $resimadi . "-cozumler-icerik-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad3 = "t2-" . $resimadi . "-cozumler-icerik-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;

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
        $save = $db->prepare("UPDATE tbl_sayfa SET
            adi_tr= :adi_tr,
            aciklama_tr= :aciklama_tr,
            desc_tr= :desc_tr,
            aktif_tr= :aktif_tr,
            etiket_tr= :etiket_tr,

            adi_en= :adi_en,
            aciklama_en= :aciklama_en,
            desc_en= :desc_en,
            aktif_en= :aktif_en,
            etiket_en= :etiket_en,

            adi_es= :adi_es,
            aciklama_es= :aciklama_es,
            desc_es= :desc_es,
            aktif_es= :aktif_es,
            etiket_es= :etiket_es,

            adi_fr= :adi_fr,
            aciklama_fr= :aciklama_fr,
            desc_fr= :desc_fr,
            aktif_fr= :aktif_fr,
            etiket_fr= :etiket_fr,

            adi_ar= :adi_ar,
            aciklama_ar= :aciklama_ar,
            desc_ar= :desc_ar,
            aktif_ar= :aktif_ar,
            etiket_ar= :etiket_ar,

            video_aktif= :video_aktif,
            video= :video,
            gorsel= :gorsel,
            aktif= :aktif,
            cozumler='1'
            WHERE id=:id
        ");
        $save->execute(array(
            'adi_tr' => $_POST['adi_tr'],
            'aciklama_tr' => $_POST['aciklama_tr'],
            'desc_tr' => $_POST['desc_tr'],
            'aktif_tr' => $_POST['aktif_tr'],
            'etiket_tr' => $_POST['etiket_tr'],

            'adi_en' => $_POST['adi_en'],
            'aciklama_en' => $_POST['aciklama_en'],
            'desc_en' => $_POST['desc_en'],
            'aktif_en' => $_POST['aktif_en'],
            'etiket_en' => $_POST['etiket_en'],

            'adi_es' => $_POST['adi_es'],
            'aciklama_es' => $_POST['aciklama_es'],
            'desc_es' => $_POST['desc_es'],
            'aktif_es' => $_POST['aktif_es'],
            'etiket_es' => $_POST['etiket_es'],

            'adi_fr' => $_POST['adi_fr'],
            'aciklama_fr' => $_POST['aciklama_fr'],
            'desc_fr' => $_POST['desc_fr'],
            'aktif_fr' => $_POST['aktif_fr'],
            'etiket_fr' => $_POST['etiket_fr'],

            'adi_ar' => $_POST['adi_ar'],
            'aciklama_ar' => $_POST['aciklama_ar'],
            'desc_ar' => $_POST['desc_ar'],
            'aktif_ar' => $_POST['aktif_ar'],
            'etiket_ar' => $_POST['etiket_ar'],

            'video_aktif' => $_POST['video_aktif'],
            'video' => $_POST['video'],
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
                Header("Location: ../../views/cozumler?statu=ok");
            }else{
                Header("Location: ../../views/cozumler?statu=logNo");
            }

            
        } else {

            Header("Location: ../../views/cozumler?statu=no");
        }
    }catch (PDOException $e) {
        echo $e->getMessage();
    }
    

}

//silme işlemi
if ($_GET["perform"] == "delete") {
    
    $contentID = $_GET["id"];
    $adi = $_GET["adi"];
    
    $delete = $db->exec("DELETE from tbl_sayfa where id = $contentID");

    if ($delete) {

        #Log kaydını database e kaydet
        $saveLog = $db->prepare("INSERT INTO tbl_log SET
            islem_id= :islem_id,
            sayfa= :sayfa,
            islem= :islem,
            adi= :adi,
            icerik= :icerik,
            uye_id= :uye_id
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
            Header("Location: ../../views/cozumler?statu=ok");
        }else{
            Header("Location: ../../views/cozumler?statu=logNo");
        }

        if($saveLog) {
            header("Location: ../../views/cozumler?statu=ok");
        }else{
            header("Location: ../../views/cozumler?statu=logNo");
        }

    }else{
        header("Location: ../../views/cozumler?statu=no");
    }

}

if(isset($_POST['sort'])){
   
    $items = $_POST['sort'];

    foreach ($items as $sira => $id  ) {
        
         #Database kaydı
         $save = $db->prepare("UPDATE tbl_sayfa SET sira=:sira WHERE id=$id");
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
