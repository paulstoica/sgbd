

<?php $this->renderTemplate('global/head.php') ?>

<div class="page_container">
    <?php $this->renderTemplate('global/header.php') ?>

    <div class="register-form">
        <h3>Register</h3>
        <?php if(isset($error) && $error): ?>
            <div class="error">
                <?php echo $error ?>
            </div>
        <?php endif?>
        <form action="<?php echo\App\Project::getUrl('user/register') ?>" method="post">
            <div class="control">
                <input type="text" name="name" value="" placeholder="Name">
            </div>
            <div class="control">
                <input type="text" name="email" value="" placeholder="Email">
            </div>
            <div class="control">
                <input type="password" name="password" value="" placeholder="Password">
            </div>
            <div class="control">
                <input type="password" name="repassword" value="" placeholder="Confirm password">
            </div>
            <input type="submit" value="Register">
        </form>
        <div class="register-block">
            <span>Do you have already an account?</span>
            <a href="<?php echo\App\Project::getUrl('security/login') ?>">Login</a>
        </div>
    </div>
</div>
