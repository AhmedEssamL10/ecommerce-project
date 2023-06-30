<?php

use App\Database\Http\Requests\validation;
use App\Database\Models\User;

use App\Mails\ForgetPassword;

$title = "Forget Password";
include "layouts/header.php";
include "App/Database/Http/Middlewares/Guest.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // validation
    $validation = new validation;
    $validation->setInput('email')->setValue($_POST['email'])
        ->required()->regex('/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/')->exists('users', 'email');
    if (empty($validation->getErrors())) {
        // no validation error
        $forgetPasswordCode = rand(10000, 99999);
        $user = new User;
        $result = $user->setEmail($_POST['email'])
            ->setVerification_code($forgetPasswordCode);
        if ($user->updateCode()) {
            $forgetPasswordMail = new ForgetPassword;
            $subject = "Forget Password Code";
            $body = "<p>Hello {$_POST['email']}</p>
            <p>Your Forget Password Code: <b style='color:blue;'>{$forgetPasswordCode}</b></p>
            <p>Thank You.</p>";
            if ($forgetPasswordMail->send($_POST['email'], $subject, $body)) {
                $_SESSION['email'] = $_POST['email'];
                header('location:check-verification-code.php?page=forget'); // send thing in url to check on it to kown from any page the code send
                die;
            } else {
                $error = "<div class='alert alert-danger text-center'> Please Try Again Later </div>";
            }
        } else {
            $error = "<div class='alert alert-danger text-center'> Something Went Wrong </div>";
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
                            <h4> <?= $title ?></h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form action="" method="post">
                                        <?= $error ?? "" ?>
                                        <?= $success ?? "" ?>
                                        <input type="email" name="email" placeholder="Email Address">
                                        <?= isset($validation) ? $validation->getError('email') : '' ?>
                                        <div class="button-box">
                                            <button type="submit"><span>Verify</span></button>
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
include "layouts/scripts.php";
?>