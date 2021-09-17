<?php 

ob_start();

include('../../../connection/connect.php');
include('../functions/functionImgSizer.php');
include('../functions/functionImgExtension.php');
include('../functions/clearCharacter.php');

#Log kayıtları için dataları değişkene aktar
$performName = "Şube Yönetimi";
$userName = $_COOKIE['userName'];
$userID = $_COOKIE['userID'];


#cozumler sayfa içerik kaydetme
if ( isset($_POST['add']) ) { 

    $adi = $_POST['adi'];

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
        $benzersizad = $resimadi . "-sube-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad2 = "t1-" . $resimadi . "-sube-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad3 = "t2-" . $resimadi . "-sube-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;

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
        $savePage = $db->prepare("INSERT INTO tbl_sube SET
            adi= :adi,
            adres= :adres,
            telefon= :telefon,
            fax= :fax,
            email= :email,
            konum= :konum,
            aktif= :aktif,
            gorsel= :gorsel
        ");
            
        $savePage->execute(array(

            'adi' => $_POST['adi'],
            'adres' => $_POST['adres'],
            'telefon' => $_POST['telefon'],
            'fax' => $_POST['fax'],
            'email' => $_POST['email'],
            'konum' => $_POST['konum'],
            'aktif' => $_POST['aktif'],
            'gorsel' => $benzersizad
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
                'islem' => 'Yeni şube ekleme',
                'adi' => $userName,
                'icerik' => ucfirst($adi),
                'uye_id' => $userID
            ));
            
            #Log kaydetme işlemi başarılı ise geri dön
            if($saveLog){
                Header("Location: ../../views/subeler?statu=ok");
            }else{
                Header("Location: ../../views/subeler?statu=logNo");
            }

            
        } else {

            Header("Location: ../../views/subeler?statu=no");
        }
    }catch (PDOException $e) {
        echo $e->getMessage();
    }
    

 }


 #içerik düzenleme
 if ( isset($_POST['edit']) ) { 
   
    $adi = $_POST['adi'];
    $oldImage = $_POST['old-image'];
    $id = $_POST['id'];

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
        $benzersizad = $resimadi . "-sube-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad2 = "t1-" . $resimadi . "-sube-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;
        $benzersizad3 = "t2-" . $resimadi . "-sube-" . $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . "." . $uzanti;

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
        $savePage = $db->prepare("UPDATE tbl_sube SET
            adi= :adi,
            adres= :adres,
            telefon= :telefon,
            fax= :fax,
            email= :email,
            konum= :konum,
            aktif= :aktif,
            gorsel= :gorsel
            WHERE id= :id
        ");
            
        $savePage->execute(array(

            'adi' => $_POST['adi'],
            'adres' => $_POST['adres'],
            'telefon' => $_POST['telefon'],
            'fax' => $_POST['fax'],
            'email' => $_POST['email'],
            'konum' => $_POST['konum'],
            'aktif' => $_POST['aktif'],
            'gorsel' => $benzersizad,
            'id' => $id
        ));

        #Kayıt edilen verinin ID sini çek
        $contentID = $id;

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
                'islem' => 'Şube güncelleme',
                'adi' => $userName,
                'icerik' => $adi,
                'uye_id' => $userID
            ));
            
            #Log kaydetme işlemi başarılı ise geri dön
            if($saveLog){
                Header("Location: ../../views/subeler?statu=ok");
            }else{
                Header("Location: ../../views/subeler?statu=logNo");
            }

            
        } else {

            Header("Location: ../../views/subeler?statu=no");
        }
    }catch (PDOException $e) {
        echo $e->getMessage();
    }
    

}

//silme işlemi
if ($_GET["perform"] == "delete") {
    
    $contentID = $_GET["id"];
    $adi = $_GET["adi"];
    
    $delete = $db->exec("DELETE from tbl_sube where id = $contentID");

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
            'islem' => 'Şube silme',
            'adi' => $userName,
            'icerik' => $adi,
            'uye_id' => $userID
        ));
        
        #Log kaydetme işlemi başarılı ise geri dön
        if($saveLog){
            Header("Location: ../../views/subeler?statu=ok");
        }else{
            Header("Location: ../../views/subeler?statu=logNo");
        }

    }else{
        header("Location: ../../views/subeler?statu=no");
    }

}

if(isset($_POST['sort'])){
   
    $items = $_POST['sort'];

    foreach ($items as $sira => $id  ) {
        
         #Database kaydı
         $save = $db->prepare("UPDATE tbl_sube SET sira= :sira WHERE id=$id");
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
