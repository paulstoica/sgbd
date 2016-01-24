
<?php $this->renderTemplate('global/head.php') ?>

<div class="page_container">
    <?php $this->renderTemplate('global/header.php') ?>

    <h3>List Products</h3>

    <?php foreach ($products as $product): ?>
        <div class="product_container">
            <div class="product_logo">
                <img width="200px" src="<?php echo \App\Project::getUrl('app/resources/images/') . 'default-product.jpg' ?>">
            </div>
            <div class="product_info">
                <div class="product_name">
                    Name: <?php echo $product->getName() ?>
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
</div>