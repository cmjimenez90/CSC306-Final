<?php
//Cart object of working with the session cart
    include_once (__DIR__ . "/CartItem.php");
    class Cart {
        private $_cart = array();

        public function __construct($sessionCart){
            foreach($sessionCart as $cartItem){
                $this->_cart[]= unserialize($cartItem);
            }
        }
        //returns the carts total cost of all items within
        public function totalCost(){
            $subTotal = 0;
            foreach($this->_cart as $cartItem){
                $subTotal += $cartItem->totalCost();
            }
            return $subTotal;
        }
        //returns the total count of all items in cart
        public function cartCount(){
            $itemCount = 0;
            foreach($this->_cart as $cartItem){
                $quantityOfItem = $cartItem->getQuantity();
                $itemCount += $quantityOfItem;
            }

            return $itemCount;
        }

        public function getCartItems(){
            return $this->_cart;
        }

        public function isEmpty(){
           $currentItemCount = $this->cartCount();
           if($currentItemCount >= 1) {
               return false;
           }
           return true;
        }
    }
?>