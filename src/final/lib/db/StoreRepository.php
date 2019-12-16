<?php 
include_once (__DIR__ . "/../Config.php");
require_once (__DIR__ . "/../../lib/model/CartItem.php");
require_once (__DIR__ . "/../../lib/model/Cart.php");
require_once (__DIR__ . "/../../lib/model/Customer.php");
class StoreRepository {

    //return list of all products in the db along with with all fields
    public function getAllProducts() {
        $query = "SELECT STORE_PRODUCT.PRODUCT_ID,
                    STORE_PRODUCT.PRODUCT_NAME,
                    STORE_PRODUCT.PRODUCT_DESC,
                    STORE_PRODUCT.PRODUCT_COST
                        FROM STORE.STORE_PRODUCT";
        $dbConnection = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD);
        $results = $dbConnection->query($query);
        $products = $this->processResults($results);
        $dbConnection->close();
        return $products;
    }
    //return product in the db along with with all fields by ID
    public function getProduct($productId) {
        $escapedProductId = htmlspecialchars($productId);
        $query = "SELECT STORE_PRODUCT.PRODUCT_ID,
                    STORE_PRODUCT.PRODUCT_NAME,
                    STORE_PRODUCT.PRODUCT_DESC,
                    STORE_PRODUCT.PRODUCT_COST
                        FROM STORE.STORE_PRODUCT
                        WHERE STORE_PRODUCT.PRODUCT_ID = $escapedProductId";
        $dbConnection = new  mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD);
        $result = $dbConnection->query($query);
        $product = $this->processResults($result);
        $dbConnection->close();
        return $product[0];
    }

    //creates a order in the db. 
    public function createOrder($customer, $cart) {
        $customerID = null;
        $dbConnection = new  mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD);
        $dbConnection->begin_transaction();
        //find customer or create if new
        $findCustomerQuery =  "SELECT STORE_CUSTOMER.CUSTOMER_ID 
                                FROM STORE.STORE_CUSTOMER 
                                WHERE STORE_CUSTOMER.CUSTOMER_EMAIL = '{$customer->email}'";
        $foundCustomerResult = $dbConnection->query($findCustomerQuery);
        if($foundCustomerResult->num_rows < 1){
            $createCustomerQuery = "INSERT INTO STORE.STORE_CUSTOMER(
                STORE_CUSTOMER.CUSTOMER_FIRSTNAME,
                STORE_CUSTOMER.CUSTOMER_LASTNAME,
                STORE_CUSTOMER.CUSTOMER_EMAIL,
                STORE_CUSTOMER.CUSTOMER_ADDRESS,
                STORE_CUSTOMER.CUSTOMER_CITY,
                STORE_CUSTOMER.CUSTOMER_STATE,
                STORE_CUSTOMER.CUSTOMER_ZIP) 
            VALUES (
                '{$customer->firstName}','{$customer->lastName}','{$customer->email}','{$customer->address}','{$customer->city}','{$customer->state}','{$customer->zip}'
            )";
            if(!$dbConnection->query($createCustomerQuery)){
                $dbConnection->rollback();
                $dbConnection->close();
                return false;
            }
            $customerID = $dbConnection->insert_id;
        } else {
            $customerID = $foundCustomerResult->fetch_assoc()["CUSTOMER_ID"];
        }

        //create order
        $createOrderQuery = "INSERT INTO STORE.STORE_ORDER(STORE_ORDER.ORDER_CUSTOMER) VALUES ('{$customerID}')";
        if(!$dbConnection->query($createOrderQuery)){
            $dbConnection->rollback();
            $dbConnection->close();
            return false;
        }
        $orderID = $dbConnection->insert_id;
        //add items to order
        foreach($cart->getCartItems() as $cartItem){
            $addItemToOrderQuery = "INSERT INTO STORE.STORE_ORDERITEMS(
                STORE_ORDERITEMS.ORDER_ID,
                STORE_ORDERITEMS.ITEM_ID,
                STORE_ORDERITEMS.QUANTITY) 
                VALUES (
                    '{$orderID}',
                    '{$cartItem->getId()}',
                    '{$cartItem->getQuantity()}'
                )";
            if(!$dbConnection->query($addItemToOrderQuery)){
                echo "{$dbConnection->error}";
                $dbConnection->rollback();
                $dbConnection->close();
                return false;
            }
        }

        $dbConnection->commit();
        $dbConnection->close();
        return true;
    }

    private function processResults($results){
        $processedResult = array();

        if($results->num_rows > 0){
            while($row = $results->fetch_assoc()){
                $processedResult[] =  $row;
            }
        }
        return $processedResult;
    }
}
?>