
<?php 
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title= 'Catalouge';
require_once('views/page_top.php');
require_once('database/products.php');
$productsList = get_products();

if(array_key_exists('like',$_POST) || array_key_exists('dislike',$_POST)){
    updateLikes();
}
?>
<main>
<h2 style="text-align:center">Catalogue</h2>

<div class="productdiv">
<form class="formulaire_employe" method="POST">
    <?php for($i=0;$i<count($productsList);$i++){?>
    <div class="card">
        <img src="images/<?= $productsList[$i]['imagename'] ?>" alt="chocolate img" style="width:100%">
        <input type="hidden" name="product_id" value="<?= $productsList[$i]['product_id']  ?>" />
        <h1 class="name">Product Name : <?= $productsList[$i]['product_name']?></h1>
        <p class="price">Price : <?= $productsList[$i]['price']?>$</p>
        <p class="quantity">Quantity : <?= $productsList[$i]['quantity']?></p>
        <p class="expiry_date">Expiry Date : <?= $productsList[$i]['expiry_date'] ?></p>
        <input type="hidden" name="likesCount" value="<?= $productsList[$i]['likes']  ?>" />
        <p><label for="likes"><?= $productsList[$i]['likes'] ?></label>
        <button type="submit" name="like">Like </button>
        <button type="submit" name="dislike">Dislike</button></p>
    </div>
    <?php
    }
    ?>
  </form>
</div><br>
</main>
<?php
require_once('views/page_bottom.php');
?>