<?php

use App\Database\Models\Category;
use App\Database\Models\Cart;

include "App/Database/Models/SubCatagory.php";

use App\Database\Models\SubCategory;

$category = new Category;
$subcatagory = new SubCategory;
$result = $category->read()->fetch_all(MYSQLI_ASSOC);
$subresult = $subcatagory->read()->fetch_all(MYSQLI_ASSOC);
if (isset($_SESSION['user'])) {
    $carts = new Cart;
    $cart_result = $carts->setUsers_id($_SESSION['user']->id)->cartList()->fetch_all(MYSQLI_ASSOC);
    if ($_GET) {
        if (isset($_GET['delete'])) {
            $carts->setUsers_id($_SESSION['user']->id)->setProducts_id($_GET['delete'])->deleteCartItem();
            header("location:cart-page.php");
        }
    }
}
?>
<header class="header-area gray-bg clearfix">
    <div class="header-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="logo">
                        <a href="index.php">
                            <img alt="" src="assets/img/logo/logo.png">
                        </a>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 col-6">
                    <div class="header-bottom-right">
                        <div class="main-menu">
                            <nav>
                                <ul>
                                    <li class="top-hover"><a href="index.php">home</a>
                                    </li>
                                    <li class="mega-menu-position top-hover"><a href="shop.php">shop</a>
                                        <ul class="mega-menu">
                                            <?php
                                            foreach ($result as $value) {
                                            ?>
                                            <li>
                                                <ul>
                                                    <li class="font-weight-bold">
                                                        <?= ucwords($value['en_name']) ?>
                                                    </li>

                                                    <?php
                                                        foreach ($subresult as $subvalue) {
                                                            if ($subvalue['catigories_id'] == $value['id']) {
                                                        ?>

                                                    <li><a
                                                            href="shop.php?subcategory=<?= $subvalue['id'] ?>"><?= $subvalue['en_name'] ?></a>
                                                    </li>

                                                    <?php
                                                            }
                                                        } ?>

                                                </ul>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                    <?php
                                    if (isset($_SESSION['user'])) {
                                    ?>
                                    <li class="top-hover"><a href="cart-page.php">Cart</a>
                                    </li>
                                    <li class="top-hover"><a href="wishlist.php">Favorate</a>
                                    </li>
                                    <?php
                                    }
                                    ?>
                                    <li><a href="about-us.php">about</a></li>


                                    <li><a href="contact.php">contact</a></li>
                                </ul>
                            </nav>
                        </div>
                        <?php
                        if (isset($_SESSION['user'])) {
                        ?>
                        <div class="header-currency">
                            <span class="digit"><?= $_SESSION['user']->first_name ?> <i
                                    class="ti-angle-down"></i></span>
                            <div class="dollar-submenu">
                                <ul>
                                    <li><a href="my-account.php">Profile</a></li>
                                    <li><a href="logout.php">Logout</a></li>
                                </ul>
                            </div>
                        </div>
                        <?php } else {
                        ?>
                        <div class="header-currency">
                            <span class="digit">Welcome <i class="ti-angle-down"></i></span>
                            <div class="dollar-submenu">
                                <ul>
                                    <li><a href="login.php">Login</a></li>
                                    <li><a href="register.php">Register</a></li>

                                </ul>
                            </div>
                        </div>
                        <?php } ?>
                        <?php
                        if (isset($_SESSION['user'])) { ?>
                        <div class="header-cart">
                            <a href="#">
                                <div class="cart-icon">
                                    <i class="ti-shopping-cart"></i>
                                </div>
                            </a>

                            <div class="shopping-cart-content">
                                <?php

                                    $i = 0;
                                    foreach ($cart_result as $value) {
                                        # code...
                                        $i = $i + $value['price'] * $value['quantity'];
                                    ?>
                                <ul>
                                    <li class="single-shopping-cart">

                                        <div class="shopping-cart-title">
                                            <h4><a href="#"><?= $value['en_name'] ?> </a></h4>
                                            <h6>Qty: <?= $value['quantity'] ?></h6>
                                            <span>$<?= $value['price'] ?></span>
                                        </div>
                                        <div class="shopping-cart-delete">
                                            <a href="?delete=<?= $value['products_id'] ?>"><i
                                                    class="ion ion-close"></i></a>
                                        </div>
                                    </li>

                                </ul>
                                <?php }
                                    ?>
                                <div class="shopping-cart-total">

                                    <h4>Shipping : <span>$30</span></h4>
                                    <h4>Total : <span class="shop-total"><?= $i + 30 ?></span></h4>
                                </div>
                                <div class="shopping-cart-btn">
                                    <a href="cart-page.php">view cart</a>
                                    <a href="checkout.php">checkout</a>
                                </div>
                            </div>

                        </div>
                        <?php
                        } ?>
                    </div>
                </div>
            </div>
            <div class="mobile-menu-area">
                <div class="mobile-menu">
                    <nav id="mobile-menu-active">
                        <ul class="menu-overflow">
                            <li><a href="#">HOME</a>
                            </li>
                            <li><a href="shop.php"> Shop </a>
                                <ul>
                                    <li><a href="#">Categories 01</a>
                                        <ul>
                                            <li><a href="shop.php">Aconite</a></li>
                                            <li><a href="shop.php">Ageratum</a></li>
                                            <li><a href="shop.php">Allium</a></li>
                                            <li><a href="shop.php">Anemone</a></li>
                                            <li><a href="shop.php">Angelica</a></li>
                                            <li><a href="shop.php">Angelonia</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Categories 02</a>
                                        <ul>
                                            <li><a href="shop.php">Balsam</a></li>
                                            <li><a href="shop.php">Baneberry</a></li>
                                            <li><a href="shop.php">Bee Balm</a></li>
                                            <li><a href="shop.php">Begonia</a></li>
                                            <li><a href="shop.php">Bellflower</a></li>
                                            <li><a href="shop.php">Bergenia</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Categories 03</a>
                                        <ul>
                                            <li><a href="shop.php">Caladium</a></li>
                                            <li><a href="shop.php">Calendula</a></li>
                                            <li><a href="shop.php">Carnation</a></li>
                                            <li><a href="shop.php">Catmint</a></li>
                                            <li><a href="shop.php">Celosia</a></li>
                                            <li><a href="shop.php">Chives</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Categories 04</a>
                                        <ul>
                                            <li><a href="shop.php">Daffodil</a></li>
                                            <li><a href="shop.php">Dahlia</a></li>
                                            <li><a href="shop.php">Daisy</a></li>
                                            <li><a href="shop.php">Diascia</a></li>
                                            <li><a href="shop.php">Dusty Miller</a></li>
                                            <li><a href="shop.php">Dame’s Rocket</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="about-us.php"> About us </a></li>

                            <li><a href="contact.php"> Contact us </a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header end -->