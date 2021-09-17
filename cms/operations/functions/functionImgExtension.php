 
<?php

#Resim uzantısını bulma fonksiyonu
function extens($file)
{
    $ext = pathinfo($file);
    return $ext['extension'];
} 

 ?> 