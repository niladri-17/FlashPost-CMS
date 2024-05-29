<?php user_signup(); ?>
<?php user_login(); ?>

<?php
$name = $_SESSION['signup-data']['signup-name'] ?? null;
$username = $_SESSION['signup-data']['signup-username'] ?? null;
$email = $_SESSION['signup-data']['signup-email'] ?? null;
// unset($_SESSION['signup-data']);
?>

<?php
$email_username = $_SESSION['login-data']['login-email-username'] ?? null;
$password = $_SESSION['login-data']['login-password'] ?? null;

unset($_SESSION['login-data']);
?>

<div class="cd-user-modal"> <!-- this is the entire modal form, including the background -->
    <div class="cd-user-modal-container"> <!-- this is the container wrapper -->
        <ul class="cd-switcher">
            <li><a href="#0">Sign in</a></li>
            <li><a href="#0">New account</a></li>
        </ul>

        <div id="cd-login"> <!-- log in form -->
            <form action="" method="POST" class="cd-form">




                <?php if (isset($_SESSION['signup-success'])) : ?>
                    <p class="fieldset" style="color: green;">
                        <?= $_SESSION['signup-success']; ?>
                    </p>

                <?php elseif (isset($_SESSION['login'])) : ?>
                    <p class="fieldset" style="color: red;">
                        <?= $_SESSION['login']; ?>
                    </p>

                <?php endif ?>





                <p class="fieldset">
                    <label class="image-replace cd-email" for="login-email">E-mail or Username</label>
                    <input name="login-email-username" class="full-width has-padding has-border" id="login-email" type="text" value="<?= $email_username ?>" placeholder="E-mail or Username" require>
                    <span class="cd-error-message">Account not found!</span>
                </p>

                <p class="fieldset">
                    <label class="image-replace cd-password" for="login-password">Password</label>
                    <input name="login-password" class="full-width has-padding has-border" id="login-password" type="password" value="<?= $password ?>" placeholder="Password" required>
                    <a href="#0" class="hide-password">Show</a>
                    <span class="cd-error-message">Error message here!</span>
                </p>

                <p class="fieldset">
                    <input type="checkbox" id="remember-me" checked>
                    <label for="remember-me">Remember me</label>
                </p>

                <p class="fieldset">
                    <input name="login-submit" class="full-width" type="submit" value="Login">
                </p>
            </form>

            <p class="cd-form-bottom-message"><a href="#0">Forgot your password?</a></p>
            <!-- <a href="#0" class="cd-close-form">Close</a> -->
        </div> <!-- cd-login -->

        <div id="cd-signup"> <!-- sign up form -->
            <form action="" enctype="multipart/form-data" method="POST" class="cd-form">
                <p class="fieldset">
                    <label class="image-replace cd-username" for="signup-username">Username</label>
                    <input name="signup-name" class="full-width has-padding has-border" id="signup-name" type="text" value="<?= $name ?>" placeholder="Name" required>
                </p>

                <p class="fieldset">
                    <label class="image-replace cd-username" for="signup-username">Username</label>
                    <input name="signup-username" class="full-width has-padding has-border" id="signup-username" type="text" value="<?= $username ?>" placeholder="Username" required>
                    <span class="cd-error-message">This username is already taken!</span>
                </p>

                <p class="fieldset">
                    <label class="image-replace cd-email" for="signup-email">E-mail</label>
                    <input name="signup-email" class="full-width has-padding has-border" id="signup-email" type="email" value="<?= $email ?>" placeholder="E-mail" required>
                    <span class="cd-error-message">Account already exist with this email!</span>
                </p>

                <p class="fieldset">
                    <label class="image-replace cd-password" for="signup-create-password">Password</label>
                    <input name="create-password" class="full-width has-padding has-border" id="signup-create-password" type="password" placeholder="Password" required>
                    <a href="#0" class="hide-password">Show</a>
                    <span class="cd-error-message" id="error-create-password">Password should be more than 3 characters</span>
                </p>

                <p class="fieldset">
                    <label class="image-replace cd-password" for="signup-confirm-password">Confirm Password</label>
                    <input name="confirm-password" class="full-width has-padding has-border" id="signup-confirm-password" type="password" placeholder="Confirm password" disabled required>
                    <a href="#0" class="hide-password">Show</a>
                    <span class="cd-error-message" id="error-confirm-password">Password is not matching</span>
                </p>


                <?php if (isset($_SESSION['signup'])) : ?>
                    <p class="fieldset" style="color: red;">
                        <?= $_SESSION['signup']; ?>
                    </p>
                <?php endif ?>

            

                <p class="fieldset">
                    <input type="checkbox" id="accept-terms" required>
                    <label for="accept-terms">I agree to the <a href="#0">Terms</a></label>
                </p>

                <p class="fieldset">
                    <input name="signup-submit" class="full-width has-padding" type="submit" value="Create account" >
                </p>
            </form>

            <a href="#0" class="cd-close-form">Close</a>
        </div> <!-- cd-signup -->

        <div id="cd-reset-password"> <!-- reset password form -->
            <p class="cd-form-message">Lost your password? Please enter your email address. You will receive a link to create a new password.</p>

            <form class="cd-form">
                <p class="fieldset">
                    <label class="image-replace cd-email" for="reset-email">E-mail</label>
                    <input class="full-width has-padding has-border" id="reset-email" type="email" placeholder="E-mail">
                    <span class="cd-error-message">Error message here!</span>
                </p>

                <p class="fieldset">
                    <input class="full-width has-padding" type="submit" value="Reset password">
                </p>
            </form>

            <p class="cd-form-bottom-message"><a href="#0">Back to log-in</a></p>
        </div> <!-- cd-reset-password -->
        <a href="#0" class="cd-close-form">Close</a>
    </div> <!-- cd-user-modal-container -->
</div> <!-- cd-user-modal -->

<?php
// open signup modal automatically on wrong signup
if (isset($_SESSION['signup'])) {
    open_signup_modal();
    unset($_SESSION['signup']);
}

// open login modal automatically on signup success
if (isset($_SESSION['signup-success'])) {
    open_login_modal();
    unset($_SESSION['signup-success']);
}

// open login modal automatically on login error
if (isset($_SESSION['login'])) {
    open_login_modal();
    unset($_SESSION['login']);
}
?>