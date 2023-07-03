<?php

// use App\Database\Models\Brands;

use App\Database\Http\Requests\validation;
use App\Database\Models\Category;
use App\Database\models\Products;
use App\Database\Models\SubCategory;

$title = "Shop";
// include "app/Database/Models/"
include "layouts/header.php";
include "layouts/navbar.php";
$products = new Products;
$validation = new validation;
// $brands = new Brands;
if ($_GET) {
    if (isset($_GET['brand'])) {
        $result = $products->getProductByName("brands_id", $_GET['brand'])->fetch_all(MYSQLI_ASSOC);
    } elseif (isset($_GET['category'])) {
    } elseif (isset($_GET['subcategory'])) {
        $result = $products->getProductByName("subcatigories_id", $_GET['subcategory'])->fetch_all(MYSQLI_ASSOC);
    } else {
        $title = "404 Not Found";
        include "layouts/errors/404.php";
    }
} else {
    $result = $products->read()->fetch_all(MYSQLI_ASSOC);
}


$category = new Category;
$subcatagory = new SubCategory;
$resultcat = $category->read()->fetch_all(MYSQLI_ASSOC);
$resultsubcat = $subcatagory->read()->fetch_all(MYSQLI_ASSOC);
?>
<!-- Shop Page Area Start -->
<div class="shop-page-area ptb-100">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-9">
                <div class="shop-topbar-wrapper">
                    <div class="shop-topbar-left">
                        <ul class="view-mode">
                            <li class="active"><a href="#product-grid" data-view="product-grid"><i class="fa fa-th"></i></a></li>
                            <li><a href="#product-list" data-view="product-list"><i class="fa fa-list-ul"></i></a></li>
                        </ul>
                        <p>Showing 1 - 20 of 30 results </p>
                    </div>
                    <div class="product-sorting-wrapper">
                        <div class="product-shorting shorting-style">
                            <label>View:</label>
                            <select>
                                <option value=""> 20</option>
                                <option value=""> 23</option>
                                <option value=""> 30</option>
                            </select>
                        </div>
                        <div class="product-show shorting-style">
                            <label>Sort by:</label>
                            <select>
                                <option value="">Default</option>
                                <option value=""> Name</option>
                                <option value=""> price</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="grid-list-product-wrapper">

                    <div class="product-grid product-view pb-20">

                        <div class="row">
                            <?php
                            foreach ($result as $value) {
                                # code...

                            ?>
                                <div class="product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30">
                                    <div class="product-wrapper">
                                        <div class="product-img">
                                            <a href="product-details.php">

                                                <img alt="" src="assets/img/product/<?= $value['image'] ?>">
                                            </a>
                                            <!-- <span>-30%</span> -->
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
                                                <span><?= $value['price'] ?> $</span>
                                                <!-- <span class="product-price-old">$120.00 </span> -->
                                            </div>
                                        </div>
                                        <div class="product-list-details">
                                            <h4>
                                                <a href="product-details.php"><?= $value['en_name'] ?></a>
                                            </h4>
                                            <div class="product-price-wrapper">
                                                <span><?= $value['price'] ?> $</span>
                                                <!-- <span class="product-price-old">$120.00 </span> -->
                                            </div>
                                            <p><?= $value['detiles_en'] ?></p>
                                            <div class="shop-list-cart-wishlist">
                                                <a href="#" title="Wishlist"><i class="ion-android-favorite-outline"></i></a>
                                                <a href="#" title="Add To Cart"><i class="ion-ios-shuffle-strong"></i></a>
                                                <a href="#" data-target="#exampleModal" data-toggle="modal" title="Quick View">
                                                    <i class="ion-ios-search-strong"></i>
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            <?php  } ?>
                        </div>

                    </div>

                    <div class="pagination-total-pages">
                        <div class="pagination-style">
                            <ul>
                                <li><a class="prev-next prev" href="#"><i class="ion-ios-arrow-left"></i> Prev</a></li>
                                <li><a class="active" href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">...</a></li>
                                <li><a href="#">10</a></li>
                                <li><a class="prev-next next" href="#">Next<i class="ion-ios-arrow-right"></i> </a></li>
                            </ul>
                        </div>
                        <div class="total-pages">
                            <p>Showing 1 - 20 of 30 results </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="shop-sidebar-wrapper gray-bg-7 shop-sidebar-mrg">
                    <div class="shop-widget">
                        <h4 class="shop-sidebar-title">Shop By Categories</h4>

                        <div class="shop-catigory">


                            <ul id="faq">
                                <?php
                                foreach ($resultcat as $cat) {
                                    # code...

                                ?>
                                    <li> <a data-toggle="collapse" data-parent="#faq" href="#shop-catigory-1"><?= $cat['en_name'] ?><i class="ion-ios-arrow-down"></i></a>

                                        <ul id="shop-catigory-1" class="panel-collapse collapse show">
                                            <?php
                                            foreach ($resultsubcat as $subcat) {
                                                if ($cat['id'] == $subcat['catigories_id']) {
                                            ?>
                                                    <li><a href="#"><?= $subcat['en_name'] ?></a></li>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </ul>

                                    </li>
                                <?php

                                } ?>
                            </ul>

                        </div>

                    </div>
                    <div class="shop-price-filter mt-40 shop-sidebar-border pt-35">
                        <h4 class="shop-sidebar-title">Price Filter</h4>
                        <div class="price_filter mt-25">
                            <span>Range: $100.00 - 1.300.00 </span>
                            <div id="slider-range"></div>
                            <div class="price_slider_amount">
                                <div class="label-input">
                                    <input type="text" id="amount" name="price" placeholder="Add Your Price" />
                                </div>
                                <button type="button">Filter</button>
                            </div>
                        </div>
                    </div>
                    <div class="shop-widget mt-40 shop-sidebar-border pt-35">
                        <h4 class="shop-sidebar-title">By Brand</h4>
                        <div class="sidebar-list-style mt-20">
                            <ul>
                                <li><input type="checkbox"><a href="#">Green </a>
                                <li><input type="checkbox"><a href="#">Herbal </a></li>
                                <li><input type="checkbox"><a href="#">Loose </a></li>
                                <li><input type="checkbox"><a href="#">Mate </a></li>
                                <li><input type="checkbox"><a href="#">Organic </a></li>
                                <li><input type="checkbox"><a href="#">White </a></li>
                                <li><input type="checkbox"><a href="#">Yellow Tea </a></li>
                                <li><input type="checkbox"><a href="#">Puer Tea </a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="shop-widget mt-40 shop-sidebar-border pt-35">
                        <h4 class="shop-sidebar-title">By Color</h4>
                        <div class="sidebar-list-style mt-20">
                            <ul>
                                <li><input type="checkbox"><a href="#">Black </a></li>
                                <li><input type="checkbox"><a href="#">Blue </a></li>
                                <li><input type="checkbox"><a href="#">Green </a></li>
                                <li><input type="checkbox"><a href="#">Grey </a></li>
                                <li><input type="checkbox"><a href="#">Red</a></li>
                                <li><input type="checkbox"><a href="#">White </a></li>
                                <li><input type="checkbox"><a href="#">Yellow </a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="shop-widget mt-40 shop-sidebar-border pt-35">
                        <h4 class="shop-sidebar-title">Compare Products</h4>
                        <div class="compare-product">
                            <p>You have no item to compare. </p>
                            <div class="compare-product-btn">
                                <span>Clear all </span>
                                <a href="#">Compare <i class="fa fa-check"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="shop-widget mt-40 shop-sidebar-border pt-35">
                        <h4 class="shop-sidebar-title">Popular Tags</h4>
                        <div class="shop-tags mt-25">
                            <ul>
                                <li><a href="#">Green</a></li>
                                <li><a href="#">Oolong</a></li>
                                <li><a href="#">Black</a></li>
                                <li><a href="#">Pu'erh</a></li>
                                <li><a href="#">Dark </a></li>
                                <li><a href="#">Special</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shop Page Area End -->

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
<?php
include "layouts/footer.php";
include "layouts/scripts.php";
?>