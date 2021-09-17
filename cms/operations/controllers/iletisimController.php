<?php

ob_start();

include('../../../connection/connect.php');

#Log kayıtları için dataları değişkene aktar
$performName = "İletişim ayarları";
$userName = $_COOKIE['userName'];
$userID = $_COOKIE['userID'];


#cozumler sayfa içerik kaydetme
if (isset($_POST['update'])) {
    
    try {
        #Database kaydı
        $savePage = $db->prepare("UPDATE tbl_site SET

        email=:email,
        telefon=:telefon,
        gsm=:gsm,
        fax=:fax,
        adres=:adres
        WHERE id=1

        ");

        $savePage->execute(array(
            'email' => $_POST['email'],
            'telefon' => $_POST['telefon'],
            'gsm' => $_POST['gsm'],
            'fax' => $_POST['fax'],
            'adres' => $_POST['adres']

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
                'islem' => 'İletişim ayarları güncelleme',
                'adi' => $userName,
                'icerik' => $adi,
                'uye_id' => $userID
            ));

            #Log kaydetme işlemi başarılı ise geri dön
            if ($saveLog) {
                Header("Location: ../../views/iletisim-ayarlari?statu=ok");
            } else {
                Header("Location: ../../views/iletisim-ayarlari?statu=logNo");
            }
        } else {

            Header("Location: ../../views/iletisim-ayarlari?statu=no");
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

ob_flush();

$db = null;
