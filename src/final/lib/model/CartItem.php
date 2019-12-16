<?php
//cart item to work with each item stored in the session cart
require_once (__DIR__ . "/../db/StoreRepository.php");
class CartItem {
    private $_itemId;
    private $_itemCost;
    private $_quantity;

    public function __construct($itemId,$quantity){
        $storeRepo = new StoreRepository();
        $product = $storeRepo->getProduct($itemId);

        $this->_itemId = $itemId;
        $this->_quantity = $quantity; 
        $this->_itemCost = $product["PRODUCT_COST"];     
    }

    public function getId(){ return $this->_itemId;}
    public function costPerItem(){return $this->_itemCost;}
    public function totalCost(){return $this->_itemCost*$this->_quantity;}
    public function getQuantity(){ return $this->_quantity;}
    public function addQuantity(){ $this->_quantity += 1;}
    public function removeQuantity(){ 
        if($this->_quantity > 0) {
            $this->_quantity -= 1;
        }     
    }
}
?>