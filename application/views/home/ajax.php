<?php
$user_id = $this->session->userdata('id');
?>

<div class="box-body">
    <div class="table-responsive">
        <div class="container  p-5 ">
            <div class="row">
                <?php foreach ($products as $product) { ?>
                    <div class="card" style="width: 18rem;">
                        <img src="<?php base_url() ?>/static/images/products/<?= $product->image_path ?>" class="card-img-top" alt="Not found" loading="lazy">
                        <div class="card-body">
                            <h5 class="card-title"><?= $product->title ?></h5>
                            <p class="card-text"><?= $product->price ?></p>
                            <a href="/product/byone/<?= $product->product_id ?>" class="btn btn-primary">about</a>
                            <?php if ($product->avalibility == "yes") {
                                if ($user_id) { ?>

                                    <button class="btn cartbtn btn-outline-success" onclick="addtocart(this,<?= $product->product_id ?>)">Add to cart</button>
                                <?php }
                            } else { ?>
                                <button class="btn btn-outline-danger" disabled="disabled">Out Of Stock</button>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="container text-center p-5">
    <div class="pagination">
        <?= $pagelinks ?>
    </div>
</div>

<script>
    function addtocart(elemet, id, ) {
        NProgress.start();
        $.ajax({
            url: "/cart/addToCart/" + id,
            success: alert("Product added"),
            type: "POST",
        });
        NProgress.done();
        return false;
    }
</script>