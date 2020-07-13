<!-- Update Product Page -->
<?php 

  if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('views/page_top.php');
require_once('database/products.php');
$productsList = get_products();
const PRODUCTS_LIST = 'productsList';

if(array_key_exists('productsList',$_POST)){         
    $SelectedProduct = selectedProduct();
    function selected_product() {
        //return true;
        return array_key_exists(PRODUCTS_LIST, $_POST);
    }
}

$page_title= 'Order Product';
// The different data managed for each field
define('K_IS_VALID',                'k_is_valid');
define('K_VALUE',                   'k_value');
define('K_FORMAT',                  'k_format');
define('K_ERR_MSG',                 'k_err_msg');

define('PR_NAME',                 'pr_name');
define('FN_ARRIVAL',              'fn_arrival');
define('PRICE',              'price');
define('QUANTITY',              'quantity');

define('CLASS_INVALID_FIELD',       'invalid_field');

$vld = array(
    PR_NAME => array(
        K_IS_VALID => false,
        K_VALUE => null,
        K_FORMAT => '/\w{2,}/',
        K_ERR_MSG => 'Name must hold at least two letters.',
    ),
    PRICE => array(
        K_IS_VALID => false,
        K_VALUE => null,
        K_FORMAT => '/^[0-9]+(\.[0-9]{2})?$/',
        K_ERR_MSG => 'Price must hold a integer.',
    ),
    QUANTITY => array(
        K_IS_VALID => false,
        K_VALUE => null,
        K_FORMAT => '/^[0-9]+(\.[0-9]{2})?$/',
        K_ERR_MSG => 'Quantity must hold a integer.',
    ),
    FN_ARRIVAL => array(
        K_IS_VALID => false,
        K_VALUE => null,
        K_FORMAT => 'Y-m-d', // Date format
        K_ERR_MSG => 'Date must have following format : 2019-10-03',
    ),
);

$receiving =
        'POST' === $_SERVER['REQUEST_METHOD'] // on est en POST
        && array_key_exists(PR_NAME, $_POST)
        && array_key_exists(FN_ARRIVAL, $_POST);

function field_is_invalid($productname) {
    global $vld;
    global $receiving;
    return $receiving && ! $vld[$productname][K_IS_VALID];
}

function vld_class($productname) {
    return field_is_invalid($productname) ?  CLASS_INVALID_FIELD : '';
}
function vld_msg($productname) {
    global $vld;
    return field_is_invalid($productname) ?  "<p class='msg_validation'>{$vld[$productname][K_ERR_MSG]}</p>" : '';
}

if ($receiving) {
    // Validation of text input PR_NAME
    if (array_key_exists(PR_NAME , $_POST)){
        $vld[PR_NAME][K_VALUE] = filter_input(INPUT_POST, PR_NAME, FILTER_SANITIZE_STRING);
        // filter_input returns false if the field is not valid
        $vld[PR_NAME][K_IS_VALID] = (false !== $vld[PR_NAME][K_VALUE])
            && (1 === preg_match($vld[PR_NAME][K_FORMAT], $vld[PR_NAME][K_VALUE]));
    }
    // Validation of text input PRICE
    if (array_key_exists(PRICE , $_POST)){
        $vld[PRICE][K_VALUE] = filter_input(INPUT_POST, PRICE, FILTER_SANITIZE_STRING);
        // filter_input returns false if the field is not valid
        $vld[PRICE][K_IS_VALID] = (false !== $vld[PRICE][K_VALUE])
            && (1 === preg_match($vld[PRICE][K_FORMAT], $vld[PRICE][K_VALUE]));
    }
    // Validation of text input QUANTITY
    if (array_key_exists(QUANTITY , $_POST)){
        $vld[QUANTITY][K_VALUE] = filter_input(INPUT_POST, QUANTITY, FILTER_SANITIZE_STRING);
        // filter_input returns false if the field is not valid
        $vld[QUANTITY][K_IS_VALID] = (false !== $vld[QUANTITY][K_VALUE])
            && (1 === preg_match($vld[QUANTITY][K_FORMAT], $vld[QUANTITY][K_VALUE]));
    }
    // Validation of INPUT FN_ARRIVAL
    if (array_key_exists(FN_ARRIVAL , $_POST)) {
        $vld[FN_ARRIVAL][K_VALUE] = filter_input(INPUT_POST, FN_ARRIVAL, FILTER_SANITIZE_STRING);
        $vld[FN_ARRIVAL][K_IS_VALID] = (false !== $vld[FN_ARRIVAL][K_VALUE]);
        if ($vld[FN_ARRIVAL][K_IS_VALID]) {
            $d = DateTime::createFromFormat('Y-m-d', $vld[FN_ARRIVAL][K_VALUE]);
            $vld[FN_ARRIVAL][K_IS_VALID] = $d && $d->format('Y-m-d') === $vld[FN_ARRIVAL][K_VALUE];
        }
    }
      // Validity of the full form using the K_IS_VALID value of all fields
      $form_is_valid = true;
      foreach ($vld as $field) {
          if ( ! $field[K_IS_VALID]) {
              $form_is_valid = false;
              break;
          }
      }
      if ($form_is_valid) {
          echo "Product Ordered Successfully.";
      }
  
}

?>

<!DOCTYPE html>
<html>
<head lang="fr">
    <meta charset="UTF-8">
    <title>Order Product</title>
    <link rel="stylesheet" href="views/productsListStyle.css" />
</head>

<body>
<h2>Order Product</h2>
<div class="form-container">

<?php if(array_key_exists('productsList',$_POST)) { ?>
    <form class="formulaire_employe" method="POST">
        <!-- Name field (input text) -->
        
        <?php for($i=0;$i<count($SelectedProduct);$i++){ ?>
            <input type="hidden" name="product_id" value="<?= $SelectedProduct[$i]['product_id']  ?>" />
        <div class="form-group <?=vld_class(PR_NAME)?> ">
            <label for="<?= PR_NAME ?>" >Product Name :</label>
            <input type="text" name="<?= PR_NAME ?>" id="<?= PR_NAME ?>"
                   value="<?= $SelectedProduct[$i]['product_name'] ?>" readonly
            />
          <?=vld_msg(PR_NAME)?> 
        
        </div>
        <!-- Price field (input text) -->
        <div class="form-group <?=vld_class(PRICE)?> ">
            <label for="<?= PRICE ?>" >Price :</label>
            <input type="text" name="<?= PRICE ?>" id="<?= PRICE ?>"
                   value="<?= $SelectedProduct[$i]['price'] ?>" readonly
            />
          <?=vld_msg(PRICE)?> 
        
        </div>
        <!-- Quantity field (input text) -->
        <div class="form-group <?=vld_class(QUANTITY)?> ">
            <label for="<?= QUANTITY ?>" >Quantity :</label>
            <input type="text" name="<?= QUANTITY ?>" id="<?= QUANTITY ?>"
                   value="<?= $SelectedProduct[$i]['quantity'] ?>" readonly
            />
          <?=vld_msg(PRICE)?> 
        
        </div>
        
        <!-- Expiry date field (input text) -->
        <div class="form-group <?=vld_class(FN_ARRIVAL)?> ">
            <label for="<?=FN_ARRIVAL?>">Expiry Date :</label>
            <input type="text" name="<?=FN_ARRIVAL?>" id="<?=FN_ARRIVAL?>"
                   value="<?= $SelectedProduct[$i]['expiry_date'] ?>" readonly/>
                   <?=vld_msg(FN_ARRIVAL)?>
        </div>

        <div class="form-group">
            <input type="submit" name="orderId" value="Buy Product">
        </div>
        <?php } ?>
    </form>
<?php } else { ?>
    <form method="POST">
<div class="form-group">
           
        <label for="<?= PR_NAME ?>" >Product Name :</label>
        
        <select name="productsList">  


            <?php for($i=0;$i<count($productsList);$i++){
            $_SESSION['updatedproductid']=$productsList[$i]['product_id'];
            ?>              
            <option value="<?= $productsList[$i]['product_id']?>"><?= $productsList[$i]['product_name']?></option>
            <?php }
            ?>               
        </select>
    </div>
    <input type="submit" name="selectedid" value="SelectedProduct">
   
</form>
<?php } ?>

</div>
</body>
</html>
<?php 

require_once('views/page_bottom.php');
?>