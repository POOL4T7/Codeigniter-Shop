<script src="<?php echo base_url() ?>static/js/Cart.js"></script>

<div class="container  p-5 ">
    <h3 class="text-center">Welcome to our website</h3>
    <div class="row">
        <?php foreach ($products as $product) {  ?>
            <div class="card" style="width: 18rem;">
                <img src="<?php base_url() ?>/static/images/products/<?= $product->image_path ?>" class="card-img-top" alt="Not found" loading="lazy">
                <div class="card-body">
                    <h5 class="card-title"><?= $product->title ?></h5>
                    <p class="card-text"><?= $product->price ?></p>
                    <a href="/product/byone/<?= $product->product_id ?>" class="btn btn-primary">about</a>
                    <a href="/cart/addToCart" class="btn btn-outline-success">Add To Cart</a>
                    <form id="<?= $product->product_id ?>" method="post">
                        <button class="btn btn-outline-success" type="submit">Add to cart</button>
                    </form>
                </div>
            </div>

        <?php } ?>
    </div>
</div>

<script src="<?php echo base_url() ?>static/js/Cart.js"></script>