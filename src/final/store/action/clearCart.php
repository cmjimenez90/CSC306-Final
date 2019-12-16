<?php 
    //action to remove all items from session cart
    include "../../lib/model/CartItem.php";
    session_start();
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        if(isset($_POST["clear"])) {
            session_unset();
        }
    }
    header("Location: ../?page=mycart")
?>