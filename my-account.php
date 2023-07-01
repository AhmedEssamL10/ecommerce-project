<?php

use App\Services\Media;
use App\Database\Models\User;

$title = "Profile";
include "layouts/header.php";
include "App/database/Http/Middlewares/Auth.php";
include "layouts/navbar.php";
include "layouts/breadcrumb.php";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['upload-image'])) {
        if ($_FILES['image']['error'] == 0) {
            $imageService = new Media;
            $imageService->setFile($_FILES['image'])
                ->size(1024 * 1024)->extension(['png', 'jpg', 'jpeg']);
            if (empty($imageService->getErrors())) {
                $imageService->upload('assets/img/users/');
                $user = new User;
                $user->setEmail($_SESSION['user']->email)->setImage($imageService->getFileName());
                if ($user->updateImage()) {
                    if ($_SESSION['user']->image != 'default.jpg') {
                        $imageService->delete('assets/img/users/' . $_SESSION['user']->image);
                    }
                    $_SESSION['user']->image = $imageService->getFileName();
                    $successfullUpload = "<div class='alert alert-success text-center'> Profile Picture Uploaded Successfully </div>";
                } else {
                    $failedUpload = "<div class='alert alert-danger text-center'> Upload Failed </div>";
                }
            }
        }
    } elseif (isset($_POST['update-info'])) {
        $user = new User;
        $user->setInput('first_name')->setValue($_POST['first_name'])->setEmail($_SESSION['user']->email)->update();
        $_SESSION['user']->first_name = $user->getValue();
        $user->setInput('last_name')->setValue($_POST['last_name'])->setEmail($_SESSION['user']->email)->update();
        $_SESSION['user']->last_name = $user->getValue();
        $user->setInput('gender')->setValue($_POST['gender'])->setEmail($_SESSION['user']->email)->update();
        $_SESSION['user']->gender = $user->getValue();
    }
}
?>
<!-- my account start -->
<div class="checkout-area pb-80 pt-100">
    <div class="container">
        <div class="row">
            <div class="ml-auto mr-auto col-lg-9">
                <div class="checkout-wrapper">
                    <div id="faq" class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>1</span> <a data-toggle="collapse" data-parent="#faq"
                                        href="#my-account-1">Edit your account information </a></h5>
                            </div>

                            <div id="my-account-1"
                                class="panel-collapse collapse <?= isset($_POST['upload-image']) ? 'show' : '' ?>">
                                <div class="panel-body">
                                    <form action="" method="post">
                                        <div class="billing-information-wrapper">
                                            <div class="account-info-wrapper">
                                                <h4>My Account Information</h4>
                                                <h5>Your Personal Details</h5>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 my-5">
                                                    <div class="row">
                                                        <div class="col-4 offset-4 text-center">
                                                            <?php
                                                        if ($_SESSION['user']->image == 'default.jpg') {
                                                            if ($_SESSION['user']->gender == 'm')
                                                                $image = 'male.jpg';
                                                            else
                                                                $image = 'female.jpg';
                                                        } else {
                                                            $image = $_SESSION['user']->image;
                                                        }
                                                        ?>
                                                            <label for="file">
                                                                <img src="assets/img/users/<?= $image ?>" id="image"
                                                                    class="w-100 rounded-circle" style="cursor:pointer;"
                                                                    alt="">
                                                            </label>
                                                            <form action="" method="post" enctype="multipart/form-data">
                                                                <input type="file" name="image" class="d-none" id="file"
                                                                    onchange="loadFile(event)">
                                                                <div class="billing-btn">
                                                                    <button type="submit" class="d-none"
                                                                        name="upload-image"
                                                                        id="upload-image">Upload</button>
                                                                </div>
                                                            </form>
                                                            <?= isset($imageService) && $imageService->getError('size') ?>
                                                            <?= isset($imageService) && $imageService->getError('extension') ?>
                                                            <?= $successfullUpload ?? "" ?>
                                                            <?= $failedUpload ?? "" ?>
                                                        </div>


                                                    </div>
                                                </div>

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

                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label for="gender">Gender</label>
                                                        <select name="gender" id="gender">
                                                            <option
                                                                <?= $_SESSION['user']->gender == 'm' ? 'selected' : '' ?>
                                                                value="m">Male</option>
                                                            <option
                                                                <?= $_SESSION['user']->gender == 'f' ? 'selected' : '' ?>
                                                                value="f">Female</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="billing-back-btn">
                                                <div class="billing-back">
                                                    <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                                </div>
                                                <div class="billing-btn">
                                                    <button type="submit" name="update-info">Continue</button>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>2</span> <a data-toggle="collapse" data-parent="#faq"
                                        href="#my-account-2">Change your password </a></h5>
                            </div>
                            <div id="my-account-2" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>Change Password</h4>
                                            <h5>Your Password</h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="billing-info">
                                                    <label>Password</label>
                                                    <input type="password">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="billing-info">
                                                    <label>Password Confirm</label>
                                                    <input type="password">
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
                                <h5 class="panel-title"><span>3</span> <a data-toggle="collapse" data-parent="#faq"
                                        href="#my-account-3">Modify your address book entries </a></h5>
                            </div>
                            <div id="my-account-3" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>Address Book Entries</h4>
                                        </div>
                                        <div class="entries-wrapper">
                                            <div class="row">
                                                <div
                                                    class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center">
                                                    <div class="entries-info text-center">
                                                        <p>Farhana hayder (shuvo) </p>
                                                        <p>hastech </p>
                                                        <p> Road#1 , Block#c </p>
                                                        <p> Rampura. </p>
                                                        <p>Dhaka </p>
                                                        <p>Bangladesh </p>
                                                    </div>
                                                </div>
                                                <div
                                                    class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center">
                                                    <div class="entries-edit-delete text-center">
                                                        <a class="edit" href="#">Edit</a>
                                                        <a href="#">Delete</a>
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
                                <h5 class="panel-title"><span>4</span> <a href="wishlist.php">Modify your wish list
                                    </a></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var loadFile = function(event) {
    var output = document.getElementById('image');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
        document.getElementById('upload-image').classList.remove('d-none');
    }
};
</script>
<!-- my account end -->
<?php
include "layouts/footer.php";
include "layouts/scripts.php";
?>