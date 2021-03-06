<?php 

ob_start();

include('../../../connection/connect.php');
include('../functions/functionImgSizer.php');
include('../functions/functionImgExtension.php');
include('../functions/clearCharacter.php');

#Log kayıtları için dataları değişkene aktar
$performName = "Ürün Yönetimi";
$userName = $_COOKIE['userName'];
$userID = $_COOKIE['userID'];


#ürünler içerik kaydetme
if ( isset($_POST['add']) ) { 

    $subCatID = $_POST['alt_kat_id'];

    if($subCatID==""){
        $subCatID = NULL;
    }
   
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
        $benzersizad = $resimadi . "-urun-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad2 = "t1-" . $resimadi . "-urun-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad3 = "t2-" . $resimadi . "-urun-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;

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
        $dokumanbenzersizad = $adi . "-urun-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;

        @move_uploaded_file($tmp_name, "$uploads_dir/$dokumanbenzersizad");
    }else {
        $dokumanbenzersizad=NULL;
    }

    try
    {
        ##Database kaydı
        $savePage = $db->prepare("INSERT INTO tbl_urunler SET
            kategori_id=:kategori_id,
            alt_kat_id=:alt_kat_id,
            fiyat=:fiyat,

            adi_tr=:adi_tr,
            aciklama_tr=:aciklama_tr,
            desc_tr=:desc_tr,
            aktif_tr=:aktif_tr,
            etiket_tr=:etiket_tr,

            adi_en=:adi_en,
            aciklama_en=:aciklama_en,
            desc_en=:desc_en,
            aktif_en=:aktif_en,
            etiket_en=:etiket_en,

            adi_es=:adi_es,
            aciklama_es=:aciklama_es,
            desc_es=:desc_es,
            aktif_es=:aktif_es,
            etiket_es=:etiket_es,

            adi_fr=:adi_fr,
            aciklama_fr=:aciklama_fr,
            desc_fr=:desc_fr,
            aktif_fr=:aktif_fr,
            etiket_fr=:etiket_fr,

            adi_ar=:adi_ar,
            aciklama_ar=:aciklama_ar,
            desc_ar=:desc_ar,
            aktif_ar=:aktif_ar,
            etiket_ar=:etiket_ar,

            video_aktif=:video_aktif,
            video=:video,
            gorsel=:gorsel,
            dokuman= :dokuman,
            aktif=:aktif
            ");
            
        $savePage->execute(array(
            'kategori_id' => $_POST['kategori_id'],
            'alt_kat_id' => $_POST['alt_kat_id'],
            'fiyat' => $_POST['fiyat'],

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
                'islem' => 'Yeni ürün ekleme',
                'adi' => $userName,
                'icerik' => $adi,
                'uye_id' => $userID
            ));
            
            #Log kaydetme işlemi başarılı ise geri dön
            if($saveLog){
                Header("Location: ../../views/urunler?statu=ok");
            }else{
                Header("Location: ../../views/urunler?statu=logNo");
            }
        }

    }
    catch(PDOException $e)
    {
        echo $e->getMessage();

    }

 }


 #Kurumsal sayfa içerik düzenleme
 if ( isset($_POST['edit']) ) { 

    $subCatID = $_POST['alt_kat_id'];

    if($subCatID==""){
        $subCatID = NULL;
    }

    $adi = $_POST['adi_tr'];

    #Eski görsel yüklü ise oldImage değişkenine aktar
    $oldImage = $_POST['old-image'];

    $oldDocument = $_POST['old-document'];

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
        $benzersizad = $resimadi . "-urun-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad2 = "t1-" . $resimadi . "-urun-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad3 = "t2-" . $resimadi . "-urun-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;

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
         $dokumanbenzersizad = $adi . "-urun-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;

         @move_uploaded_file($tmp_name, "$uploads_dir/$dokumanbenzersizad");
     }else {
         $dokumanbenzersizad=$oldDocument;
     }
    
    try
    {
        #Database kaydı
        $save = $db->prepare("UPDATE tbl_urunler SET
            kategori_id=:kategori_id,
            alt_kat_id=:alt_kat_id,
            fiyat=:fiyat,

            adi_tr=:adi_tr,
            aciklama_tr=:aciklama_tr,
            desc_tr=:desc_tr,
            aktif_tr=:aktif_tr,
            etiket_tr=:etiket_tr,

            adi_en=:adi_en,
            aciklama_en=:aciklama_en,
            desc_en=:desc_en,
            aktif_en=:aktif_en,
            etiket_en=:etiket_en,

            adi_es=:adi_es,
            aciklama_es=:aciklama_es,
            desc_es=:desc_es,
            aktif_es=:aktif_es,
            etiket_es=:etiket_es,

            adi_fr=:adi_fr,
            aciklama_fr=:aciklama_fr,
            desc_fr=:desc_fr,
            aktif_fr=:aktif_fr,
            etiket_fr=:etiket_fr,

            adi_ar=:adi_ar,
            aciklama_ar=:aciklama_ar,
            desc_ar=:desc_ar,
            aktif_ar=:aktif_ar,
            etiket_ar=:etiket_ar,

            video_aktif=:video_aktif,
            video=:video,
            gorsel=:gorsel,
            dokuman=:dokuman,
            aktif=:aktif
            WHERE id=:id
            ");
        $save->execute(array(
            'kategori_id' => $_POST['kategori_id'],
            'alt_kat_id' => $subCatID,
            'fiyat' => $_POST['fiyat'],

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
            'dokuman' => $dokumanbenzersizad,

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
                'islem' => 'Ürün güncelleme',
                'adi' => $userName,
                'icerik' => $adi,
                'uye_id' => $userID
            ));
            
            #Log kaydetme işlemi başarılı ise geri dön
            if($saveLog){
                Header("Location: ../../views/urunler?statu=ok");
            }else{
                Header("Location: ../../views/urunler?statu=logNo");
            }

            
        } else {

            Header("Location: ../../views/urunler?statu=no");
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
    
    $delete = $db->exec("DELETE from tbl_urunler where id = $contentID");

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
            Header("Location: ../../views/urunler?statu=ok");
        }else{
            Header("Location: ../../views/urunler?statu=logNo");
        }

        if($saveLog) {
            header("Location: ../../views/urunler?statu=ok");
        }else{
            header("Location: ../../views/urunler?statu=logNo");
        }

    }else{
        header("Location: ../../views/urunler?statu=no");
    }

}

if(isset($_POST['sort'])){
   
    $items = $_POST['sort'];

    foreach ($items as $sira => $id  ) {
        
         #Database kaydı
         $save = $db->prepare("UPDATE tbl_urunler SET sira=:sira WHERE id=$id");
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

//Kategori seçimi
if(isset($_POST['cat_id'])){

    $catID = $_POST['cat_id'];
    $getData = $db->prepare("SELECT * FROM tbl_alt_kategori WHERE kategori_id=$catID and aktif=1 ORDER BY sira ASC");
    $getData->execute();
    
    {?> 
    
    <option value=""> Alt kategori seçimi yapılmadı.. </option>
    
    <?php }

    while ($getCat = $getData->fetch(PDO::FETCH_ASSOC)) { ?>
        <option value="<?= $getCat['id']?>"> <?= $getCat['adi_tr']?> </option>
    <?php }
    
}

//Kategori seçimi - edit
if(isset($_POST['edit_cat_id'])){

    $catID = $_POST['edit_cat_id'];
    $getData = $db->prepare("SELECT * FROM tbl_alt_kategori WHERE kategori_id=$catID ORDER BY sira ASC");
    $getData->execute();

    {?> 
    
    <option value=""> Alt kategori seçimi yapılmadı.. </option>

    <?php }

    while ($getCat = $getData->fetch(PDO::FETCH_ASSOC)) { ?>
        <option value="<?= $getCat['id']?>"> <?= $getCat['adi_tr']?> </option>
    <?php }
    
}



ob_flush(); 

$db=null;
