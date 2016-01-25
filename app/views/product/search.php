
<?php $this->renderTemplate('global/head.php') ?>

<div class="page_container">
    <?php $this->renderTemplate('global/header.php') ?>

    <h3>Rezultatul cautarii</h3>

    <?php if(isset($error) && $error) { ?>
        <div class="error">
            <?php echo $error ?>
        </div>
    <?php } else {?>
        <?php foreach ($products as $product): ?>
            <div class="product_container">
                <div class="product_logo">

                    <?php $imgSrc = \App\Project::getUrl('app/resources/images/default-product.jpg') ?>

                    <?php
                    switch($product->getName()) {
                        case 'Alternator':
                            $imgSrc = \App\Project::getUrl('app/resources/images/products/alternator.jpg');
                            break;
                        case 'Bara spate':
                            $imgSrc = \App\Project::getUrl('app/resources/images/products/bara-spate.jpg');
                            break;
                        case 'Bancheta':
                            $imgSrc = \App\Project::getUrl('app/resources/images/products/bancheta-spate.jpg');
                            break;
                    }
                    ?>

                    <img width="200px" src="<?php echo $imgSrc ?>">
                </div>
                <div class="product_info">
                    <div class="product_name">
                        Nume: <?php echo $product->getName() ?>
                    </div>
                    <div class="product_stock">
                        Stoc: <?php echo $product->getStock() ?>
                    </div>
                    <div class="product_price">
                        Pret: <?php echo $product->getPrice() ?>
                    </div>
                    <div class="product_description">
                        Descriere: <?php echo $product->getDescription() ?>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php }?>
</div>