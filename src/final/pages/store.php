<?php
//Store page. Shows all available products and link to customer's cart.
    include "../lib/db/StoreRepository.php";
    $_SESSION["CART"] = isset($_SESSION["CART"]) ? $_SESSION["CART"] : array();
    $cart = new Cart($_SESSION["CART"]);
    $storeRepo = new StoreRepository();
    $products = $storeRepo->getAllProducts();
?>
<h1 class="products-title-bar light-blue-text"><span>Top Boardgames</span><span style="position: relative;"><a href="./?page=mycart" class="waves-effect light-blue btn">VIEW CART</a><?php if($cart->cartCount() > 0): ?><span style="position:absolute; top: 8px; left: 40px;" class="badge grey white-text"><?php echo "{$cart->cartCount()}" ?></span><?php endif; ?></span></h1>
<div class="card-container">
<?php 
//show each product
foreach($products as $product): ?>
    <div class="card">
        <div class="card-content">
            <span class="card-title"><?php echo $product["PRODUCT_NAME"]?></span>
            <div class="valign-wrapper">
              <p><?php echo $product["PRODUCT_DESC"]; ?></p>
            </div>
        </div>
        <div class="card-action">
          <div class="right-align">
            <form action="./action/addToCart.php" method="post">
              <input type="hidden" id="productId" name="productId" value="<?php echo $product["PRODUCT_ID"]?>"/>
              <span class="product-cost"><?php echo money_format('$%i',$product["PRODUCT_COST"]); ?></span>  
              <button type="submit" class="waves-effect light-blue btn"><i class="material-icons">add_shopping_cart</i></button>
          </form>
          </div>
        </div>
    </div>
<?php endforeach; ?>
</div>
