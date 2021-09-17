<?php 

ob_start();

include('../../../connection/connect.php');
include('../functions/functionImgSizer.php');
include('../functions/functionImgExtension.php');
include('../functions/clearCharacter.php');
include('../functions/getInput.php');

#Log kayıtları için dataları değişkene aktar
$performName = "Ekip Yönetimi";
$userName = $_COOKIE['userName'];
$userID = $_COOKIE['userID'];


#cozumler sayfa içerik kaydetme
if ( isset($_POST['add']) ) { 

    $adi = $_POST['adi_tr'];

    $benzersizad_1 = uploadImage("ekip", "resim", 1);
    $benzersizad_2 = uploadImage("ekip", "resim", 2);
    
    try
    {
        #Database kaydı
        $savePage = $db->prepare("INSERT INTO tbl_ekip SET
            adi_tr=:adi_tr,
            unvan_tr=:unvan_tr,
            aciklama_tr=:aciklama_tr,
            aktif_tr=:aktif_tr,

            adi_en=:adi_en,
            unvan_en=:unvan_en,
            aciklama_en=:aciklama_en,
            aktif_en=:aktif_en,

            adi_es=:adi_es,
            unvan_es=:unvan_es,
            aciklama_es=:aciklama_es,
            aktif_es=:aktif_es,

            adi_fr=:adi_fr,
            unvan_fr=:unvan_fr,
            aciklama_fr=:aciklama_fr,
            aktif_fr=:aktif_fr,

            adi_ar=:adi_ar,
            unvan_ar=:unvan_ar,
            aciklama_ar=:aciklama_ar,
            aktif_ar=:aktif_ar,

            email=:email,
            linkedin=:linkedin,
            kategori_id=:kategori_id,
            gorsel_1=:gorsel_1,
            gorsel_2=:gorsel_2,
            aktif=:aktif
        ");
            
        $savePage->execute(array(

            'adi_tr' => $_POST['adi_tr'],
            'unvan_tr' => $_POST['unvan_tr'],
            'aciklama_tr' => $_POST['aciklama_tr'],
            'aktif_tr' => $_POST['aktif_tr'],

            'adi_en' => $_POST['adi_en'],
            'unvan_en' => $_POST['unvan_en'],
            'aciklama_en' => $_POST['aciklama_en'],
            'aktif_en' => $_POST['aktif_en'],

            'adi_es' => $_POST['adi_es'],
            'unvan_es' => $_POST['unvan_es'],
            'aciklama_es' => $_POST['aciklama_es'],
            'aktif_es' => $_POST['aktif_es'],

            'adi_fr' => $_POST['adi_fr'],
            'unvan_fr' => $_POST['unvan_fr'],
            'aciklama_fr' => $_POST['aciklama_fr'],
            'aktif_fr' => $_POST['aktif_fr'],

            'adi_ar' => $_POST['adi_ar'],
            'unvan_ar' => $_POST['unvan_ar'],
            'aciklama_ar' => $_POST['aciklama_ar'],
            'aktif_ar' => $_POST['aktif_ar'],

            'email' => $_POST['email'],
            'linkedin' => $_POST['linkedin'],
            'kategori_id' => $_POST['kategori_id'],
            'aktif' => $_POST['aktif'],
            'gorsel_1' => $benzersizad_1,
            'gorsel_2' => $benzersizad_2
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
                'islem' => 'Yeni ekip üyesi ekleme',
                'adi' => $userName,
                'icerik' => ucfirst($adi),
                'uye_id' => $userID
            ));
            
            #Log kaydetme işlemi başarılı ise geri dön
            if($saveLog){
                Header("Location: ../../views/ekip-yonetimi?statu=ok");
            }else{
                Header("Location: ../../views/ekip-yonetimi?statu=logNo");
            }

            
        } else {

            Header("Location: ../../views/ekip-yonetimi?statu=no");
        }
    }catch (PDOException $e) {
        echo $e->getMessage();
    }
    

 }


 #içerik düzenleme
 if ( isset($_POST['edit']) ) { 
   
    $adi = $_POST['adi_tr'];
    $oldImg = $_POST['old-image'];
    $id = $_POST['id'];

     $benzersizad_1 = editImage("ekip", "resim", "1");
     $benzersizad_2 = editImage("ekip", "resim", "2");
    
    try
    {
        #Database kaydı
        $savePage = $db->prepare("UPDATE tbl_ekip SET
            adi_tr=:adi_tr,
            unvan_tr=:unvan_tr,
            aciklama_tr=:aciklama_tr,
            aktif_tr=:aktif_tr,

            adi_en=:adi_en,
            unvan_en=:unvan_en,
            aciklama_en=:aciklama_en,
            aktif_en=:aktif_en,

            adi_es=:adi_es,
            unvan_es=:unvan_es,
            aciklama_es=:aciklama_es,
            aktif_es=:aktif_es,

            adi_fr=:adi_fr,
            unvan_fr=:unvan_fr,
            aciklama_fr=:aciklama_fr,
            aktif_fr=:aktif_fr,

            adi_ar=:adi_ar,
            unvan_ar=:unvan_ar,
            aciklama_ar=:aciklama_ar,
            aktif_ar=:aktif_ar,

            email=:email,
            linkedin=:linkedin,
            kategori_id=:kategori_id,
            gorsel_1=:gorsel_1,
            gorsel_2=:gorsel_2,
            aktif=:aktif
            WHERE id=:id
        ");
            
        $savePage->execute(array(

            'adi_tr' => $_POST['adi_tr'],
            'unvan_tr' => $_POST['unvan_tr'],
            'aciklama_tr' => $_POST['aciklama_tr'],
            'aktif_tr' => $_POST['aktif_tr'],

            'adi_en' => $_POST['adi_en'],
            'unvan_en' => $_POST['unvan_en'],
            'aciklama_en' => $_POST['aciklama_en'],
            'aktif_en' => $_POST['aktif_en'],

            'adi_es' => $_POST['adi_es'],
            'unvan_es' => $_POST['unvan_es'],
            'aciklama_es' => $_POST['aciklama_es'],
            'aktif_es' => $_POST['aktif_es'],

            'adi_fr' => $_POST['adi_fr'],
            'unvan_fr' => $_POST['unvan_fr'],
            'aciklama_fr' => $_POST['aciklama_fr'],
            'aktif_fr' => $_POST['aktif_fr'],

            'adi_ar' => $_POST['adi_ar'],
            'unvan_ar' => $_POST['unvan_ar'],
            'aciklama_ar' => $_POST['aciklama_ar'],
            'aktif_ar' => $_POST['aktif_ar'],

            'email' => $_POST['email'],
            'linkedin' => $_POST['linkedin'],
            'kategori_id' => $_POST['kategori_id'],
            'aktif' => $_POST['aktif'],
            'gorsel_1' => $benzersizad_1,
            'gorsel_2' => $benzersizad_2,
            'id' => $id
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
                'islem' => 'Ekip üyesi güncelleme',
                'adi' => $userName,
                'icerik' => $adi,
                'uye_id' => $userID
            ));
            
            #Log kaydetme işlemi başarılı ise geri dön
            if($saveLog){
                Header("Location: ../../views/ekip-yonetimi?statu=ok");
            }else{
                Header("Location: ../../views/ekip-yonetimi?statu=logNo");
            }

            
        } else {

            Header("Location: ../../views/ekip-yonetimi?statu=no");
        }
    }catch (PDOException $e) {
        echo $e->getMessage();
    }
    

}

//silme işlemi
if ($_GET["perform"] == "delete") {
    
    $contentID = $_GET["id"];
    $adi = $_GET["adi"];
    
    $delete = $db->exec("DELETE from tbl_ekip where id = $contentID");

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
            'islem' => 'Ekip üyesi silme',
            'adi' => $userName,
            'icerik' => $adi,
            'uye_id' => $userID
        ));
        
        #Log kaydetme işlemi başarılı ise geri dön
        if($saveLog){
            Header("Location: ../../views/ekip-yonetimi?statu=ok");
        }else{
            Header("Location: ../../views/ekip-yonetimi?statu=logNo");
        }

        if($saveLog) {
            header("Location: ../../views/ekip-yonetimi?statu=ok");
        }else{
            header("Location: ../../views/ekip-yonetimi?statu=logNo");
        }

    }else{
        header("Location: ../../views/ekip-yonetimi?statu=no");
    }

}

if(isset($_POST['sort'])){
   
    $items = $_POST['sort'];

    foreach ($items as $sira => $id  ) {
        
         #Database kaydı
         $save = $db->prepare("UPDATE tbl_ekip SET sira=:sira WHERE id=$id");
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
