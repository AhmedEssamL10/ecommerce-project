<?php

use App\Database\Models\Brands;
use App\Database\Models\Cart;
use App\Database\Models\Favorate;
use App\Database\models\Products;

$title = "Home";
// include "app/Database/Models/"
include "layouts/header.php";
include "layouts/navbar.php";
$product = new Products;
$newProduct = $product->newProducts()->fetch_all(MYSQLI_ASSOC);
$brands = new Brands;
$result = $brands->read()->fetch_all(MYSQLI_ASSOC);
$favorate = new Favorate;
$carts = new Cart;
if ($_GET) {
    if (isset($_GET['add'])) {
        $favorate->setUsers_id($_SESSION['user']->id)->setProducts_id($_GET['add'])->addFavItem();
    } elseif (isset($_GET['cart'])) {
        $carts->setUsers_id($_SESSION['user']->id)->setProducts_id($_GET['cart'])->setQuantity(1)->addCartItem();
    }
}
// var_dump($result);
?>
<!-- Slider Start -->
<div class="slider-area">
    <div class="slider-active owl-dot-style owl-carousel">
        <div class="single-slider ptb-240 bg-img" style="background-image:url(assets/img/bg/bg-2.jpg);">
            <div class="container">
                <div class="slider-content slider-animated-1">
                    <h1 class="animated">Want to serve </h1>
                    <h1 class="animated">you all <span class="theme-color">over the world</span></h1>

                    <p>Our goal is to help you around the world
                    </p>
                </div>
            </div>
        </div>
        <div class="single-slider ptb-240 bg-img" style="background-image:url(assets/img/bg/bg-1.jpg);">
            <div class="container">
                <div class="slider-content slider-animated-1">
                    <h1 class="animated">Want to serve </h1>
                    <h1 class="animated">you all <span class="theme-color">over the world</span></h1>

                    <p>Our goal is to help you around the world
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Slider End -->
<!-- Product Area Start -->

<div class="product-area bg-image-1 pt-100 pb-95">
    <div class="container">
        <div class="row">
            <?php
            foreach ($result as $value) {
                # code...

            ?>
                <div class="col-3">

                    <div class="product-img">
                        <a href="shop.php?brand=<?= $value['id'] ?>">

                            <img alt="" src="assets/img/brand-logo/<?= $value['image'] ?>">
                        </a>

                        <div class="product-action">
                            <a class="action-wishlist" href="#" title="Wishlist">
                                <i class="ion-android-favorite-outline"></i>
                            </a>
                            <a class="action-cart" href="#" title="Add To Cart">
                                <i class="ion-ios-shuffle-strong"></i>
                            </a>
                            <a class="action-compare" href="#" data-target="#exampleModal" data-toggle="modal" title="Quick View">
                                <i class="ion-ios-search-strong"></i>
                            </a>
                        </div>
                    </div>
                    <div class="product-content text-left">
                        <div class="product-hover-style">
                            <div class="product-title">
                                <h4>
                                    <a href="product-details.php"><?= $value['en_name'] ?></a>
                                </h4>
                            </div>
                            <div class="cart-hover">
                                <h4><a href="product-details.php">+ Add to cart</a></h4>
                            </div>
                        </div>
                        <div class="product-price-wrapper">
                            <!-- <span>$100.00 -</span>
                        <span class="product-price-old">$130.00 </span> -->
                        </div>
                    </div>

                </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="product-area gray-bg pt-90 pb-65">
    <div class="container">
        <div class="product-top-bar section-border mb-55">
            <div class="section-title-wrap text-center">
                <h3 class="section-title">New Products</h3>
            </div>
        </div>
        <div class="tab-content jump">
            <div class="tab-pane active">
                <div class="featured-product-active owl-carousel product-nav">
                    <?php
                    foreach ($newProduct as $product) {
                        # code...?
                    ?>
                        <div class="product-wrapper-single">

                            <div class="product-wrapper mb-30">

                                <div class="product-img">

                                    <a href="product-details.php?product=<?= $product['id'] ?>">


                                        <img alt="" src="assets/img/product/<?= $product['image'] ?>">
                                    </a>
                                    <!-- <span>-30%</span> -->
                                    <?php
                                    if (isset($_SESSION['user'])) {

                                    ?>
                                        <div class="product-action">
                                            <a class="action-wishlist" href="?add=<?= $product['id'] ?>" title="Favorate">
                                                <i class="ion-android-favorite-outline"></i>
                                            </a>
                                            <a class="action-cart" href="?cart=<?= $product['id'] ?>" title="Add To Cart">
                                                <i class="ion-ios-shuffle-strong"></i>
                                            </a>
                                            <a class="action-compare" href="#" data-target="#exampleModal" data-toggle="modal" title="Quick View">
                                                <i class="ion-ios-search-strong"></i>
                                            </a>
                                        </div>
                                    <?php
                                    } ?>
                                </div>
                                <div class="product-content text-left">
                                    <div class="product-hover-style">
                                        <div class="product-title">
                                            <h4>
                                                <a href="product-details.php?product=<?= $product['id'] ?>"><?= $product['en_name'] ?></a>
                                            </h4>
                                        </div>
                                        <?php
                                        if (isset($_SESSION['user'])) {

                                        ?>
                                            <div class="cart-hover">
                                                <h4><a href="?cart=<?= $product['id'] ?>">+ Add to cart</a>
                                                </h4>
                                            </div>
                                        <?php
                                        } ?>
                                    </div>
                                    <div class="product-price-wrapper">
                                        <span> $ <?= $product['price'] ?></span>
                                        <!-- <span class="product-price-old">$120.00 </span> -->
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- New Products End -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <!-- Thumbnail Large Image start -->
                        <div class="tab-content">
                            <div id="pro-1" class="tab-pane fade show active">
                                <img src="assets/img/product-details/product-detalis-l1.jpg" alt="">
                            </div>
                            <div id="pro-2" class="tab-pane fade">
                                <img src="assets/img/product-details/product-detalis-l2.jpg" alt="">
                            </div>
                            <div id="pro-3" class="tab-pane fade">
                                <img src="assets/img/product-details/product-detalis-l3.jpg" alt="">
                            </div>
                            <div id="pro-4" class="tab-pane fade">
                                <img src="assets/img/product-details/product-detalis-l4.jpg" alt="">
                            </div>
                        </div>
                        <!-- Thumbnail Large Image End -->
                        <!-- Thumbnail Image End -->
                        <div class="product-thumbnail">
                            <div class="thumb-menu owl-carousel nav nav-style" role="tablist">
                                <a class="active" data-toggle="tab" href="#pro-1"><img src="assets/img/product-details/product-detalis-s1.jpg" alt=""></a>
                                <a data-toggle="tab" href="#pro-2"><img src="assets/img/product-details/product-detalis-s2.jpg" alt=""></a>
                                <a data-toggle="tab" href="#pro-3"><img src="assets/img/product-details/product-detalis-s3.jpg" alt=""></a>
                                <a data-toggle="tab" href="#pro-4"><img src="assets/img/product-details/product-detalis-s4.jpg" alt=""></a>
                            </div>
                        </div>
                        <!-- Thumbnail image end -->
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-12">
                        <div class="modal-pro-content">
                            <h3>Dutchman's Breeches </h3>
                            <div class="product-price-wrapper">
                                <span class="product-price-old">£162.00 </span>
                                <span>£120.00</span>
                            </div>
                            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis
                                egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet.</p>
                            <div class="quick-view-select">
                                <div class="select-option-part">
                                    <label>Size*</label>
                                    <select class="select">
                                        <option value="">S</option>
                                        <option value="">M</option>
                                        <option value="">L</option>
                                    </select>
                                </div>
                                <div class="quickview-color-wrap">
                                    <label>Color*</label>
                                    <div class="quickview-color">
                                        <ul>
                                            <li class="blue">b</li>
                                            <li class="red">r</li>
                                            <li class="pink">p</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="product-quantity">
                                <div class="cart-plus-minus">
                                    <input class="cart-plus-minus-box" type="text" name="qtybutton" value="02">
                                </div>
                                <button>Add to cart</button>
                            </div>
                            <span><i class="fa fa-check"></i> In stock</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal end -->

<?php
include "layouts/footer.php";
include "layouts/scripts.php";
?>