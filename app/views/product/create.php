<?php $this->renderTemplate('global/head.php') ?>

<div class="page_container">
    <?php $this->renderTemplate('global/header.php') ?>


    <div class="product-form">
        <h3>Create Product</h3>
        <?php if(isset($error) && $error): ?>
            <div class="error">
                <?php echo $error ?>
            </div>
        <?php endif?>
        <form action="<?php echo\App\Project::getUrl('product/create') ?>" method="post">

            <div class="control">
                <input type="text" name="name" value="" placeholder="Name">
            </div>

            <div class="control">
                <textarea name="description" value="" placeholder="Description"></textarea>
            </div>

            <div class="control">
                <input type="text" name="stock" value="" placeholder="Stock">
            </div>

            <div class="control">
                <input type="text" name="price" value="" placeholder="Price">
            </div>

            <div class="control">
                <select id="brand_select" name="brand" onchange="brandChanged()">
                    <option value="">Select a auto brand...</option>

                    <?php foreach($brands as $brand): ?>
                        <option value="<?php echo $brand->getId() ?>"><?php echo $brand->getName() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="control">
                <select id="model_select"  name="model" disabled>
                    <option value="">Select a auto model...</option>
                </select>
            </div>
            <input type="submit" value="Create">
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
</div>