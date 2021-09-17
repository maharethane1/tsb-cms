<?php 

#Türkçe karakter temizleme fonksiyonu
function temizle($tr1) {
    $turkce=array("ş","Ş","ı","ü","Ü","ö","Ö","ç","Ç","ş","Ş","ı","ğ","Ğ","İ","ö","Ö","Ç","ç","ü","Ü");
    $duzgun=array("s","S","i","u","U","o","O","c","C","s","S","i","g","G","I","o","O","C","c","u","U");
    $tr1=str_replace($turkce,$duzgun,$tr1);
    $tr1 = preg_replace("@[^a-z0-9\-_şıüğçİŞĞÜÇ]+@i","-",$tr1);
    $tr1 = strtolower($tr1);
    return $tr1;
    }
    
?>