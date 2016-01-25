

<?php $this->renderTemplate('global/head.php') ?>

<div class="page_container">
    <?php $this->renderTemplate('global/header.php') ?>

    <div class="register-form">
        <h3>Inregistrare</h3>
        <?php if(isset($error) && $error): ?>
            <div class="error">
                <?php echo $error ?>
            </div>
        <?php endif?>
        <form action="<?php echo\App\Project::getUrl('user/register') ?>" method="post">
            <div class="control">
                <input type="text" name="name" value="" placeholder="Nume">
            </div>
            <div class="control">
                <input type="text" name="email" value="" placeholder="Email">
            </div>
            <div class="control">
                <input type="password" name="password" value="" placeholder="Parola">
            </div>
            <div class="control">
                <input type="password" name="repassword" value="" placeholder="Confirm parola">
            </div>
            <input type="submit" value="Inregistrare">
        </form>
        <div class="register-block">
            <span>Ai deja un cont?</span>
            <a href="<?php echo\App\Project::getUrl('security/login') ?>">Conectare</a>
        </div>
    </div>
</div>
