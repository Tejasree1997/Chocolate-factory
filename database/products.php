<?php
    require_once('conn.php');
    function get_products(){
        global $mysqli;
        $query_string = 'SELECT * FROM products';
        $res = $mysqli-> query($query_string);
        $result = array();//to store data
        if($res && ($res-> num_rows > 0)){ // if query return data bor not
            $row = false; // variable for each row of data
            while($row=$res->fetch_assoc()){
                $result[] = $row;
            }
        }
        return $result;
    }
    
   
    function selectedProduct(){
        if(array_key_exists('productsList',$_POST)){
            $id = (int)$_POST['productsList'];
        }
        global $mysqli;
        $query_string = "SELECT * FROM products WHERE product_id=$id";
        $res = $mysqli-> query($query_string);
        $result = array();//to store data
        if($res && ($res-> num_rows > 0)){ // if query return data bor not
            $row = false; // variable for each row of data
            while($row=$res->fetch_assoc()){
                $result[] = $row;
            }
        }
        return $result;
    }
    function addProduct(){

        if(array_key_exists('pr_name',$_POST) && array_key_exists('price',$_POST) && array_key_exists('quantity',$_POST) && array_key_exists('fn_arrival',$_POST)){
            $name= $_POST['pr_name'];
            $price = (int)$_POST['price'];
            $quantity=(int)$_POST['quantity'];
            $date = $_POST['fn_arrival'];
            $imagename = $_FILES['uploaded_file']['name'];
        }
        global $mysqli;
        $query_insert ="INSERT INTO products (product_name,quantity,price,expiry_date,imagename) VALUES ('$name',$quantity,$price,'$date','$imagename')";
        //$mysqli-> query($query_insert);
        
            
            if($mysqli->query($query_insert) === true){ 
                echo "Records was inserted successfully."; 
                //header('Location: addproduct.php');
                
            } else{ 
                echo "ERROR: Could not able to execute $query_insert. "  
                                                    . $mysqli->error; 
            }
        $mysqli->close(); 
        
    }

    function updateProduct(){
        global $mysqli;
        if(array_key_exists('pr_name',$_POST) && array_key_exists('price',$_POST) && array_key_exists('quantity',$_POST) && array_key_exists('fn_arrival',$_POST) && array_key_exists('selectedid',$_POST)){
            $id = (int)$_POST['product_id'];
            $name= $_POST['pr_name'];
            $price = (int)$_POST['price'];
            $quantity=(int)$_POST['quantity'];
            $date = $_POST['fn_arrival'];
            $like = $_POST['likes'];
            $query_update ="UPDATE products SET product_name='$name', price=$price, quantity=$quantity, likes=$like WHERE product_id=$id";
        
        }elseif(array_key_exists('deletedid',$_POST)){
            $id = (int)$_POST['product_id'];
            $query_update ="DELETE from products WHERE product_id=$id";
        
        }  
        $mysqli-> query($query_update);
        if($mysqli->query($query_update) === true){ 
            echo "Records was updated successfully."; 
            
        } else{ 
            echo "ERROR: Could not able to execute $query_update. "  
                                                . $mysqli->error; 
        } 
        $mysqli->close(); 
        header('Location: booking.php');
        
    }
   
    function updateLikes(){

        if(array_key_exists('like',$_POST)){
            $id = (int)$_POST['product_id'];
            $likes = ((int)$_POST['likesCount']);
            $likes = $likes +1;
        }elseif(array_key_exists('dislike',$_POST)){
            $id = (int)$_POST['product_id'];
            $likes = ((int)$_POST['likesCount']);
            $likes = $likes - 1;
        }
        global $mysqli;
        $query_update ="UPDATE products SET likes=$likes WHERE product_id=$id";
        $mysqli-> query($query_update);
        if($mysqli->query($query_update) === true){ 
            echo "Records was updated successfully."; 
            header('Location: catalogue.php');
            
        } else{ 
            echo "ERROR: Could not able to execute $query_update. "  
                                                . $mysqli->error; 
        } 
        $mysqli->close(); 
        
    }
    /*$trial=get_products();
    print_r($trial);*/
    
