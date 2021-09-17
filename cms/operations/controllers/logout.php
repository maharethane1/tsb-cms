<?php

ob_start();

include('../../connection/connect.php');

#Set edilmiş cookieleri değişkene atama
$loggedUser = $_COOKIE['loggedUser'];
$authorization = $_COOKIE['authorization'];
$userName = $_COOKIE['userName'];
$userID = $_COOKIE['userID'];
$userImg = $_COOKIE['userImg'];
$userTitle = $_COOKIE['userTitle'];
$langEnglish = $_COOKIE['english'];
$langTurkish = $_COOKIE['turkish'];
$langGermany = $_COOKIE['germany'];
$langSpanish = $_COOKIE['spanish'];
$langFrench  = $_COOKIE['french'];
$langArabic  = $_COOKIE['arabic'];
$authorization = $_COOKIE['authorization'];
$authPage = $_COOKIE['authPage'];
$authCont = $_COOKIE['authCont'];
$authSetting = $_COOKIE['authSetting'];


#Set edilmiş cookieleri silme
unset($_COOKIE['loggedUser']);
unset($_COOKIE['authorization']);
unset($_COOKIE['userName']);
unset($_COOKIE['userID']);
unset($_COOKIE['userImg']);
unset($_COOKIE['userTitle']);
unset($_COOKIE['english']);
unset($_COOKIE['turkish']);
unset($_COOKIE['germany']);
unset($_COOKIE['spanish']);
unset($_COOKIE['french']);
unset($_COOKIE['arabic']);
unset($_COOKIE['authorization']);
unset($_COOKIE['authPage']);
unset($_COOKIE['authCont']);
unset($_COOKIE['authSetting']);

#Silme işleminin başarısız olma ihtimaline karşı zaman ayarlarıyla sime
setcookie("loggedUser", "ok", time() - 31556926, '/');
setcookie("authorization", $authorization, time() - 31556926, '/');
setcookie("userName", $userName, time() - 31556926, '/');
setcookie("userID", $userID, time() - 31556926, '/');
setcookie("userImg", $userImg, time() - 31556926, '/');
setcookie("userTitle", $userTitle, time() - 31556926, '/');
setcookie("english", $langEnglish, time() - 31556926, '/');
setcookie("turkish", $langTurkish, time() - 31556926, '/');
setcookie("spanish", $langSpanish, time() - 31556926, '/');
setcookie("french", $langFrench, time() - 31556926, '/');
setcookie("germany", $langGermany, time() - 31556926, '/');
setcookie("arabic", $langArabic, time() - 31556926, '/');
setcookie("authorization", $authorization, time() - 31556926, '/');
setcookie("authPage", $authPage, time() - 31556926, '/');
setcookie("authCont", $authCont, time() - 31556926, '/');
setcookie("authSetting", $authSetting, time() - 31556926, '/');

header('Cache-Control', 'nocache, no-store, max-age=0, must-revalidate');
header('Pragma', 'no-cache');
header('Expires', 'Sat 01 Jan 1990 00:00:00 GMT');
 
header("Location: ../../views/auth/login?err=4");


?>

