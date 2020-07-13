<?php
    $name = 'zyder';
    $pwd='zyder@123';
    $loggedin = 0;
    if(session_status() === PHP_SESSION_NONE) {
        session_start();
    }  
// Names of all fields in the form
define('FN_USERNAME',   'fn_Username');
define('FN_PASSWORD',   'fn_Password');
define('LOGIN_STATUS', 'loginstatus');
if(array_key_exists(LOGIN_STATUS,$_SESSION) && $_SESSION[LOGIN_STATUS]===1){
    unset($_SESSION[FN_USERNAME]);
    unset($_SESSION[LOGIN_STATUS]);
}

if(array_key_exists(FN_USERNAME,$_POST ) && array_key_exists(FN_PASSWORD, $_POST ) && $_POST[FN_USERNAME]===$name && $_POST[FN_PASSWORD]===$pwd){
    $_SESSION[FN_USERNAME] = $name;
    $_SESSION[LOGIN_STATUS] =1;
    $loggedin=1;
    
}
elseif(array_key_exists(FN_USERNAME,$_SESSION)){
    $loggedin=1;
}else{$loggedin=0;}

require_once('views/page_top.php'); 

if ($loggedin) {
    var_dump($_SESSION);
    header('Location: booking.php');  
}


?>
<!DOCTYPE html>
<html>
<head lang="fr">
    <meta charset="UTF-8">
    <title>Login Form</title>
    <link rel="stylesheet" href="style.css" />
    <style>
    h2{
    text-align: center;
    color: darkred;
}

.form-container{
    width: 50%;
    margin-right: auto;
    margin-left: auto;
    padding: 10px 30px;
    border: solid 3px darkred;
}

.form-inline{
    padding: 3em;
    border: solid darkred;
}
</style>

</head>
<body>
<h2>Login form</h2>
<div class="form-container">
    <form class="Login_form" method="post">

        <!-- Name field (input text) -->
        <div class="form-group ">
            <label for="<?= FN_USERNAME ?>" >USERNAME :</label>
            <input type="text" name="<?= FN_USERNAME ?>" id="<?= FN_USERNAME ?>"
                value="<?= array_key_exists(FN_USERNAME, $_POST) ? $_POST[FN_USERNAME] : '' ?>"
            />
        </div>

        <!-- Password field (input text) -->
        <div class="form-group ">
            <label for="<?= FN_PASSWORD ?>" >PASSWORD :</label>
            <input type="text" name="<?= FN_PASSWORD ?>" id="<?= FN_PASSWORD ?>"
                value="<?= array_key_exists(FN_PASSWORD, $_POST) ? $_POST[FN_PASSWORD] : '' ?>"
            />
        </div>
        
        <div class="form-group">
            <input type="submit" value="LOGIN">
               
        </div>
        </form>
</div>
</body>
</html>