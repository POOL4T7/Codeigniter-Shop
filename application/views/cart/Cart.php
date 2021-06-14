<?php
$i = 0;
$total_amount_of_cart = 0;
 ?>

<style>
    .row{
        --bs-gutter-x: none;
    }
</style>

<!-- <iframe
  width="560" height="315" src="https://www.youtube.com/embed/mo8thg5XGV0"
  frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>
</iframe> -->

<div class="container p-5">
    <h1 class="text-center">Cart</h1>
    <div class="row">
        <?php foreach ($products as $product) {
            $total_amount_of_cart = $total_amount_of_cart + $product[0]->price;
        ?>
            <div class="card" id="card" style="width: 18rem;">
                <img src="<?php echo base_url('/static/images/products/') . $product[0]->image_path
                            ?>" class="card-img-top" alt="..." loading="lazy">
                <div class="card-body">
                    <h5 class="card-title"><?= $product[0]->title ?></h5>
                    <p class="card-text"><?= substr($product[0]->description, 0, 50) ?></p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Quantity: <?= $items[$i]->quantity ?></li>
                    <li class="list-group-item">Price of one Item: <?= $product[0]->price ?> </li>
                    <li class="list-group-item">Total price: <?= $product[0]->price * $items[$i]->quantity ?></li>
                    <div class="row">
                        <div class="col-6">
                            <button class="btn btn-outline-warning" value="<?= $items[$i]->quantity ?>" onclick="updateCartDec(this,<?= $product[0]->product_id ?>)">Decrease</button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-success" value="<?= $items[$i]->quantity ?>" onclick="updateCartInc(this,<?= $product[0]->product_id ?>)">Increase</button>
                        </div>
                    </div>
                </ul>
                <div class="card-body">
                    <button class="btn btn-outline-danger" onclick="remove(this,<?= $product[0]->product_id ?>)">Remove</button>
                    <a class="btn btn-success" href="<?= base_url() ?>checkout/confirmation/<?= $product[0]->product_id ?>">Check Out</a>
                </div>
            </div>
        <?php $i = $i + 1;
        }
        ?>
    </div>
</div>
<div class="container p-5">

</div>
<script src="<?php echo base_url() ?>/static/js/Cart.js"></script>