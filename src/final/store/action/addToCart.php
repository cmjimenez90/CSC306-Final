<?php 
    //action to add item to cart
    include "../../lib/model/CartItem.php";
    session_start();
    
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        if(isset($_POST["productId"])) {
            $escpapedProductID = htmlspecialchars($_POST["productId"]);
            if(false === array_key_exists($escpapedProductID,$_SESSION["CART"])) {
               $cartItem = new CartItem($escpapedProductID,1);
               $_SESSION["CART"][$escpapedProductID] = serialize($cartItem);
            } else {
                $cartItem = unserialize($_SESSION["CART"][$escpapedProductID]);
                $cartItem->addQuantity();
                $_SESSION["CART"][$escpapedProductID] = serialize($cartItem);
            }
        }
    }
    header("Location: ../index.php")
?>