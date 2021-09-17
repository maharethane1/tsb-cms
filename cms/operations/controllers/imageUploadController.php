<?php

ob_start();

include('../../../connection/connect.php');
include('../functions/functionImgSizer.php');
include('../functions/functionImgExtension.php');
include('../functions/clearCharacter.php');

#Log kayıtları için dataları değişkene aktar

$userName = $_COOKIE['userName'];
$userID = $_COOKIE['userID'];

//galeri toplu resim yükleme (tüm sayfalardan yüklenen resimleri gönderilen parametrelere göre dinamik kayıt eder)
if ( isset($_POST['imageUpload']) ) {

    $performName = $_POST['performName'];
    $pageName = $_POST['pageName'];
    $columnName = $_POST['columnName'];
    $contentID = $_POST['contentID'];
    $adi = ucfirst($pageName)." Görsel İçerik ID: ".$contentID;

    $arr_file_types = ['image/png', 'image/gif', 'image/jpg', 'image/jpeg'];

    if (!(in_array($_FILES['file']['type'], $arr_file_types))) {
        echo "false";
        return;
    }

    $uploads_dir = '../../../uploads/';
    @$tmp_name = $_FILES['file']["tmp_name"];
    @$dosya = $_FILES['file']["name"];
    @$dosyaadi = "galeri-gorsel-icerik-id-".$contentID;
    @$uzanti = extens($dosya);

    #resmin isminin benzersiz olması
    $benzersizsayi1 = rand(20000, 32000);
    $benzersizsayi2 = rand(20000, 32000);
    $benzersizsayi3 = rand(20000, 32000);
    $benzersizad=$pageName."-".$dosyaadi."-".$benzersizsayi1.$benzersizsayi2.$benzersizsayi3.".".$uzanti;
    @move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad");

    $saveImage = $db->prepare("INSERT INTO tbl_galeri ($columnName, gorsel) VALUES (?, ?) ");
    $saveImage->execute(array($contentID, $benzersizad));

    #Kayıt edilen verinin ID sini çek
    $imgID = $db->lastInsertId();

    if ($saveImage) {

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
            'islem_id' => $imgID,
            'sayfa' => ucfirst($pageName)." Yönetimi",
            'islem' => 'Detay resmi ekleme',
            'adi' => $userName,
            'icerik' => $adi,
            'uye_id' => $userID,
            'tarih' => date("Y-m-d H:i:s")
        ));

        $response = '
        <div class="col-md-3 animated fadeIn">
            <div class="options-container fx-item-zoom-in fx-overlay-zoom-in" style=" height: 200px; background-image: url(../../uploads/'.$benzersizad.'); background-size: cover;">
                <div class="options-overlay bg-black-op">
                    <div class="options-overlay-content">
                        <a class="btn btn-sm btn-rounded btn-alt-danger min-width-75" href="../operations/controllers/imageUploadController?perform=deleteImage&id='.$imgID.'&contentID='.$contentID.'&pageName='.$pageName.'">
                            <i class="fa fa-times"></i> Sil
                        </a>
                    </div>
                </div>
            </div>
        </div>';

        echo $response;
    }
 }
 

#Galeri resim silme
if ($_GET["perform"] == "deleteImage") {

    $imgID = $_GET["id"];
    $contentID = $_GET["contentID"];
    $pageName = $_GET['pageName'];
    $adi = ucfirst($pageName)." Görsel İçerik ID: ".$contentID;

    $delete = $db->exec("DELETE FROM tbl_galeri WHERE id= $imgID ");

    if ( $delete ) { 

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
            'islem_id' => $imgID,
            'sayfa' => ucfirst($pageName)." Yönetimi",
            'islem' => 'Detay resmi silme',
            'adi' => $userName,
            'icerik' => $adi,
            'uye_id' => $userID,
            'tarih' => date("Y-m-d H:i:s")
        ));

        #Log kaydetme işlemi başarılı ise geri dön
        if($saveLog){

            Header("Location: ../../views/$pageName?perform=foto&id=".$contentID."&statu=ok&pageName=$pageName");

        }else{

            Header("Location: ../../views/$pageName?perform=foto&id=".$contentID."&statu=logNo&pageName=$pageName");

        }

     }else{

        Header("Location: ../../views/$pageName?perform=foto&id=".$contentID."&statu=no&pageName=$pageName");

     }

}

ob_flush();

$db = null;

?>
