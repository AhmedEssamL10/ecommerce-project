<?php

use App\Database\Http\Requests\validation;

$title = "Register";
include "layouts/header.php";
include "layouts/navbar.php";
include "layouts/breadcrumb.php";
$validation = new validation;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //validation

    $validation->setInput('first_name')->setValue($_POST["first_name"])->required()->min(2)->max(32);
    $validation->setInput('last_name')->setValue($_POST["last_name"])->required()->min(2)->max(32);
    $validation->setInput('email')->setValue($_POST["email"])->required()->regex('/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/');
    $validation->setInput('phone')->setValue($_POST['phone'])->required()->regex('/^01[0125][0-9]{8}$/');
    $validation->setInput('password')->setValue($_POST['password'])->required()->regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,32}$/', 'mini 8 chars max 32 ,mini one number , one character , one uppercase letter , one lowercase letter , one specidal char')->confirmation($_POST['password_confirmation']);
    $validation->setInput('password_confirmation')->setValue($_POST['password_confirmation'])->required();
    $validation->setInput('gender')->setValue($_POST['gender'])->required()->in(['m', 'f']);
    if (empty($validation->getErrors())) {
        // no validation error
    }
}



// generate verification code

// send email

?>
<div class="login-register-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a class="active" data-toggle="tab" href="#lg2">
                            <h4> register </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg2" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <?= $error ?? "" ?>
                                    <form method="post">
                                        <input type="text" name="first_name" placeholder="First Name" value="<?= $_POST["first_name"] ?>">
                                        <?php echo $validation->getError("first_name"); ?>
                                        <input type="text" name="last_name" placeholder="Last Name" value="<?= $_POST["last_name"] ?>">
                                        <?php echo $validation->getError("last_name"); ?>
                                        <input type="email" name="email" placeholder="Email Address" value="<?= $_POST["email"] ?>">
                                        <?php echo $validation->getError("email"); ?>
                                        <input type="tel" name="phone" placeholder="Phone" value="<?= $_POST["phone"] ?>">
                                        <?php echo $validation->getError("phone"); ?>
                                        <input type="password" name="password" placeholder="Password">
                                        <?php echo $validation->getError("password"); ?>
                                        <input type="password" name="password_confirmation" placeholder="Password Confirmation">
                                        <?php echo $validation->getError("password_confirmation"); ?>
                                        <select name="gender" class="form-control my-3" id="">
                                            <option value="m">Male</option>
                                            <option value="f">Female</option>
                                        </select>
                                        <?php echo $validation->getError("gender"); ?>


                                        <div class="button-box">
                                            <button type="submit"><span>Register</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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