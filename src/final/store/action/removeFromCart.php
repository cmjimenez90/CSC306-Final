<?php
    //action to remove a specific item from cart
    include "../../lib/model/CartItem.php";
    session_start();
    if($_SERVER["REQUEST_METHOD"] === 'POST') {
        if(isset($_POST['productId'])) {
            $escpapedProductID = htmlspecialchars($_POST["productId"]);
            unset($_SESSION['CART'][$escpapedProductID]);
        }
    }
    header("location: ../?page=mycart")
?>