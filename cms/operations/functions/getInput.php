<?php 


// input değerleri boş string olarak dönüyorsa NULL atama fonksiyonu
function getInput($inputName){

    if(isset($_POST[$inputName])){

        if(empty($_POST[$inputName])){
            return $input = NULL;
        }

        $input = $_POST[$inputName];

    }else{
       return $input = NULL;
    }
    return $input;
}


function saveImage($inputName, $i)
{
    $portfolioId = $_POST['portfolio_id'];
    $compId = $_POST['comp_id'];
    $oldImage = $_POST['old-image'][$i];

    if(isset($_FILES[$inputName])){

        if($_FILES[$inputName]['size'][$i]>0){
            
            $uploads_dir = '../../../uploads/';
        
            ${"tmp_name$i"} = $_FILES[$inputName]["tmp_name"][$i];
            ${"resimadi$i"} = "portfolioid-".$portfolioId."-compid-".$compId;
            ${"dosya$i"} = $_FILES[$inputName]["name"][$i];
            ${"uzanti$i"} = extens(${"dosya$i"});
            
            #Benzersiz oluşturma
            ${"benzersizsayi1$i"} = rand(20000, 32000);
            ${"benzersizsayi2$i"} = rand(20000, 32000);
            ${"benzersizsayi3$i"} = rand(20000, 32000);
            ${"benzersizad$i"} = ${"resimadi$i"} . ${"benzersizsayi1$i"} . ${"benzersizsayi2$i"} . ${"benzersizsayi3$i"} . "." . ${"uzanti$i"};
            ${"benzersizad2$i"} = "t1-" . ${"resimadi$i"} . ${"benzersizsayi1$i"} . ${"benzersizsayi2$i"} . ${"benzersizsayi3$i"} . "." . ${"uzanti$i"};
            ${"benzersizad3$i"} = "t2-" . ${"resimadi$i"} . ${"benzersizsayi1$i"} . ${"benzersizsayi2$i"} . ${"benzersizsayi3$i"} . "." . ${"uzanti$i"};
            
            #thumbnail
            $image = new SimpleImage();
            $image->load($_FILES[$inputName]['tmp_name'][$i]);
            $image->resizeToWidth(500);
            $image->save("$uploads_dir/${"benzersizad2$i"}");
            $image = new SimpleImage();
            $image->load($_FILES[$inputName]['tmp_name'][$i]);
            $image->resizeToWidth(1000);
            $image->save("$uploads_dir/${"benzersizad3$i"}");
            
            @move_uploaded_file(${"tmp_name$i"}, "$uploads_dir/${"benzersizad$i"}");

            return ${"benzersizad$i"};
            exit;
        }

    }

    ${"benzersizad$i"} = $oldImage;

    return ${"benzersizad$i"};

}

function uploadImage($filename, $inputName, $i)
{
    if(isset($_FILES[$inputName])){

        if($_FILES[$inputName]['size'][$i]>0){
            
            $uploads_dir = '../../../uploads/';
        
            ${"tmp_name$i"} = $_FILES[$inputName]["tmp_name"][$i];
            ${"resimadi$i"} = $filename;
            ${"dosya$i"} = $_FILES[$inputName]["name"][$i];
            ${"uzanti$i"} = extens(${"dosya$i"});
            
            #Benzersiz oluşturma
            ${"benzersizsayi1$i"} = rand(20000, 32000);
            ${"benzersizsayi2$i"} = rand(20000, 32000);
            ${"benzersizsayi3$i"} = rand(20000, 32000);
            ${"benzersizad$i"} = ${"resimadi$i"} . ${"benzersizsayi1$i"} . ${"benzersizsayi2$i"} . ${"benzersizsayi3$i"} . "." . ${"uzanti$i"};
            ${"benzersizad2$i"} = "t1-" . ${"resimadi$i"} . ${"benzersizsayi1$i"} . ${"benzersizsayi2$i"} . ${"benzersizsayi3$i"} . "." . ${"uzanti$i"};
            ${"benzersizad3$i"} = "t2-" . ${"resimadi$i"} . ${"benzersizsayi1$i"} . ${"benzersizsayi2$i"} . ${"benzersizsayi3$i"} . "." . ${"uzanti$i"};
            
            #thumbnail
            $image = new SimpleImage();
            $image->load($_FILES[$inputName]['tmp_name'][$i]);
            $image->resizeToWidth(500);
            $image->save("$uploads_dir/${"benzersizad2$i"}");
            $image = new SimpleImage();
            $image->load($_FILES[$inputName]['tmp_name'][$i]);
            $image->resizeToWidth(1000);
            $image->save("$uploads_dir/${"benzersizad3$i"}");
            
            @move_uploaded_file(${"tmp_name$i"}, "$uploads_dir/${"benzersizad$i"}");

            return ${"benzersizad$i"};
            exit;
        }

    }

    ${"benzersizad$i"} = "noimage.jpg";

    return ${"benzersizad$i"};

}

function editImage($filename, $inputName, $i)
{
    $oldImage = $_POST['old-image'][$i];

    if(isset($_FILES[$inputName])){

        if($_FILES[$inputName]['size'][$i]>0){
            
            $uploads_dir = '../../../uploads/';
        
            ${"tmp_name$i"} = $_FILES[$inputName]["tmp_name"][$i];
            ${"resimadi$i"} = $filename;
            ${"dosya$i"} = $_FILES[$inputName]["name"][$i];
            ${"uzanti$i"} = extens(${"dosya$i"});
            
            #Benzersiz oluşturma
            ${"benzersizsayi1$i"} = rand(20000, 32000);
            ${"benzersizsayi2$i"} = rand(20000, 32000);
            ${"benzersizsayi3$i"} = rand(20000, 32000);
            ${"benzersizad$i"} = ${"resimadi$i"}. ${"benzersizsayi1$i"} . ${"benzersizsayi2$i"} . ${"benzersizsayi3$i"} . "." . ${"uzanti$i"};
            ${"benzersizad2$i"} = "t1-" . ${"resimadi$i"} . ${"benzersizsayi1$i"} . ${"benzersizsayi2$i"} . ${"benzersizsayi3$i"} . "." . ${"uzanti$i"};
            ${"benzersizad3$i"} = "t2-" . ${"resimadi$i"} . ${"benzersizsayi1$i"} . ${"benzersizsayi2$i"} . ${"benzersizsayi3$i"} . "." . ${"uzanti$i"};
            
            #thumbnail
            $image = new SimpleImage();
            $image->load($_FILES[$inputName]['tmp_name'][$i]);
            $image->resizeToWidth(500);
            $image->save("$uploads_dir/${"benzersizad2$i"}");
            $image = new SimpleImage();
            $image->load($_FILES[$inputName]['tmp_name'][$i]);
            $image->resizeToWidth(1000);
            $image->save("$uploads_dir/${"benzersizad3$i"}");
            
            @move_uploaded_file(${"tmp_name$i"}, "$uploads_dir/${"benzersizad$i"}");

            return ${"benzersizad$i"};
            exit;
        }

    }

    ${"benzersizad$i"} = $oldImage;

    return ${"benzersizad$i"};

}

?>