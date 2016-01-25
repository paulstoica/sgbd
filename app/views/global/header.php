
<?php
//$header_logo = require "resources/images/header_logo.jpg";

?>
<body>

    <div class="header_logo">
        <img class="shop_logo" src="<?php echo \App\Project::getUrl('app/resources/images/header_logo_2.jpg')  ?>" >
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
            <form class="search-form" action="<?php echo\App\Project::getUrl('product/search') ?>" method="GET">
                <input type="text" name="query" value="" placeholder="Cautare produse">
                <button type="submit"><i class="glyphicon glyphicon-search" aria-hidden="true"></i></button>
            </form>
        </div>
        <div class="menu_link">
            <?php if (\App\Lib\Security::isLoggedUser()) { ?>
                <?php $user = \App\Lib\Security::getLoggedUser() ?>
                <a href="<?php echo\App\Project::getUrl('security/logout') ?>">Deconectare (<?php echo $user->getName() ?>)</a>
            <?php } else { ?>
                <a href="<?php echo\App\Project::getUrl('security/login') ?>">Connectare</a>
            <?php } ?>
        </div>
    </div>