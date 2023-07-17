<?php
$title = "Checkout";
include "layouts/header.php";
include "layouts/navbar.php";
include "layouts/breadcrumb.php";

use App\Database\Http\Requests\validation;
use App\Database\Models\Address;
use App\Database\Models\Cart;
use App\Database\Models\Orders_products;

$carts = new Cart;
$order = new Orders_products;
$address = new Address;
$validation = new validation;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['update_address'])) {
        $validation->setInput('city')->setValue($_POST['city'])->required();
        $validation->setInput('region')->setValue($_POST['region'])->required();
        $validation->setInput('buliding')->setValue($_POST['buliding'])->required();
        $validation->setInput('floor')->setValue($_POST['floor'])->required();
        $validation->setInput('street')->setValue($_POST['street'])->required();
        if (empty($validation->getErrors())) {
            $address->setCity($_POST['city'])->setStreet($_POST['street'])->setBuliding($_POST['buliding'])->setFloor($_POST['floor'])->setRegion($_POST['region'])->setUsers_id($_SESSION['user']->id)->updateAddress();
        }
    }
}
if (isset($_SESSION['user'])) {
    $result = $carts->setUsers_id($_SESSION['user']->id)->cartList()->fetch_all(MYSQLI_ASSOC);
    $myAddress = $address->setUsers_id($_SESSION['user']->id)->read()->fetch_all(MYSQLI_ASSOC);
    if ($address->setUsers_id($_SESSION['user']->id)->read()->num_rows == 0) {
        $error =  "<div style='display: flex; justify-content: center; align-items: center; height: 20vh;'>
        <h3 style='color: #008000 !important;'>Enter your address </h3>
      </div>";
    }
    if (isset($_POST['ordering'])) {
        $order->setUser_id($_SESSION['user']->id)->create();
        $carts->setUsers_id($_SESSION['user']->id)->deleteAll();
        $success = "<div class='alert alert-success text-center'> The process is done ... We will contact you to receive your order </div>";
        header('refresh:3; url=index.php');
    }
}

?>
<!-- checkout-area start -->
<?= $success ?? '' ?>
<div class="checkout-area pb-80 pt-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="checkout-wrapper">

                    <div id="faq" class="panel-group">
                        <!-- <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>1.</span> <a data-toggle="collapse" data-parent="#faq" href="#payment-1">Checkout method</a></h5>
                            </div>
                            <div id="payment-1" class="panel-collapse collapse show">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <div class="checkout-register">
                                                <div class="title-wrap">
                                                    <h4 class="cart-bottom-title section-bg-white">CHECKOUT AS A GUEST
                                                        OR REGISTER</h4>
                                                </div>
                                                <div class="register-us">
                                                    <ul>
                                                        <li><input type="checkbox"> Checkout as Guest</li>
                                                        <li><input type="checkbox"> Register</li>
                                                    </ul>
                                                </div>
                                                <h6>REGISTER AND SAVE TIME!</h6>
                                                <div class="register-us-2">
                                                    <p>Register with us for future convenience.</p>
                                                    <ul>
                                                        <li>Fast and easy checkout</li>
                                                        <li>Easy access to your order history and status</li>
                                                    </ul>
                                                </div>
                                                <a href="#">Apply Coupon</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <div class="checkout-login">
                                                <div class="title-wrap">
                                                    <h4 class="cart-bottom-title section-bg-white">LOGIN</h4>
                                                </div>
                                                <p>Already have an account? </p>
                                                <span>Please log in below:</span>
                                                <form>
                                                    <div class="login-form">
                                                        <label>Email Address * </label>
                                                        <input type="email" name="email">
                                                    </div>
                                                    <div class="login-form">
                                                        <label>Password *</label>
                                                        <input type="password" name="email">
                                                    </div>
                                                </form>
                                                <div class="login-forget">
                                                    <a href="#">Forgot your password?</a>
                                                    <p>* Required Fields</p>
                                                </div>
                                                <div class="checkout-login-btn">
                                                    <a href="#">Login</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>2.</span> <a data-toggle="collapse" data-parent="#faq"
                                        href="#payment-2">billing information</a></h5>
                            </div>
                            <div id="payment-2" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="billing-info">
                                                    <label>First Name</label>
                                                    <input type="text" name="first_name"
                                                        value="<?= $_SESSION['user']->first_name ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="billing-info">
                                                    <label>Last Name</label>
                                                    <input type="text" name="last_name"
                                                        value="<?= $_SESSION['user']->last_name ?>">
                                                </div>
                                            </div>
                                            <!-- <div class="col-lg-6 col-md-6">
                                                <div class="billing-info">
                                                    <label>Company</label>
                                                    <input type="text">
                                                </div>
                                            </div> -->
                                            <div class="col-lg-6 col-md-6">
                                                <div class="billing-info">
                                                    <label>Email Address</label>
                                                    <input type="email" name="email"
                                                        value="<?= $_SESSION['user']->email ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="billing-info">
                                                    <label>Address</label>
                                                    <input type="text" name="address"
                                                        value="<?= $myAddress[0]['region'] . " - " . $myAddress[0]['street'] . " - " . "Buliding no " . $myAddress[0]['buliding'] . " - " . "Floor no " . $myAddress[0]['floor'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="billing-info">
                                                    <label>city</label>
                                                    <input type="text" name="city" value="<?= $myAddress[0]['city'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="billing-info">
                                                    <label>Country</label>
                                                    <input type="text" name="country" value="Egypt">
                                                </div>
                                            </div>
                                            <!-- <div class="col-lg-6 col-md-6">
                                                <div class="billing-info">
                                                    <label>Zip/Postal Code</label>
                                                    <input type="text">
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-lg-6 col-md-6">
                                                <div class="billing-select">
                                                    <label>Country</label>
                                                    <select>
                                                        <option value="1">United State</option>
                                                        <option value="2">Azerbaijan</option>
                                                        <option value="3">Bahamas</option>
                                                        <option value="4">Bahrain</option>
                                                        <option value="5">Bangladesh</option>
                                                        <option value="6">Barbados</option>
                                                    </select>
                                                </div>
                                            </div> -->
                                            <div class="col-lg-6 col-md-6">
                                                <div class="billing-info">
                                                    <label>Telephone</label>
                                                    <input type="text" name="phone"
                                                        value="<?= $_SESSION['user']->phone ?>">
                                                </div>
                                            </div>
                                            <!-- <div class="col-lg-6 col-md-6">
                                                <div class="billing-info">
                                                    <label>Fax</label>
                                                    <input type="text">
                                                </div>
                                            </div> -->
                                        </div>
                                        <!-- <div class="ship-wrapper">
                                            <div class="single-ship">
                                                <input type="radio" name="address" value="address" checked="">
                                                <label>Ship to this address</label>
                                            </div>
                                            <div class="single-ship">
                                                <input type="radio" name="address" value="dadress">
                                                <label>Ship to different address</label>
                                            </div>
                                        </div> -->
                                        <div class="billing-back-btn">
                                            <!-- <div class="billing-back">
                                                <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                            </div> -->

                                            <form action="" method="post">
                                                <div class="billing-btn">
                                                    <button type="submit" name="ordering">Get a Quote</button>
                                                </div>
                                                <div
                                                    class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center">
                                                    <div class="entries-edit-delete text-center">
                                                        <a class="action-compare" href="#" data-target="#exampleModal"
                                                            data-toggle="modal" title="Quick View">
                                                            Edit
                                                        </a>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="exampleModal" tabindex="-1"
                                                            role="dialog">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">

                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form method="post">
                                                                            <div class="row">
                                                                                <div class="col-lg-6 col-md-6">
                                                                                    <div class="billing-info">

                                                                                        <input type="text" name="city"
                                                                                            placeholder="Enter city"
                                                                                            value="<?= $myAddress[0]['city']  ?> ">
                                                                                    </div>
                                                                                    <?= $validation->getError('city') ?? '' ?>
                                                                                </div>
                                                                                <div class="col-lg-6 col-md-6">
                                                                                    <div class="billing-info">

                                                                                        <input type="text" name="region"
                                                                                            placeholder="Enter region"
                                                                                            value="<?= $myAddress[0]['region']  ?> ">
                                                                                    </div>
                                                                                    <?= $validation->getError('region') ?? '' ?>

                                                                                </div>
                                                                                <div class="col-lg-6 col-md-6">
                                                                                    <div class="billing-info">

                                                                                        <input type="text" name="street"
                                                                                            placeholder="Enter street"
                                                                                            value="<?= $myAddress[0]['street']  ?> ">
                                                                                    </div>
                                                                                    <?= $validation->getError('street') ?? '' ?>

                                                                                </div>

                                                                                <div class="col-lg-6 col-md-6">
                                                                                    <div class="billing-info">

                                                                                        <input type="text"
                                                                                            name="buliding"
                                                                                            placeholder="Enter buliding"
                                                                                            value="<?= $myAddress[0]['buliding']  ?> ">
                                                                                    </div>
                                                                                    <?= $validation->getError('buliding') ?? '' ?>

                                                                                </div>
                                                                                <div class="col-lg-6 col-md-6">
                                                                                    <div class="billing-info">

                                                                                        <input type="text" name="floor"
                                                                                            placeholder="Enter floor"
                                                                                            value="<?= $myAddress[0]['floor']  ?> ">
                                                                                    </div>
                                                                                    <?= $validation->getError('floor') ?? '' ?>

                                                                                </div>
                                                                                <div class="billing-btn">
                                                                                    <button type="submit"
                                                                                        name="update_address">Continue</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal end -->

                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>3.</span> <a data-toggle="collapse" data-parent="#faq"
                                        href="#payment-3">shipping
                                        information</a></h5>
                            </div>
                            <div id="payment-3" class="panel-collapse collapse ">
                                <div class="panel-body">
                                    <div class="shipping-information-wrapper">
                                        <div class="shipping-info-2">
                                            <p>Country: <?= 'Egypt' ?></p>
                                            <p>City: <?= $myAddress[0]['city'] ?? '?' ?> </p>
                                            <p>Region: <?= $myAddress[0]['region'] ?? '?' ?></p>
                                            <p>Street: <?= $myAddress[0]['street'] ?? '?' ?></p>
                                            <span><?= $_SESSION['user']->phone ?> </span>
                                        </div>
                                        <!-- <div class="edit-address">
                                            <a href="#">Edit Address</a>
                                        </div>
                                        <div class="billing-select">
                                            <select class="email s-email s-wid">
                                                <option>Select Your Address</option>
                                                <option>Add New Address</option>
                                                <option>Dkaka, 1201, Bangladesh</option>
                                            </select>
                                        </div>
                                        <div class="ship-wrapper">
                                            <div class="single-ship">
                                                <input type="checkbox" checked="" value="address" name="address">
                                                <label>Use Billing Address</label>
                                            </div>
                                        </div> -->
                                        <!-- <div class="billing-back-btn">
                                            <div class="billing-back">
                                                <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                            </div>
                                            <div class="billing-btn">
                                                <button type="submit">Continue</button>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>4.</span> <a data-toggle="collapse" data-parent="#faq"
                                        href="#payment-4">Shipping
                                        method</a></h5>
                            </div>
                            <div id="payment-4" class="panel-collapse collapse ">
                                <div class="panel-body">
                                    <div class="shipping-method-wrapper">
                                        <div class="shipping-method">
                                            <p>Flat Rate</p>
                                            <p>Fixed $30.00</p>
                                        </div>
                                        <!-- <div class="billing-back-btn">
                                            <div class="billing-back">
                                                <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                            </div>
                                            <div class="billing-btn">
                                                <button type="submit">Continue</button>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>5.</span> <a data-toggle="collapse" data-parent="#faq"
                                        href="#payment-5">payment
                                        information</a></h5>
                            </div>
                            <div id="payment-5" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="payment-info-wrapper">
                                        <div class="ship-wrapper">
                                            <div class="single-ship">
                                                <input type="radio" checked="" value="address" name="address">
                                                <label>Check / Money order </label>
                                            </div>
                                            <div class="single-ship">
                                                <input type="radio" value="dadress" name="address">
                                                <label>Credit Card (saved) </label>
                                            </div>
                                        </div>
                                        <div class="payment-info">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Name on Card </label>
                                                        <input type="text">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-select">
                                                        <label>Credit Card Type</label>
                                                        <select>
                                                            <option>American Express</option>
                                                            <option>Visa</option>
                                                            <option>MasterCard</option>
                                                            <option>Discover</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>Credit Card Number </label>
                                                        <input type="text">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="expiration-date">
                                                <label>Expiration Date </label>
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="billing-select">
                                                            <select>
                                                                <option>Month</option>
                                                                <option>January</option>
                                                                <option>February</option>
                                                                <option> March</option>
                                                                <option>April</option>
                                                                <option> May</option>
                                                                <option>June</option>
                                                                <option>July</option>
                                                                <option>August</option>
                                                                <option>September</option>
                                                                <option> October</option>
                                                                <option> November</option>
                                                                <option> December</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="billing-select">
                                                            <select>
                                                                <option>Year</option>
                                                                <option>2015</option>
                                                                <option>2016</option>
                                                                <option>2017</option>
                                                                <option>2018</option>
                                                                <option>2019</option>
                                                                <option>2020</option>
                                                                <option>2021</option>
                                                                <option>2022</option>
                                                                <option>2023</option>
                                                                <option>2024</option>
                                                                <option>2025</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>Card Verification Number</label>
                                                        <input type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="billing-back-btn">
                                            <div class="billing-back">
                                                <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                            </div>
                                            <div class="billing-btn">
                                                <button type="submit">Continue</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>6.</span> <a data-toggle="collapse" data-parent="#faq"
                                        href="#payment-6">Order
                                        Review</a></h5>
                            </div>
                            <div id="payment-6" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="order-review-wrapper">
                                        <div class="order-review">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="width-1">Product Name</th>
                                                            <th class="width-2">Price</th>
                                                            <th class="width-3">Qty</th>
                                                            <th class="width-4">Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($result as $value) {
                                                            # code...

                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <div class="o-pro-dec">
                                                                    <p><?= $value['en_name'] ?></p>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="o-pro-price">
                                                                    <p>$<?= $value['price'] ?></p>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="o-pro-qty">
                                                                    <p><?= $value['quantity'] ?></p>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="o-pro-subtotal">
                                                                    <p>$<?= $value['price'] * $value['quantity']  ?></p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php

                                                        } ?>
                                                    </tbody>
                                                    <?php
                                                    $i = 0;
                                                    foreach ($result as $value) {
                                                        $i = $i + $value['price'] * $value['quantity'];
                                                    }
                                                    ?>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3">Subtotal </td>
                                                            <td colspan="1">$<?= $i ?></td>
                                                        </tr>
                                                        <tr class="tr-f">
                                                            <td colspan="3">Shipping & Handling (Flat Rate - Fixed</td>
                                                            <td colspan="1">$30.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">Grand Total</td>
                                                            <td colspan="1">$<?= $i + 30 ?></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            <div class="billing-back-btn">
                                                <span>
                                                    Forgot an Item?
                                                    <a href="cart-page.php"> Edit Your Cart.</a>

                                                </span>
                                                <!-- <div class="billing-btn">
                                                    <button type="submit">Continue</button>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="checkout-progress">
                    <h4>Checkout Progress</h4>
                    <ul>
                        <li>Billing Address</li>
                        <li>Shipping Address</li>
                        <li>Shipping Method</li>
                        <li>Payment Method</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include "layouts/footer.php";
include "layouts/scripts.php";
?>