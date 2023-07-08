<?php
$title = "Product details";
include "layouts/header.php";
include "layouts/navbar.php";
// include "layouts/breadcrumb.php";
use App\Database\Models\Favorate;
use App\Database\models\Products;
use App\Database\Models\Review;

$products = new Products;
$review = new Review;
$favorate = new Favorate;
if ($_GET) {
    if (isset($_GET['product'])) {
        if (is_numeric($_GET['product'])) {
            $result = $products->getProductByName("id", $_GET['product']);
            $reviewResult = $review->setProduct_id($_GET['product'])->read()->fetch_all(MYSQLI_ASSOC);
            $numOfRates = $review->setProduct_id($_GET['product'])->Rates()->fetch_all(MYSQLI_ASSOC);
            $nameRates = $review->setProduct_id($_GET['product'])->getNameRate()->fetch_all(MYSQLI_ASSOC);
            if ($result->num_rows > 0) {
                $result->fetch_all(MYSQLI_ASSOC);
            } else {
                echo "<div style='display: flex; justify-content: center; align-items: center; height: 40vh;'>
                <h1 style='color: #008000 !important;'>No Product found </h1>
              </div>";
            }
        } else {
            $title = "404 Not Found";
            include "layouts/errors/404.php";
        }
    }
    if (isset($_GET['add'])) {
        $favorate->setUsers_id($_SESSION['user']->id)->setProducts_id($_GET['add'])->addFavItem();
        $result = $products->getProductByName("id", $_GET['add']);
        $reviewResult = $review->setProduct_id($_GET['add'])->read()->fetch_all(MYSQLI_ASSOC);
        $numOfRates = $review->setProduct_id($_GET['add'])->Rates()->fetch_all(MYSQLI_ASSOC);
        $nameRates = $review->setProduct_id($_GET['add'])->getNameRate()->fetch_all(MYSQLI_ASSOC);
        if ($result->num_rows > 0) {
            $result->fetch_all(MYSQLI_ASSOC);
        }
    }
    // var_dump($reviewResult);

} else {
    $title = "404 Not Found";
    include "layouts/errors/404.php";
}



?>
<!-- Product Deatils Area Start -->
<div class="product-details pt-100 pb-95">
    <div class="container">
        <div class="row">
            <?php
            foreach ($result as $value) {
                # code...

            ?>
            <div class="col-lg-6 col-md-12">
                <div class="product-details-img">
                    <img class="zoompro" src="assets/img/product/<?= $value['image'] ?>"
                        data-zoom-image="assets/img/product/<?= $value['image'] ?>" alt="zoom" />

                    <!-- <span>-29%</span> -->
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="product-details-content">

                    <h4><?= $value['en_name'] ?></h4>
                    <div class="rating-review">
                        <div class="pro-dec-rating">
                            <?php
                                for ($i = 0; $i < $numOfRates[0]['avg_Rates']; $i++) {
                                    # code...

                                ?>
                            <i class="ion-android-star-outline theme-star"></i>
                            <?php
                                }
                                ?>
                            <?php
                                for ($i = 0; $i < 5 - $numOfRates[0]['avg_Rates']; $i++) {
                                    # code...

                                ?>
                            <i class="ion-android-star-outline"></i>
                            <?php
                                }
                                ?>

                        </div>
                        <div class="pro-dec-review">
                            <ul>
                                <li><?= $numOfRates[0]['num_Rates'] ?> Reviews </li>
                                <li> Add Your Reviews</li>
                            </ul>
                        </div>
                    </div>
                    <span>$<?= $value['price'] ?></span>
                    <?php
                        if ($value['quantity'] > 5) {
                        ?>
                    <div class="in-stock">
                        <p>Available: <span>In stock</span></p>
                    </div>
                    <?php
                        } elseif ($value['quantity'] == 0) {
                        ?>
                    <div class="in-stock">
                        <p>Available: <span style="color:red">Out of stock</span></p>
                    </div>
                    <?php
                        } elseif ($value['quantity'] <= 5 && $value['quantity'] >= 1) {
                        ?>
                    <div class="in-stock">
                        <p>Available: <span style="color:darkorange">In stock </span></p>
                    </div>
                    <div class="in-stock">
                        <p>Quantity: <span style="color:darkorange"> <?= $value['quantity'] ?> </span></p>
                    </div>


                    <?php
                        }
                        ?>

                    <div class="quality-add-to-cart">
                        <div class="quality">
                            <label>Qty:</label>
                            <input class="cart-plus-minus-box" type="text" name="qtybutton" value="1">
                        </div>

                        <div class="shop-list-cart-wishlist">
                            <a title="Add To Cart" href="#">
                                <i class="icon-handbag"></i>
                                cart
                            </a>
                            <a title="Favorate" href="?add=<?= $value['id'] ?>">
                                <i class="icon-heart"></i>
                                fav
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            <?php
            } ?>
        </div>
    </div>
</div>
<!-- Product Deatils Area End -->
<div class=" description-review-area pb-70">
    <div class="container">
        <div class="description-review-wrapper">
            <div class="description-review-topbar nav text-center">
                <a class="active" data-toggle="tab" href="#des-details1">Description</a>
                <a data-toggle="tab" href="#des-details3">Review</a>
            </div>
            <div class="tab-content description-review-bottom">
                <?php

                foreach ($result as $value) {
                    # code...
                    $i = 0;
                ?>
                <div id="des-details1" class="tab-pane active">
                    <div class="product-description-wrapper">
                        <p><?= $value['detiles_en'] ?> </p>


                    </div>
                </div>


                <div id="des-details3" class="tab-pane">
                    <div class="rattings-wrapper">
                        <?php
                            foreach ($reviewResult as $value) {
                                # code...

                            ?>
                        <div class="sin-rattings">
                            <div class="star-author-all">
                                <div class="pro-dec-rating">
                                    <?php
                                            for ($i = 0; $i < $value['rate']; $i++) {
                                                # code...

                                            ?>
                                    <i class="ion-android-star-outline theme-star"></i>
                                    <?php
                                            }
                                            ?>
                                    <?php
                                            for ($i = 0; $i < 5 - $value['rate']; $i++) {
                                                # code...

                                            ?>
                                    <i class="ion-android-star-outline"></i>
                                    <?php
                                            }
                                            ?>
                                    <span> (<?= $value['rate']  ?>)</span>
                                </div>
                                <div class="ratting-author f-right">
                                    <?php

                                            if ($i <= $numOfRates[0]['num_Rates']) {

                                            ?>
                                    <h3><?= $nameRates[$i - 1]['full_name'] ?></h3>
                                    <?php

                                            }


                                            ?>
                                    <span><?= $value['created_at'] ?></span>
                                </div>
                            </div>
                            <p><?= $value['comment'] ?></p>
                        </div>
                        <?php
                            }
                            ?>
                    </div>
                    <div class="ratting-form-wrapper">
                        <h3>Add your Comments :</h3>
                        <div class="ratting-form">
                            <form action="#">
                                <div class="star-box">
                                    <h2>Rating:</h2>
                                    <div class="ratting-star">
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star"></i>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="rating-form-style mb-20">
                                            <input placeholder="Name" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="rating-form-style mb-20">
                                            <input placeholder="Email" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="rating-form-style form-submit">
                                            <textarea name="message" placeholder="Message"></textarea>
                                            <input type="submit" value="add review">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
                    $i++;
                } ?>
            </div>
        </div>
    </div>
</div>

<!-- Footer style End -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">x</span></button>
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
                                <a class="active" data-toggle="tab" href="#pro-1"><img
                                        src="assets/img/product-details/product-detalis-s1.jpg" alt=""></a>
                                <a data-toggle="tab" href="#pro-2"><img
                                        src="assets/img/product-details/product-detalis-s2.jpg" alt=""></a>
                                <a data-toggle="tab" href="#pro-3"><img
                                        src="assets/img/product-details/product-detalis-s3.jpg" alt=""></a>
                                <a data-toggle="tab" href="#pro-4"><img
                                        src="assets/img/product-details/product-detalis-s4.jpg" alt=""></a>
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
                            <p>Pellentesque habitant morbi tristique senectus et netus et
                                malesuada fames ac turpis
                                egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget,
                                tempor sit amet.</p>
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