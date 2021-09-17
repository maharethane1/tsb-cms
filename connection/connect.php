<?php

date_default_timezone_set('Europe/Istanbul');
#Database bağlantı bilgiler
$servername = "localhost";
$database = "tsb";
$username = "root";
$password = "root";

#Database bağlantısı
try {
    $db = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", "$username", "$password");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    #Bağlantı başarılı
    #echo "Bağlantı başarılı";

} catch (PDOException $e) {

    #Bağlantı hatası
    echo "Bir Hata Oluştu: " . $e->getMessage();
}

?> 