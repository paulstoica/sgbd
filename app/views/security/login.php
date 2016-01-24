
<?php $this->renderTemplate('global/head.php') ?>

<div class="page_container">
    <?php $this->renderTemplate('global/header.php') ?>
    <div class="login-form">
        <h3>Login</h3>
        <?php if(isset($error) && $error): ?>
            <div class="error">
                <?php echo $error ?>
            </div>
        <?php endif?>
        <form action="<?php echo\App\Project::getUrl('security/login') ?>" method="post">
            <div class="control">
                <input type="text" name="email" value="" placeholder="Email">
            </div>
            <div class="control">
                <input type="password" name="password" value="" placeholder="Password">
            </div>
            <input type="submit" value="Login">
        </form>
        <div class="register-block">
            <span>Do you don't have an account?</span>
            <a href="<?php echo\App\Project::getUrl('user/register') ?>">Create one.</a>
        </div>
    </div>
</div>
