<?php 
  if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
$LoginOutName='Login';
if(array_key_exists('fn_Username',$_SESSION)){
    $LoginOutName='Logout';   
}
$pages = array('Home'=>'index.php','Catalogue'=>'catalogue.php','Update Product'=>'booking.php','Add Product'=>'addproduct.php',$LoginOutName=>'login.php')

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="views/productsListStyle.css">
    <title>Zyder Chocoloate Factory - <?=$page_title?></title>
    
 
</head>
<body>
<header>
    <nav>
        <?php
            foreach ($pages as $page => $link): ?>
            <nav id="headerfile">
                <a href="<?= $link?>"><?= $page?> </a> 
            </nav>
            <?php endforeach; ?>
    </nav>
</header>
