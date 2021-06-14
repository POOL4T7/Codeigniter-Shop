<div class="container p-5  ">
    <h1 class="text-center">Admin products</h1>
    <?php
    if ($adminproducts) { ?>
        <div class="row ">
            <?php foreach ($adminproducts as $adminproduct) {  ?>
                <div class="card" style="width: 18rem;">
                    <img src="<?php base_url() ?>/static/images/products/<?= $adminproduct->image_path ?>" class="card-img-top" alt="Not found">
                    <div class="card-body">
                        <h5 class="card-title"><?= $adminproduct->title ?></h5>
                        <p class="card-text"><?= $adminproduct->price ?></p>
                        <a href="/product/byone/<?= $adminproduct->product_id ?>" class="btn btn-outline-primary">About</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <h1>Products are not found</h1>
    <?php } ?>
</div>