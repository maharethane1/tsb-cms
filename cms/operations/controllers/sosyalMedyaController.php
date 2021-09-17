<?php

ob_start();

include('../../../connection/connect.php');

#Log kayıtları için dataları değişkene aktar
$performName = "Sosyal medya ayarları";
$userName = $_COOKIE['userName'];
$userID = $_COOKIE['userID'];


#cozumler sayfa içerik kaydetme
if (isset($_POST['update'])) {
    
    try {
        #Database kaydı
        $savePage = $db->prepare("UPDATE tbl_site SET

        facebook=:facebook,
        instagram=:instagram,
        twitter=:twitter,
        youtube=:youtube,
        linkedin=:linkedin,
        behance=:behance,
        vimeo=:vimeo
        
        WHERE id=1

        ");

        $savePage->execute(array(
            'facebook' => $_POST['facebook'],
            'instagram' => $_POST['instagram'],
            'twitter' => $_POST['twitter'],
            'youtube' => $_POST['youtube'],
            'linkedin' => $_POST['linkedin'],
            'behance' => $_POST['behance'],
            'vimeo' => $_POST['vimeo']

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
                'islem' => 'Sosyal medya ayarları güncelleme',
                'adi' => $userName,
                'icerik' => "-",
                'uye_id' => $userID
            ));

            #Log kaydetme işlemi başarılı ise geri dön
            if ($saveLog) {
                Header("Location: ../../views/sosyal-medya-ayarlari?statu=ok");
            } else {
                Header("Location: ../../views/sosyal-medya-ayarlari?statu=logNo");
            }
        } else {

            Header("Location: ../../views/sosyal-medya-ayarlari?statu=no");
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

ob_flush();

$db = null;
