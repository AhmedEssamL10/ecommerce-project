<?php

use App\Database\Http\Requests\validation;
use App\Database\Models\User;

$title = "Verify Your Account";
// include "layouts/header.php";
// if ($_SERVER['REQUEST_METHOD'] == "POST") {
//     // validation
//     $validation = new validation;
//     // $validation->setInput('verification_code')->setValue($_POST['verification_code'])
//     //     ->required()->digits(5)->exists('users', 'verification_code');
//     // if (empty($validation->getErrors())) {
//     //     // no validation error
//     //     $user = new User;
//     //     $result = $user->setEmail($_SESSION['email'])->setVerification_code($_POST['verification_code'])
//     //         ->checkCode();
//     //     if ($result->num_rows == 1) {
//     //         $user->setEmail_verified_at(date('Y-m-d H:i:s'));
//     //         if ($user->makeUserVerified()) {
//     //             // updated
//     //             $success = "<div class='alert alert-success text-center'> Correct Code , You will be redirected to login page shortly ... </div>";
//     //             header('refresh:3; url=login.php');
//     //         } else {
//     //             $error = "<div class='alert alert-danger text-center'> Something Went Wrong </div>";
//     //         }
//     //     } else {
//     //         $error = "<div class='alert alert-danger text-center'> Wrong Verification Code </div>";
//     //     }
//     // }
// }
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

                                        <input type="number" name="verification_code" placeholder="Verification Code">

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