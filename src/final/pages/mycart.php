<?php
//Displays the customers cart and items withing
//Cart items can be removed
//Order can be placed from here
    require_once (__DIR__ . "/../lib/db/StoreRepository.php");
    require_once (__DIR__ . "/../lib/model/CartItem.php");
    require_once (__DIR__ . "/../lib/model/Cart.php");
    session_start();
    $_SESSION["CART"] = isset($_SESSION["CART"]) ? $_SESSION["CART"] : array();
    $cart = new Cart($_SESSION["CART"]);
    $storeRepo = new StoreRepository();
    $taxPercent = .07; 
?>
<h1 class="products-title-bar light-blue-text">
    <span>My Cart</span>
    <?php if(!$cart->isEmpty()): ?>
        <span><a class="waves-effect light-blue btn" href="./">BACK</a></span>
    <?php endif; ?>
</h1>
<?php
//Display alternate view if cart is not visible
if($cart->isEmpty()):  ?>
    <div class="cart-empty">       
        <p>Your cart is empty...</p>
        <p>Please click <a href="./">here</a> to view our available products</p>
    </div>
<?php 
//Display cart items and total section
//Total is calulated by sum of items in cart via for loop
else: ?>
    <section id="cart-section">
        <div class="line-item-card">
            <table>
                <thead class="table-head">
                    <tr>
                        <th>Product Name</th>                
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th><span><form method="POST" action="./action/clearCart.php"><input hidden id="clear" name="clear"/><button type="submit" style="text-align:center;" class="waves-effect light-blue btn">EMPTY CART</button></form></span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($cart->getCartItems() as $item):          
                            $product = $storeRepo->getProduct($item->getId());
                    ?>               
                        <tr>
                            <td><?php echo $product["PRODUCT_NAME"];?></td>
                            <td><?php echo money_format('$%i',$item->costPerItem());?></td>
                            <td style="text-align:center;"><?php echo $item->getQuantity();?></td>
                            <td><?php echo money_format('$%i',$item->totalCost())?>
                            <td><form action="action/removeFromCart.php" method="POST"><input hidden id="productId" name="productId" value="<?php echo $item->getId();?>"><button type="submit"><i class='material-icons'>remove_shopping_cart</i></button></form></td>
                        <tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
       <div>
           <?php $taxTotal = $cart->totalCost()*$taxPercent; 
            $grandTotal =  $cart->totalCost() + $taxTotal;
            ?>
            <div class="total-card card">
                <h3>Your Total</h3>
                <div class="total-card-row"><span class="total-card-heading">Subtotal</span> <span class="total-card-money"><?php echo money_format('$%i',$cart->totalCost());?></span></div>
                <div class="total-card-row"><span class="total-card-heading">Tax</span><span class="total-card-money"><?php echo money_format('$%i',$taxTotal);?></div>
                <div class="total-card-row"><span class="total-card-heading">Grand Total</span><span class="total-card-money"><?php echo money_format('$%i',$grandTotal);?></div>     
            </div>
            <div style="text-align: right;"><a href="./?page=customerdetails" class="waves-effect light-blue btn" type="submit">PURCHASE</a></div> 
       </div>
    </section>
<?php endif; ?>