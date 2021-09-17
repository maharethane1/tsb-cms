<?php

ob_start();

include('../../../connection/connect.php');

#Log kayıtları için dataları değişkene aktar
$performName = "E-mail ayarları";
$userName = $_COOKIE['userName'];
$userID = $_COOKIE['userID'];


#cozumler sayfa içerik kaydetme
if (isset($_POST['update'])) {
    
    try {
        #Database kaydı
        $savePage = $db->prepare("UPDATE tbl_site SET

        php_email_smtp=:php_email_smtp,
        php_email_port=:php_email_port,
        php_email_adres=:php_email_adres,
        php_email_sifre=:php_email_sifre,
        php_email_guvenlik=:php_email_guvenlik
        
        WHERE id=1

        ");

        $savePage->execute(array(
            'php_email_smtp' => $_POST['php_email_smtp'],
            'php_email_port' => $_POST['php_email_port'],
            'php_email_adres' => $_POST['php_email_adres'],
            'php_email_sifre' => $_POST['php_email_sifre'],
            'php_email_guvenlik' => $_POST['php_email_guvenlik']

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
                'islem' => 'E-mail ayarları güncelleme',
                'adi' => $userName,
                'icerik' => $adi,
                'uye_id' => $userID
            ));

            #Log kaydetme işlemi başarılı ise geri dön
            if ($saveLog) {
                Header("Location: ../../views/email-ayarlari?statu=ok");
            } else {
                Header("Location: ../../views/email-ayarlari?statu=logNo");
            }
        } else {

            Header("Location: ../../views/email-ayarlari?statu=no");
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

ob_flush();

$db = null;
