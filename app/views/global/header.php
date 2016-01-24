
<?php
//$header_logo = require "resources/images/header_logo.jpg";

?>
<body>

    <div class="header_logo">
        <img class="shop_logo" src="<?php echo \App\Project::getUrl('app/resources/images/') . 'header_logo_2.jpg' ?>" >
    </div>
    <div class="header_menu">
        <div class="menu_link">
            <a href="<?php echo\App\Project::getBaseUrl() ?>">Home</a>
        </div>
        <div class="menu_link">
            <a href="<?php echo\App\Project::getUrl('product/list') ?>">Lista produse</a>
        </div>
        <div class="menu_link">
            <a href="<?php echo\App\Project::getUrl('product/create') ?>">Adauga produs</a>
        </div>
        <div class="menu_link">
            <a href="#">Cautare</a>
        </div>
        <div class="menu_link">
            <?php if (\App\Lib\Security::isLoggedUser()) { ?>
                <?php $user = \App\Lib\Security::getLoggedUser() ?>
                <a href="<?php echo\App\Project::getUrl('security/logout') ?>">Logout (<?php echo $user->getName() ?>)</a>
            <?php } else { ?>
                <a href="<?php echo\App\Project::getUrl('security/login') ?>">Login</a>
            <?php } ?>
        </div>
    </div>