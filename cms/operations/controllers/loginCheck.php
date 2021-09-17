<?php

ob_start();

include('../../../connection/connect.php');

if (isset($_POST['loginCheck'])) {
    $userName = $_POST['username'];
    $userPassword = md5(md5(md5($_POST['password'])));
    $session  = $_POST['session'];

    #User kontrol
    $checkUser = $db->query("SELECT * FROM tbl_admin WHERE kullanici='$userName' and sifre='$userPassword'")->fetch(PDO::FETCH_ASSOC);
  
    #User kontrol başarılı ise:
    if ($checkUser) {

        $checkSite = $db->query("SELECT * FROM tbl_site WHERE id=1 ")->fetch(PDO::FETCH_ASSOC);

        #Sitenin türkçe dili aktif ise $_COOKIE['turkish'] global değişkeni ata
        if ($checkSite['turkce'] == 1) {
            setcookie("turkish", "on", time() + 31556926, '/');
        }

        #Sitenin ingilizce dili aktif ise $_COOKIE['engilish'] global değişkeni ata
        if ($checkSite['ingilizce'] == 1) {
            setcookie("english", "on", time() + 31556926, '/');
        }

        #Sitenin ispantolca dili aktif ise $_COOKIE['spanish'] global değişkeni ata
        if ($checkSite['ispanyolca'] == 1) {
            setcookie("spanish", "on", time() + 31556926, '/');
        }

        #Sitenin fransızca dili aktif ise $_COOKIE['french'] global değişkeni ata
        if ($checkSite['fransizca'] == 1) {
            setcookie("french", "on", time() + 31556926, '/');
        }

        #Sitenin arapça dili aktif ise $_COOKIE['arabic'] global değişkeni ata
        if ($checkSite['arapca'] == 1) {
            setcookie("arabic", "on", time() + 31556926, '/');
        }

        #Oturum açık kalsın işaretlenmiş ise:
        if ($session == "checked") {
            setcookie("loggedUser", "ok", time() + 31556926, '/');
            setcookie("authorization", $checkUser['rol'], time() + 31556926, '/');
            setcookie("userName", $checkUser['adi'], time() + 31556926, '/');
            setcookie("userID", $checkUser['id'], time() + 31556926, '/');
            setcookie("userImg", $checkUser['gorsel'], time() + 31556926, '/');
            setcookie("userTitle", $checkUser['unvan'], time() + 31556926, '/');
            setcookie("authPage", $checkUser['y_sayfa'], time() + 31556926, '/');
            setcookie("authCont", $checkUser['y_icerik'], time() + 31556926, '/');
            setcookie("authSetting", $checkUser['y_site'], time() + 31556926, '/');

            header("Location:../../views/index");

        } else {

            #Oturum açık kalsın işaretlenmemiş ise:
            setcookie("loggedUser", "ok", time() + 3600,'/');
            setcookie("authorization", $checkUser['rol'], time() + 3600,'/');
            setcookie("userName", $checkUser['adi'], time() + 3600,'/');
            setcookie("userID", $checkUser['id'], time() + 3600,'/');
            setcookie("userImg", $checkUser['resim'], time() + 3600,'/');
            setcookie("userTitle", $checkUser['unvan'], time() + 3600,'/');
            setcookie("authPage", $checkUser['y_sayfa'], time() + 3600, '/');
            setcookie("authCont", $checkUser['y_icerik'], time() + 3600, '/');
            setcookie("authSetting", $checkUser['y_site'], time() + 3600, '/');

            header("Location:../../views/index");
        }

    } else {

        #User name yada user password boş ise
        if ($userName=NULL or $userPassword=NULL) {

            header("Location:../../views/index?err=1");

        #User name yada user password boş ise
        } else {
            header("Location:../../views/index?err=1");
        }
    }
};
