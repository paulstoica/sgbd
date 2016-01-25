<?php $this->renderTemplate('global/head.php') ?>

<div class="page_container">
    <?php $this->renderTemplate('global/header.php') ?>

    <?php if (\App\Lib\Security::isLoggedUser()) { ?>

        <div class="product-form">
            <h3>Creare Produs</h3>
            <?php if(isset($error) && $error): ?>
                <div class="error">
                    <?php echo $error ?>
                </div>
            <?php endif?>
            <form action="<?php echo\App\Project::getUrl('product/create') ?>" method="post">

                <div class="control">
                    <input type="text" name="name" value="" placeholder="Nume">
                </div>

                <div class="control_description">
                    <textarea name="description" value="" placeholder="Descriere"></textarea>
                </div>

                <div class="control">
                    <input type="text" name="stock" value="" placeholder="Stoc">
                </div>

                <div class="control">
                    <input type="text" name="price" value="" placeholder="Pret">
                </div>

                <div class="control">
                    <select id="brand_select" name="brand" onchange="brandChanged()">
                        <option value="">Selecteaza un brand auto...</option>

                        <?php foreach($brands as $brand): ?>
                            <option value="<?php echo $brand->getId() ?>"><?php echo $brand->getName() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="control">
                    <select id="model_select"  name="model" disabled>
                        <option value="">Selecteaza un model auto...</option>
                    </select>
                </div>
                <input type="submit" value="Creaza">
            </form>
            <script type="text/javascript">
                var escapeHTML = function(unsafe) {
                    return unsafe.replace(/[&<"']/g, function(m) {
                        switch (m) {
                            case '&':
                                return '&amp;';
                            case '<':
                                return '&lt;';
                            case '"':
                                return '&quot;';
                            default:
                                return '&#039;';
                        }
                    });
                };

                var brandChanged = function() {
                    var brandId = document.getElementById("brand_select").value;

                    var modelSelectEl = $("#model_select");

                    var xhttp = new XMLHttpRequest();

                    xhttp.onreadystatechange = function() {
                        if (xhttp.readyState == 4 && xhttp.status == 200) {
                            if (xhttp.responseText) {
                                modelSelectEl.removeAttr('disabled');
                                modelSelectEl.empty().append(xhttp.responseText);
                            }
                        }
                    };
                    xhttp.open("GET", "<?php echo \App\Project::getUrl('product/model/') ?>" + brandId, true);
                    xhttp.send();
                };


            </script>
        </div>
    <?php } else { ?>
        <span>Trebuie sa fi conectat pentru a putea adauga produse.</span>
        <a href="<?php echo\App\Project::getUrl('security/login') ?>">Conectare.</a>
    <?php } ?>
</div>