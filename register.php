<?php



$title = "Register";
include "layouts/header.php";
include "layouts/navbar.php";
include "layouts/breadcrumb.php";



// no validation error
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
                                        <input type="text" name="first_name" placeholder="First Name" value="">

                                        <input type="text" name="last_name" placeholder="Last Name" value="">

                                        <input type="email" name="email" placeholder="Email Address" value="">

                                        <input type="tel" name="phone" placeholder="Phone" value="">

                                        <input type="password" name="password" placeholder="Password">

                                        <input type="password" name="password_confirmation" placeholder="Password Confirmation">

                                        <select name="gender" class="form-control my-3" id="">
                                            <option value="m">Male</option>
                                            <option value="f">Female</option>
                                        </select>


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