<?php
/*form for processing the customer's order
if all items are valid, then calls the createOrder from the store repository
Displays an error if can not process order
Displays success if order succesful
Also clears session cart if successful.
*/
require_once (__DIR__ . "/../lib/db/StoreRepository.php");
require_once (__DIR__ . "/../lib/model/Customer.php");
require_once (__DIR__ . "/../lib/model/CartItem.php");
require_once (__DIR__ . "/../lib/model/Cart.php");
session_start();
//declare form validation variables
$errorFirstName = null;
$errorLastName = null;
$errorEmail = null;
$errorPhone = null;
$errorAddress = null;
$errorCity = null;
$errorState = null;
$errorZip = null;
$errorCardNumber = null;
$errorCardName = null;
$errorCardExp = null;
$errorCardCSC = null;

//sanitize string data
function sanitizePostData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
//validate form before processing
if($_SERVER["REQUEST_METHOD"] === "POST") {
    $hasErrors = false;
    $customer = new Customer();
    //validate sessionID
    if(!empty($_POST["token"]) && $_POST["token"] == $_SESSION["token"]) {
        //validate Customer First Name
        if(empty($_POST["first_name"])){
            $errorFirstName = "Please enter a first name";
            $hasErrors = true;
        } else {
            $customer->firstName = sanitizePostData($_POST["first_name"]);
        }
        //validate Customer Last Name
        if(empty($_POST["last_name"])){
            $errorLastName = "Please enter a last name";
            $hasErrors = true;
        } else {
            $customer->lastName = sanitizePostData($_POST["last_name"]);
        }

        //validate Email address
        if(empty($_POST["email"])){
            $errorEmail = "Please enter an email address";
            $hasErrors = true;
        } else {
            $customer->email = sanitizePostData($_POST["email"]);
            if (!filter_var($customer->email, FILTER_VALIDATE_EMAIL)) {
                $errorEmail = "Invalid email format";
                $hasErrors = true;
            }
        }

        //validate Phone number
        if(empty($_POST["phone"])){
            $errorPhone = "Please enter a phone number";
            $hasErrors = true;
        } else {
            $customer->phone = sanitizePostData($_POST["phone"]);
            if(!preg_match("/[0-9]{10}/", $customer->phone)) {
                $errorPhone = "Please enter a 10-digit phone number";
                $hasErrors = true;
            }
        }

        //validate customer address values
        if(empty($_POST["address"])){
            $errorAddress = "Please enter a address";
            $hasErrors = true;
        } else {
            $customer->address = sanitizePostData($_POST["address"]);
        }
        if(empty($_POST["city"])){
            $errorCity = "Please enter a city";
            $hasErrors = true;
        } else {
            $customer->city = sanitizePostData($_POST["city"]);
        }
        if(empty($_POST["state"])){
            $errorState = "Please enter a state";
            $hasErrors = true;
        } else {
            $customer->state = sanitizePostData($_POST["state"]);
        }
        if(empty($_POST["zip"])){
            $errorZip = "Please enter a zip";
            $hasErrors = true;
        } else {
            $customer->zip = sanitizePostData($_POST["zip"]);
        }

        //Validate Card Information
        if(empty($_POST["card_number"])){
            $errorCardNumber = "Please enter a credit card number";
            $hasErrors = true;
        } else {
            $cardNumber = sanitizePostData($_POST["card_number"]);
            if(!preg_match("/[0-9]{16,19}/", $cardNumber)) {
                $errorCardNumber = "Card number is invalid";
                $hasErrors = true;
            }
        }
        if(empty($_POST["card_name"])){
            $errorCardName = "Please enter the name on your card";
            $hasErrors = true;
        } else {
            $cardName = sanitizePostData($_POST["card_name"]);
        }
        if(empty($_POST["card_exp_date"])){
            $errorCardExp = "Please enter the card's expiration date";
            $hasErrors = true;
        } else {
            $cardExp = sanitizePostData($_POST["card_exp_date"]);
        }
        if(empty($_POST["card_csc"])){
            $errorCardCSC = "Please enter the CSC value of the card";
            $hasErrors = true;
        } else {
            $cardCSC = sanitizePostData($_POST["card_csc"]);
        }
        //process order
        if(!$hasErrors && isset($_SESSION["CART"])){
            $storeRepo = new StoreRepository();
            $orderProcessed = $storeRepo->createOrder($customer,new Cart($_SESSION["CART"]));
        }

        if($orderProcessed === true){
            session_unset();
        }
    }   
}
$_SESSION["token"] = bin2hex(random_bytes(32));
?>
<?php if($hasErrors === true || $_SERVER["REQUEST_METHOD"] === "GET"): ?>
    <h1 class="products-title-bar light-blue-text">Order Information</h1>
    <div class="order-information">
        <form style="display: flex; flex-direction: column; align-items: end;" action="./?page=customerdetails" method="POST">
            <fieldset class="card">
                <legend>Customer Details</legend>
                <div class="row">
                    <div class="input-field col s12 m6">
                        <input id="first_name" name="first_name" type="text" value="<?php echo $customer->firstName?>" >
                        <label for="first_name">First Name<span class="red-text"><?php if(!empty($errorFirstName)){ echo (" *" . $errorFirstName);}?></span></label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="last_name" name="last_name" type="text" value="<?php echo $customer->lastName?>" >
                        <label for="last_name">Last Name<span class="red-text"><?php if(!empty($errorLastName)){ echo (" *" . $errorLastName);}?></span></label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="email" name="email" type="text" value="<?php echo $customer->email?>" >
                        <label for="email">Email<span class="red-text"><?php if(!empty($errorEmail)){ echo (" *" . $errorEmail);}?></span></label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="phone" name="phone" type="text" value="<?php echo $customer->phone?>"  >
                        <label for="phone">Phone Number<span class="red-text"><?php if(!empty($errorPhone)){ echo (" *" . $errorPhone);}?></span></label>
                    </div>
                </div>
                <div class="row">   
                    <div class="input-field col s12 m6">
                        <input id="address" name="address" type="text" value="<?php echo $customer->address?>" >
                        <label for="address">Address<span class="red-text"><?php if(!empty($errorAddress)){ echo (" *" . $errorAddress);}?></span></label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="city" name="city" type="text" value="<?php echo $customer->city?>"  >
                        <label for="city">City<span class="red-text"><?php if(!empty($errorCity)){ echo (" *" . $errorCity);}?></span></label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="state" name="state" type="text" value="<?php echo $customer->state?>" >
                        <label for="state">State<span class="red-text"><?php if(!empty($errorState)){ echo (" *" . $errorState);}?></span></label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="zip" name="zip" type="text" value="<?php echo $customer->zip?>"  >
                        <label for="zip">Zip<span class="red-text"><?php if(!empty($errorZip)){ echo (" *" . $errorZip);}?></span></label>
                    </div>
                </div>
            </fieldset>
            <fieldset class="card">
                <legend>Payment Details</legend>
                <div class="row">
                    <div class="input-field col s12 m6">
                        <input id="card_number" name="card_number" type="text" value="<?php echo $cardNumber?>" >
                        <label for="card_number">Card Number<span class="red-text"><?php if(!empty($errorCardNumber)){ echo (" *" . $errorCardNumber);}?></span></label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="card_name" name="card_name" type="text"  value="<?php echo $cardName?>" >
                        <label for="card_name">Name on Card<span class="red-text"><?php if(!empty($errorCardName)){ echo (" *" . $errorCardName);}?></span></label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="card_exp_date" name="card_exp_date" type="text" value="<?php echo $cardExp?>"  >
                        <label for="card_exp_date">Expiration Date<span class="red-text"><?php if(!empty($errorCardExp)){ echo (" *" . $errorCardExp);}?></span></label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="card_csc" name="card_csc" type="text" value="<?php echo $cardCSC?>"  >
                        <label for="card_csc">CSC<span class="red-text"><?php if(!empty($errorCardCSC)){ echo (" *" . $errorCardCSC);}?></span></label>
                    </div>
                </div>
            </fieldset>
            <input type="hidden" id="token" name="token" value="<?php echo $_SESSION['token'];?>"/>
            <span><button type="submit" class="waves-effect light-blue btn">SUBMIT ORDER</button></span>
        </form>
    </div>
<?php elseif($orderProcessed === false || !isset($orderProcessed)): ?>
   <?php include (__DIR__ . "/error.php"); ?>
<?php else: ?>
    <?php  include (__DIR__ . "/ordercomplete.php"); ?>
<?php endif; ?>