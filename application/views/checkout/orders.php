<?php
$i = 0;
$total_amount_of_cart = 0;
?>
<style>
    .row {
        --bs-gutter-x: none;
    }

    a {
        text-decoration: none;
    }
</style>

<div class="container p-5">
    <h1 class="text-center">Orders</h1>
    <div class="row">
        <?php foreach ($products as $product) {
            $total_amount_of_cart = $total_amount_of_cart + $product[0]->price;
        ?>
            <div class="card" id="card" style="width: 18rem;">
                <img src="<?php echo base_url('/static/images/products/') . $product[0]->image_path
                            ?>" class="card-img-top" alt="..." loading="lazy">
                <div class="card-body">
                    <a href="<?= base_url() ?>product/byone/<?= $product[0]->product_id ?>">
                        <h5 class="card-title"><?= $product[0]->title ?></h5>
                    </a>
                    <p class="card-text"><?= substr($product[0]->description, 0, 50) ?></p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Total Amount: <?= $items[$i]->grand_total ?> </li>
                    <?php if ($items[$i]->status == "placed") { ?>
                        <li class="list-group-item">Placed on: <?= $items[$i]->grand_total ?> </li>
                        <li class="list-group-item"><strong>Delivered</strong>: Order will delivered after two days od order placed </li>
                    <?php } else if ($items[$i]->status == "delivered") { ?>
                        <li class="list-group-item">Placed on: <?= $items[$i]->grand_total ?> </li>
                        <li class="list-group-item">Delivered: <?= $items[$i]->grand_total ?> </li>
                    <?php } else { ?>
                        <li class="list-group-item">Placed on: <?= $items[$i]->created_at ?> </li>
                        <li class="list-group-item">Cancelled on: <?= $items[$i]->last_updated_at ?> </li>
                    <?php } ?>
                </ul>
                <div class="card-body">
                    <?php if ($items[$i]->status == "placed") { ?>
                        <button class="btn btn-outline-danger" onclick="cancel_order(this,<?= $product[0]->product_id ?>)">Cancel</button>
                    <?php } ?>
                    <a class="btn btn-success" href="<?= base_url() ?>checkout/repeat_product/<?= $product[0]->product_id ?>">Repeat Order</a>
                </div>
            </div>
        <?php $i = $i + 1;
        }
        ?>
    </div>
</div>
<script src="<?php echo base_url() ?>/static/js/Cart.js"></script>