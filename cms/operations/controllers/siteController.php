<?php

ob_start();

include('../../../connection/connect.php');

#Log kayıtları için dataları değişkene aktar
$performName = "Site ayarları";
$userName = $_COOKIE['userName'];
$userID = $_COOKIE['userID'];


#cozumler sayfa içerik kaydetme
if (isset($_POST['update'])) {
    
    try {
        #Database kaydı
        $savePage = $db->prepare("UPDATE tbl_site SET

        site_baslik=:site_baslik,
        site_aciklama=:site_aciklama,
        site_aciklama=:site_aciklama,
        link=:link,
        google_analytic=:google_analytic,
        turkce=:turkce,
        ingilizce=:ingilizce,
        fransizca=:fransizca,
        ispanyolca=:ispanyolca,
        arapca=:arapca
        WHERE id=1

        ");

        $savePage->execute(array(
            'site_baslik' => ucfirst($_POST['site_baslik']),
            'site_aciklama' => ucfirst($_POST['site_aciklama']),
            'link' => $_POST['link'],
            'site_etiket' => $_POST['site_etiket'],
            'google_analytic' => $_POST['google_analytic'],
            'turkce' => $_POST['turkce'],
            'ingilizce' => $_POST['ingilizce'],
            'fransizca' => $_POST['fransizca'],
            'ispanyolca' => $_POST['ispanyolca'],
            'arapca' => $_POST['arapca']

        ));

        #Kayıt edilen verinin ID sini çek
        $contentID = 1;

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
                Header("Location: ../../views/site-ayarlari?statu=ok");
            } else {
                Header("Location: ../../views/site-ayarlari?statu=logNo");
            }
        } else {

            Header("Location: ../../views/site-ayarlari?statu=no");
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

ob_flush();

$db = null;
