<?php

use App\Database\Models\Cart;

$title = "Cart";
include "layouts/header.php";
include "layouts/navbar.php";
include "layouts/breadcrumb.php";
$carts = new Cart;
$result = $carts->setUsers_id($_SESSION['user']->id)->cartList()->fetch_all(MYSQLI_ASSOC);
// print_r($result);
if ($_GET) {
    if (isset($_GET['delete'])) {
        $carts->setUsers_id($_SESSION['user']->id)->setProducts_id($_GET['delete'])->deleteCartItem();
        header("location:cart-page.php");
    }
}

if ($_POST) {
    if (isset($_POST['update'])) {
        $qty = $_POST['qtybutton'];
        foreach ($qty as $key => $value) {
            $carts->setUsers_id($_SESSION['user']->id)->setProducts_id($key)->setQuantity($value)->updateQuantity();
            header("location:cart-page.php");
        }
    }
    if (isset($_POST['clear'])) {
        $carts->setUsers_id($_SESSION['user']->id)->deleteAll();
        header("location:cart-page.php");
    }
}

?>
<!-- shopping-cart-area start -->
<div class="cart-main-area ptb-100">
    <div class="container">
        <h3 class="page-title">Your cart items</h3>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <form action="#" method="post">
                    <div class="table-content table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <!-- <th>Image</th> -->
                                    <th>Product Name</th>
                                    <th>Until Price</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($result as $value) {
                                    # code...

                                ?>
                                <tr>
                                    <!-- <td class="product-thumbnail">
                                        <a href="#"><img src="assets/img/value/value-3.jpg" alt=""></a>
                                    </td> -->
                                    <td class="product-name"><a href="#"><?= $value['en_name'] ?></a></td>
                                    <td class="product-price-value"><span class="amount">$<?= $value['price'] ?></span>
                                    </td>
                                    <td class="product-quantity">

                                        <div class="pro-dec-value">
                                            <!-- <input class="value-plus-minus-box" type="text" value="<?= $value['quantity'] ?>" name="qtybutton[]"> -->
                                            <input class="value-plus-minus-box" type="text"
                                                value="<?= $value['quantity'] ?>"
                                                name="qtybutton[<?= $value['products_id'] ?>]">
                                        </div>
                                    </td>
                                    <td class="product-subtotal">$<?= $value['price'] * $value['quantity']  ?></td>
                                    <!-- <td class="product-remove"> -->
                                    <!-- <a href="#"><i class="fa fa-pencil"></i></a> -->
                                    <td class="product-remove">
                                        <!-- <a href="#"><i class="fa fa-pencil"></i></a> -->

                                        <a href="?delete=<?= $value['products_id'] ?>" class="delete-link"><i
                                                class="fa fa-times"></i></a>

                                    </td>
                                    </td>
                                </tr>
                                <?php
                                } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="cart-shiping-update-wrapper">
                                <div class="cart-shiping-update">
                                    <a href="shop.php">Continue Shopping</a>
                                </div>
                                <div class="cart-clear">
                                    <button name="update" type="submit">Update Shopping Cart</button>
                                    <button name="clear" type="submit">Clear Shopping Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <!-- <div class="col-lg-4 col-md-6">
                        <div class="cart-tax">
                            <div class="title-wrap">
                                <h4 class="cart-bottom-title section-bg-gray">Estimate Shipping And Tax</h4>
                            </div>
                            <div class="tax-wrapper">
                                <p>Enter your destination to get a shipping estimate.</p>
                                <div class="tax-select-wrapper">
                                    <div class="tax-select">
                                        <label>
                                            * Country
                                        </label>
                                        <select class="email s-email s-wid">
                                            <option>Bangladesh</option>
                                            <option>Albania</option>
                                            <option>Åland Islands</option>
                                            <option>Afghanistan</option>
                                            <option>Belgium</option>
                                        </select>
                                    </div>
                                    <div class="tax-select">
                                        <label>
                                            * Region / State
                                        </label>
                                        <select class="email s-email s-wid">
                                            <option>Bangladesh</option>
                                            <option>Albania</option>
                                            <option>Åland Islands</option>
                                            <option>Afghanistan</option>
                                            <option>Belgium</option>
                                        </select>
                                    </div>
                                    <div class="tax-select">
                                        <label>
                                            * Zip/Postal Code
                                        </label>
                                        <input type="text">
                                    </div>
                                    <button class="cart-btn-2" type="submit">Get A Quote</button>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="col-lg-4 col-md-6">
                        <div class="discount-code-wrapper">
                            <div class="title-wrap">
                                <h4 class="cart-bottom-title section-bg-gray">Use Coupon Code</h4>
                            </div>
                            <div class="discount-code">
                                <p>Enter your coupon code if you have one.</p>
                                <form>
                                    <input type="text" required="" name="name">
                                    <button class="cart-btn-2" type="submit">Apply Coupon</button>
                                </form>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-lg-4 col-md-12">
                        <div class="grand-totall">
                            <div class="title-wrap">
                                <h4 class="cart-bottom-title section-bg-gary-cart">Cart Total</h4>
                            </div>
                            <?php
                            $i = 0;
                            foreach ($result as $value) {
                                $i = $i + $value['price']*$value['quantity'];
                            }
                            ?>
                            <h5>Total products <span>$<?= $i ?></span></h5>

                            <!-- <div class="total-shipping"> -->
                            <h5>Total shipping <span> $30.00 </span></h5>

                            <!-- </div> -->
                            <h4 class="grand-totall-title">Grand Total <span>$<?= $i + 30 ?></span></h4>
                            <a href="checkout.php">Proceed to Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include "layouts/footer.php";
include "layouts/scripts.php";
?>