<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('views/page_top.php');
require_once('database/products.php');

if(!(array_key_exists('fn_Username',$_SESSION))){

    header('Location: login.php');  
}
$page_title= 'Add Product';
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
       if($form_is_valid){
        addProduct();
      }
}
?>

<!DOCTYPE html>
<html>
<head lang="fr">
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link rel="stylesheet" href="views/productsListStyle.css" />
</head>

<body>
<h2>Add Product</h2>
<div class="form-container">
<form class="formulaire_employe" enctype="multipart/form-data" method="POST">
        <!-- Name field (input text) -->
        <div class="form-group <?=vld_class(PR_NAME)?> ">
            <label for="<?= PR_NAME ?>" >Product Name :</label>
            <input type="text" name="<?= PR_NAME ?>" id="<?= PR_NAME ?>"
                   value=""
            />
          <?=vld_msg(PR_NAME)?> 
        
        </div>
        <!-- Price field (input text) -->
        <div class="form-group <?=vld_class(PRICE)?> ">
            <label for="<?= PRICE ?>" >Price :</label>
            <input type="text" name="<?= PRICE ?>" id="<?= PRICE ?>"
                   value=""
            />
          <?=vld_msg(PRICE)?> 
        
        </div>
        <!-- Quantity field (input text) -->
        <div class="form-group <?=vld_class(QUANTITY)?> ">
            <label for="<?= QUANTITY ?>" >Quantity :</label>
            <input type="text" name="<?= QUANTITY ?>" id="<?= QUANTITY ?>"
                   value=""
            />
          <?=vld_msg(PRICE)?> 
        
        </div>
        
        <!-- Arrival date field (input text) -->
        <div class="form-group <?=vld_class(FN_ARRIVAL)?> ">
            <label for="<?=FN_ARRIVAL?>">Expiry Date :</label>
            <input type="text" name="<?=FN_ARRIVAL?>" id="<?=FN_ARRIVAL?>"
                   value=""/>
                   <?=vld_msg(FN_ARRIVAL)?>
        </div>
        <div>
            <label for=""></label>
            <input type="file" name="uploaded_file"></input><br />
            <?php 
                if(!empty($_FILES['uploaded_file']))
                {
                  $path = "images/";
                  $path = $path . basename( $_FILES['uploaded_file']['name']);
                  if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
                    echo "The file ".  basename( $_FILES['uploaded_file']['name']). 
                    " has been uploaded";
                  } else{
                      echo "There was an error uploading the file, please try again!";
                  }
                }
            ?>
        </div>

        <div class="form-group">
            <input type="submit" name="addId" value="Add Product">
        </div>
    </form>
    </div>
</body>
</html>
<?php 
require_once('views/page_bottom.php');
?>