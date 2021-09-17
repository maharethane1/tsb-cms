<?php 

ob_start();

include('../../../connection/connect.php');
include('../functions/functionImgSizer.php');
include('../functions/functionImgExtension.php');
include('../functions/clearCharacter.php');

#Log kayıtları için dataları değişkene aktar
$performName = "Departman Yönetimi";
$userName = $_COOKIE['userName'];
$userID = $_COOKIE['userID'];


#cozumler sayfa içerik kaydetme
if ( isset($_POST['add']) ) { 

    $adi = $_POST['adi_tr'];

    try
    {
        #Database kaydı
        $savePage = $db->prepare("INSERT INTO tbl_ekip_kategori SET
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

            'aktif' => $_POST['aktif'],
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
                'islem' => 'Yeni departman ekleme',
                'adi' => $userName,
                'icerik' => ucfirst($adi),
                'uye_id' => $userID
            ));
            
            #Log kaydetme işlemi başarılı ise geri dön
            if($saveLog){
                Header("Location: ../../views/departman-ayarlari?statu=ok");
            }else{
                Header("Location: ../../views/departman-ayarlari?statu=logNo");
            }

            
        } else {

            Header("Location: ../../views/departman-ayarlari?statu=no");
        }
    }catch (PDOException $e) {
        echo $e->getMessage();
    }
    

 }


 #içerik düzenleme
 if ( isset($_POST['edit']) ) { 
   
    $adi = $_POST['adi_tr'];
    $id = $_POST['id'];
    
    try
    {
        #Database kaydı
        $savePage = $db->prepare("UPDATE tbl_ekip_kategori SET
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
                'islem' => 'Departman güncelleme',
                'adi' => $userName,
                'icerik' => $adi,
                'uye_id' => $userID
            ));
            
            #Log kaydetme işlemi başarılı ise geri dön
            if($saveLog){
                Header("Location: ../../views/departman-ayarlari?statu=ok");
            }else{
                Header("Location: ../../views/departman-ayarlari?statu=logNo");
            }

            
        } else {

            Header("Location: ../../views/departman-ayarlari?statu=no");
        }
    }catch (PDOException $e) {
        echo $e->getMessage();
    }
    

}

//silme işlemi
if ($_GET["perform"] == "delete") {
    
    $contentID = $_GET["id"];
    $adi = $_GET["adi"];

    $checkCat = $db->query("SELECT COUNT(*) FROM tbl_ekip WHERE kategori_id=$contentID");
    $checkCat = $checkCat->fetchColumn();

    if($checkCat>0){
        return  Header("Location: ../../views/departman-ayarlari?statu=hasComp");
    }

    $delete = $db->exec("DELETE from tbl_ekip_kategori where id = $contentID");
    

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
            'islem' => 'Departman silme',
            'adi' => $userName,
            'icerik' => $adi,
            'uye_id' => $userID
        ));
        
        #Log kaydetme işlemi başarılı ise geri dön
        if($saveLog){
            Header("Location: ../../views/departman-ayarlari?statu=ok");
        }else{
            Header("Location: ../../views/departman-ayarlari?statu=logNo");
        }

        if($saveLog) {
            header("Location: ../../views/departman-ayarlari?statu=ok");
        }else{
            header("Location: ../../views/departman-ayarlari?statu=logNo");
        }

    }else{
        header("Location: ../../views/departman-ayarlari?statu=no");
    }

}

if(isset($_POST['sort'])){
   
    $items = $_POST['sort'];

    foreach ($items as $sira => $id  ) {
        
         #Database kaydı
         $save = $db->prepare("UPDATE tbl_ekip_kategori SET sira=:sira WHERE id=$id");
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
