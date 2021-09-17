<?php ob_start(); ?>
 <?php include("conn.php"); ?>

<?php
$arr_file_types = ['image/png', 'image/gif', 'image/jpg', 'image/jpeg'];
 
if (!(in_array($_FILES['file']['type'], $arr_file_types))) {
    echo "false";
    return;
}
 
if (!file_exists('uploads')) {
    mkdir('uploads', 0777);
}
 $uploads_dir = '../uploads/';
    @$tmp_name = $_FILES['file']["tmp_name"];
    @$dosya = $_FILES['file']["name"];
    @$firmaadi = temizle($dosya) ;
    @$uzanti = extens($dosya);
    //resmin isminin benzersiz olması
    $benzersizsayi1=rand(20000,32000);
    $benzersizsayi2=rand(20000,32000);
    $benzersizsayi3=rand(20000,32000);
    $benzersizad=$firmaadi."-".$benzersizsayi1.$benzersizsayi2.$benzersizsayi3.".".$uzanti;
     @move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad$name");
     $urun_idbilgi = $_POST['urunid'];
 
    $sql="insert into tbl_galeri (urun_id,gorsel) values('$urun_idbilgi', '$benzersizad')";
    $kayit=mysqli_query($conn,$sql);

echo "<div class=col-md-3><div style=height:200px;width:100%;background-image:url('../uploads/$benzersizad');background-size:cover;></div></div>";
?>

 <?php $conn->close(); ?>
<?php ob_flush(); ?>


