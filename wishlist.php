<?php

use App\Database\Models\Favorate;
use App\Database\models\Products;

$title = "Favorate";
include "layouts/header.php";
include "layouts/navbar.php";
include "layouts/breadcrumb.php";
$favorate = new Favorate;
$result = $favorate->setUsers_id($_SESSION['user']->id)->favorateList()->fetch_all(MYSQLI_ASSOC);
$products = new Products;
$proresult = $products->read()->fetch_all(MYSQLI_ASSOC);
if ($_GET) {
    if (isset($_GET['delete'])) {
        $favorate->setUsers_id($_SESSION['user']->id)->setProducts_id($_GET['delete'])->deleteFavItem();
    }
}
?>

<!-- shopping-cart-area start -->
<div class="cart-main-area ptb-100">
    <div class="container">
        <h3 class="page-title">Your Favorate items</h3>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <form action="#">
                    <div class="table-content table-responsive wishlist">
                        <table>
                            <thead>
                                <tr>

                                    <th>Product Name</th>
                                    <th>Until Price</th>
                                    <th>Add To Cart</th>
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
                                        <a><img src="assets/img/product/ $value['productImage'] " alt=""></a>
                                    </td> -->
                                        <td class="product-name"><a href="product-details.php?product=<?= $value['products_id'] ?>"><?= $value['en_name'] ?></a>
                                        </td>
                                        <td class="product-price-cart"><span class="amount">$<?= $value['price'] ?></span>
                                        </td>
                                        <td class="product-wishlist-cart">
                                            <a href="cart-page.php?product=<?= $value['products_id'] ?>">add to cart</a>
                                        </td>
                                        <td class="product-remove">
                                            <!-- <a href="#"><i class="fa fa-pencil"></i></a> -->

                                            <a href="wishlist.php?delete=<?= $value['products_id'] ?>" class="delete-link"><i class="fa fa-times"></i></a>

                                        </td>
                                    </tr>

                                <?php
                                }
                                ?>

                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include "layouts/footer.php";
include "layouts/scripts.php";
?>
<script>

</script>