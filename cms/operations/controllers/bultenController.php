<?php

ob_start();

include('../../../connection/connect.php');

#Log kayıtları için dataları değişkene aktar
$performName = "Bülten ayarları";
$userName = $_COOKIE['userName'];
$userID = $_COOKIE['userID'];


#cozumler sayfa içerik kaydetme
if (isset($_POST['update'])) {
    
    $id = $_POST['id'];

    try {
        #Database kaydı
        $savePage = $db->prepare("UPDATE tbl_email SET

        email=:email,
        durum=:durum
        WHERE id=$id

        ");

        $savePage->execute(array(
            'email' => $_POST['email'],
            'durum' => $_POST['durum']
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
                'islem' => 'Ayarlar güncellendi',
                'adi' => $userName,
                'icerik' => $adi,
                'uye_id' => $userID
            ));

            #Log kaydetme işlemi başarılı ise geri dön
            if ($saveLog) {
                Header("Location: ../../views/bulten-ayarlari?statu=ok");
            } else {
                Header("Location: ../../views/bulten-ayarlari?statu=logNo");
            }
        } else {

            Header("Location: ../../views/bulten-ayarlari?statu=no");
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if ( $_GET['perform'] == "delete") { 
    
    $contentID = $_GET["id"];

    $get = $db->prepare("SELECT * FROM tbl_email WHERE id=$contentID");
    $get->execute();
    $getData = $get->fetch(PDO::FETCH_ASSOC);

    $adi = $getData['email'];
    
    $delete = $db->exec("DELETE from tbl_email where id = $contentID");

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
            Header("Location: ../../views/bulten-ayarlari?statu=ok");
        }else{
            Header("Location: ../../views/bulten-ayarlari?statu=logNo");
        }

        if($saveLog) {
            header("Location: ../../views/bulten-ayarlari?statu=ok");
        }else{
            header("Location: ../../views/bulten-ayarlari?statu=logNo");
        }

    }else{
        header("Location: ../../views/bulten-ayarlari?statu=no");
    }
 }

ob_flush();

$db = null;
