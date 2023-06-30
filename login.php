<?php

use App\Database\Http\Requests\validation;
use App\Database\models\User;
use App\Mails\VerificationCode;

$title = "Login";
include "layouts/header.php";
include "layouts/navbar.php";
include "layouts/breadcrumb.php";
$validation = new validation;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //validation
    $validation->setInput('email')->setValue($_POST["email"])->required()->regex('/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/', 'wrong email or password')->exists('users', 'email');
    $validation->setInput('password')->setValue($_POST['password'])->required()->regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,32}$/', 'wrong email or password');
    if (empty($validation->getErrors())) {
        // no validation error
        //email and password correct
        $user = new User;
        $result =  $user->setEmail($_POST['email'])->checkLogin()->fetch_object();
        // print_r($result);
        if (password_verify($_POST['password'], $result->password)) {

            // email verified
            if (!is_null($result->email_verification_at)) {
                if ($result->status == 1) {
                    // $_SESSION['email'] = $_POST['email'];
                    // $_SESSION['image'] = $result->image;
                    // $_SESSION['email'] = $result->phone;
                    // $_SESSION['email'] = $result->first_name;
                    // $_SESSION['email'] = $result->last_name;
                    // $_SESSION['email'] = $result->id;
                    $_SESSION['user'] = $result;
                    header("location:index.php");
                } else {
                    $error = '<div class="alert alert-danger text-center"><strong>This email is blocked';
                }
            } else {
                $_SESSION['email'] = $_POST['email'];
                header('location:check-verification-code.php');
            }
        } else {
            $error = '<div class="alert alert-warning text-center"><strong>Wrong Email or password';
        }
    }
}
?>
<div class="login-register-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a class="active" data-toggle="tab" href="#lg1">
                            <h4> login </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form action="" method="post">
                                        <?= isset($error) ? $error : '' ?>
                                        <input type="email" name="email" placeholder="Email address" value="<?= $validation->getOldValues('email') ?>">
                                        <?php echo $validation->getError("email"); ?>
                                        <input type="password" name="password" placeholder="Password">
                                        <?php echo $validation->getError("password"); ?>
                                        <div class="button-box">
                                            <div class="login-toggle-btn">
                                                <input type="checkbox">
                                                <label>Remember me</label>
                                                <a href="#">Forgot Password?</a>
                                            </div>
                                            <button type="submit"><span>Login</span></button>
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