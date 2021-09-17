<?php

ob_start();

include('../../../connection/connect.php');
include('../functions/functionImgSizer.php');
include('../functions/functionImgExtension.php');
include('../functions/clearCharacter.php');
include('../functions/getInput.php');

#Log kayıtları için dataları değişkene aktar
$performName = "Portfolio Bileşen Yönetimi";
$userName = $_COOKIE['userName'];
$userID = $_COOKIE['userID'];

#içerik kaydetme
if (isset($_POST['addComp'])) {

    $portfolioId = $_POST['portfolio_id'];
    $compId = $_POST['comp_id'];

    $baslik_1_tr   = getInput('baslik_1_tr');
    $baslik_2_tr   = getInput('baslik_2_tr');
    $baslik_3_tr   = getInput('baslik_3_tr');
    $baslik_1_en   = getInput('baslik_1_en');
    $baslik_2_en   = getInput('baslik_2_en');
    $baslik_3_en   = getInput('baslik_3_en');
    $aciklama_1_tr = getInput('aciklama_1_tr');
    $aciklama_2_tr = getInput('aciklama_2_tr');
    $aciklama_3_tr = getInput('aciklama_3_tr');
    $aciklama_1_en = getInput('aciklama_1_en');
    $aciklama_2_en = getInput('aciklama_2_en');
    $aciklama_3_en = getInput('aciklama_3_en');
    $link_1_tr     = getInput('link_1_tr');
    $link_2_tr     = getInput('link_2_tr');
    $link_3_tr     = getInput('link_3_tr');
    $link_1_en     = getInput('link_1_en');
    $link_2_en     = getInput('link_2_en');
    $link_3_en     = getInput('link_3_en');
    $aktif         = getInput('aktif');

    $adi = "Bileşen $compId";

    if($_FILES['resim']['size']>0){

        #Dosya yükleme yolu belirleme ve dosya adı temizleme
        $uploads_dir = '../../../uploads/';
        
        $fileCount = count($_FILES['resim']['name']);

        for ($i=0; $i<$fileCount; $i++) {   

            @${"tmp_name$i"} = $_FILES['resim']["tmp_name"][$i];
            @${"resimadi$i"} = "portfolioid-".$portfolioId."-compid-".$compId;
            @${"dosya$i"} = $_FILES['resim']["name"][$i];
            @${"uzanti$i"} = extens(${"dosya$i"});

            #Benzersiz oluşturma
            ${"benzersizsayi1$i"} = rand(20000, 32000);
            ${"benzersizsayi2$i"} = rand(20000, 32000);
            ${"benzersizsayi3$i"} = rand(20000, 32000);
            ${"benzersizad$i"} = ${"resimadi$i"} . "-portfolio-" . ${"benzersizsayi1$i"} . ${"benzersizsayi2$i"} . ${"benzersizsayi3$i"} . "." . ${"uzanti$i"};
            ${"benzersizad2$i"} = "t1-" . ${"resimadi$i"} . "-portfolio-" . ${"benzersizsayi1$i"} . ${"benzersizsayi2$i"} . ${"benzersizsayi3$i"} . "." . ${"uzanti$i"};
            ${"benzersizad3$i"} = "t2-" . ${"resimadi$i"} . "-portfolio-" . ${"benzersizsayi1$i"} . ${"benzersizsayi2$i"} . ${"benzersizsayi3$i"} . "." . ${"uzanti$i"};
            
            #thumbnail
            $image = new SimpleImage();
            $image->load($_FILES['resim']['tmp_name'][$i]);
            $image->resizeToWidth(500);
            $image->save("$uploads_dir/${"benzersizad2$i"}");
            $image = new SimpleImage();
            $image->load($_FILES['resim']['tmp_name'][$i]);
            $image->resizeToWidth(1000);
            $image->save("$uploads_dir/${"benzersizad3$i"}");

            @move_uploaded_file(${"tmp_name$i"}, "$uploads_dir/${"benzersizad$i"}");


        }

    }
        
    try
    {
        $savePage = $db->prepare("INSERT INTO tbl_portfolio_comp SET

            portfolio_id= :portfolio_id,
            baslik_1_tr = :baslik_1_tr,
            baslik_2_tr = :baslik_2_tr,
            baslik_3_tr = :baslik_3_tr,
            baslik_1_en = :baslik_1_en,
            baslik_2_en = :baslik_2_en,
            baslik_3_en = :baslik_3_en,
            aciklama_1_tr = :aciklama_1_tr,
            aciklama_2_tr = :aciklama_2_tr,
            aciklama_3_tr = :aciklama_3_tr,
            aciklama_1_en = :aciklama_1_en,
            aciklama_2_en = :aciklama_2_en,
            aciklama_3_en = :aciklama_3_en,
            link_1_tr = :link_1_tr,
            link_2_tr = :link_2_tr,
            link_3_tr = :link_3_tr,
            link_1_en = :link_1_en,
            link_2_en = :link_2_en,
            link_3_en = :link_3_en,
            gorsel_1 = :gorsel_1,
            gorsel_2 = :gorsel_2,
            gorsel_3 = :gorsel_3,
            gorsel_4 = :gorsel_4,
            gorsel_5 = :gorsel_5,
            gorsel_6 = :gorsel_6,
            gorsel_7 = :gorsel_7,
            comp = :comp,
            aktif = :aktif
            
        ");

        $savePage->execute(array(

            'portfolio_id'  => $portfolioId,
            'baslik_1_tr'   => $baslik_1_tr,
            'baslik_2_tr'   => $baslik_2_tr,
            'baslik_3_tr'   => $baslik_3_tr,
            'baslik_1_en'   => $baslik_1_en,
            'baslik_2_en'   => $baslik_2_en,
            'baslik_3_en'   => $baslik_3_en,
            'aciklama_1_tr' => $aciklama_1_tr,
            'aciklama_2_tr' => $aciklama_2_tr,
            'aciklama_3_tr' => $aciklama_3_tr,
            'aciklama_1_en' => $aciklama_1_en,
            'aciklama_2_en' => $aciklama_2_en,
            'aciklama_3_en' => $aciklama_3_en,
            'link_1_tr'     => $link_1_tr,
            'link_2_tr'     => $link_2_tr,
            'link_3_tr'     => $link_3_tr,
            'link_1_en'     => $link_1_en,
            'link_2_en'     => $link_2_en,
            'link_3_en'     => $link_3_en,
            'gorsel_1'      => $benzersizad0 ?? NULL,
            'gorsel_2'      => $benzersizad1 ?? NULL,
            'gorsel_3'      => $benzersizad2 ?? NULL,
            'gorsel_4'      => $benzersizad3 ?? NULL,
            'gorsel_5'      => $benzersizad4 ?? NULL,
            'gorsel_6'      => $benzersizad5 ?? NULL,
            'gorsel_7'      => $benzersizad6 ?? NULL,
            'comp'          => $compId,
            'aktif'         => $aktif
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
                'islem' => 'Yeni portfolio bileşeni ekleme',
                'adi' => $userName,
                'icerik' => $adi,
                'uye_id' => $userID
            ));

            #Log kaydetme işlemi başarılı ise geri dön
            if ($saveLog) {
                Header("Location: ../../views/portfolio?perform=sortComp&id=".$portfolioId."&statu=ok");
            } else {
                Header("Location: ../../views/portfolio?perform=sortComp&id=".$portfolioId."&statu=logNo");
            }
        } else {

            Header("Location: ../../views/portfolio?perform=sortComp&id=".$portfolioId."&statu=no");
        }
    }catch (PDOException $e) {
        echo $e->getMessage();
    }
    
}

#içerik kaydetme
if (isset($_POST['editComp'])) {
    
    $portfolioId = $_POST['portfolio_id'];
    $compId = $_POST['comp_id'];
    $id = $_POST['id'];
    

    $baslik_1_tr   = getInput('baslik_1_tr');
    $baslik_2_tr   = getInput('baslik_2_tr');
    $baslik_3_tr   = getInput('baslik_3_tr');
    $baslik_1_en   = getInput('baslik_1_en');
    $baslik_2_en   = getInput('baslik_2_en');
    $baslik_3_en   = getInput('baslik_3_en');
    $aciklama_1_tr = getInput('aciklama_1_tr');
    $aciklama_2_tr = getInput('aciklama_2_tr');
    $aciklama_3_tr = getInput('aciklama_3_tr');
    $aciklama_1_en = getInput('aciklama_1_en');
    $aciklama_2_en = getInput('aciklama_2_en');
    $aciklama_3_en = getInput('aciklama_3_en');
    $link_1_tr     = getInput('link_1_tr');
    $link_2_tr     = getInput('link_2_tr');
    $link_1_en     = getInput('link_1_en');
    $link_2_en     = getInput('link_2_en');
    $aktif         = getInput('aktif');

    $adi = "Bileşen $compId";
    
    $benzersizad0 = saveImage("resim", 0);
    $benzersizad1 = saveImage("resim", 1);
    $benzersizad2 = saveImage("resim", 2);
    $benzersizad3 = saveImage("resim", 3);
    $benzersizad4 = saveImage("resim", 4);
    $benzersizad5 = saveImage("resim", 5);
    $benzersizad6 = saveImage("resim", 6);
        
    try
    {
        $savePage = $db->prepare("UPDATE tbl_portfolio_comp SET

            portfolio_id= :portfolio_id,
            baslik_1_tr = :baslik_1_tr,
            baslik_2_tr = :baslik_2_tr,
            baslik_3_tr = :baslik_3_tr,
            baslik_1_en = :baslik_1_en,
            baslik_2_en = :baslik_2_en,
            baslik_3_en = :baslik_3_en,
            aciklama_1_tr = :aciklama_1_tr,
            aciklama_2_tr = :aciklama_2_tr,
            aciklama_3_tr = :aciklama_3_tr,
            aciklama_1_en = :aciklama_1_en,
            aciklama_2_en = :aciklama_2_en,
            aciklama_3_en = :aciklama_3_en,
            link_1_tr = :link_1_tr,
            link_2_tr = :link_2_tr,
            link_1_en = :link_1_en,
            link_2_en = :link_2_en,
            gorsel_1 = :gorsel_1,
            gorsel_2 = :gorsel_2,
            gorsel_3 = :gorsel_3,
            gorsel_4 = :gorsel_4,
            gorsel_5 = :gorsel_5,
            gorsel_6 = :gorsel_6,
            gorsel_7 = :gorsel_7,
            comp = :comp,
            aktif = :aktif
            WHERE id= :id
            
        ");

        $savePage->execute(array(

            'portfolio_id'  => $portfolioId,
            'baslik_1_tr'   => $baslik_1_tr,
            'baslik_2_tr'   => $baslik_2_tr,
            'baslik_3_tr'   => $baslik_3_tr,
            'baslik_1_en'   => $baslik_1_en,
            'baslik_2_en'   => $baslik_2_en,
            'baslik_3_en'   => $baslik_3_en,
            'aciklama_1_tr' => $aciklama_1_tr,
            'aciklama_2_tr' => $aciklama_2_tr,
            'aciklama_3_tr' => $aciklama_3_tr,
            'aciklama_1_en' => $aciklama_1_en,
            'aciklama_2_en' => $aciklama_2_en,
            'aciklama_3_en' => $aciklama_3_en,
            'link_1_tr'     => $link_1_tr,
            'link_2_tr'     => $link_2_tr,
            'link_1_en'     => $link_1_en,
            'link_2_en'     => $link_2_en,
            'gorsel_1'      => $benzersizad0 ?? NULL,
            'gorsel_2'      => $benzersizad1 ?? NULL,
            'gorsel_3'      => $benzersizad2 ?? NULL,
            'gorsel_4'      => $benzersizad3 ?? NULL,
            'gorsel_5'      => $benzersizad4 ?? NULL,
            'gorsel_6'      => $benzersizad5 ?? NULL,
            'gorsel_7'      => $benzersizad6 ?? NULL,
            'comp'          => $compId,
            'aktif'         => $aktif,
            'id'            => $id    
        ));


        #Kayıt edilen verinin ID sini çek
        $contentID = $id;

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
                'islem' => 'Portfolio bileşeni güncellendi',
                'adi' => $userName,
                'icerik' => $adi,
                'uye_id' => $userID
            ));

            #Log kaydetme işlemi başarılı ise geri dön
            if ($saveLog) {
                Header("Location: ../../views/portfolio?perform=sortComp&id=".$portfolioId."&statu=ok");
            } else {
                Header("Location: ../../views/portfolio?perform=sortComp&id=".$portfolioId."&statu=logNo");
            }
        } else {

            Header("Location: ../../views/portfolio?perform=sortComp&id=".$portfolioId."&statu=no");
        }
    }catch (PDOException $e) {
        echo $e->getMessage();
    }
    
}




//silme işlemi
if ($_GET["perform"] == "deleteComp") {

    $contentID = $_GET["id"];
    $compId = $_GET['comp'];
    $adi = "Bileşen $compId";
    $portId = $_GET['portId'];

    try
    {
    $delete = $db->exec("DELETE from tbl_portfolio_comp where id=$contentID");

    if ($delete) {

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
            'islem' => 'Portfolio bileşeni silme',
            'adi' => $userName,
            'icerik' => $adi,
            'uye_id' => $userID
        ));

        #Log kaydetme işlemi başarılı ise geri dön
        if ($saveLog) {
            Header("Location: ../../views/portfolio?perform=sortComp&id=".$portId."&statu=ok");
        } else {
            Header("Location: ../../views/portfolio?perform=sortComp&id=".$portId."&statu=logNo");
        }

    } else {
        header("Location: ../../views/portfolio?perform=sortComp&id=".$portId."&statu=no");
    }}catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if (isset($_POST['sort'])) {

    $items = $_POST['sort'];

    foreach ($items as $sira => $id) {

        #Database kaydı
        $save = $db->prepare("UPDATE tbl_portfolio_comp SET sira=:sira WHERE id=$id");
        $save->execute(array(
            'sira' => $sira
        ));
    }

    if ($save) {

        echo "Sıralama işlemi başarılı";
    } else {
        echo "no";
    }
}

ob_flush();

$db = null;
