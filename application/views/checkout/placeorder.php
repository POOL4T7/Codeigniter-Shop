<?php
?>
<link rel="stylesheet" href="<?php echo base_url() ?>static/css/tool/checkout.css">
<div class="container p-5">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">S.no</th>
                <th scope="col">Product Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">price per/pic</th>
                <th scope="col">Total price</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td><a href="<?= base_url() ?>product/byone/<?= $product->product_id ?>"><?= $product->title ?></a></td>
                <td><?= $repeat ? 1 :  $products->quantity ?></td>
                <td><?= $product->price ?></td>
                <td><?= $product->price * ($repeat ? 1 :  $products->quantity) ?></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="container p-5 bg-light" style="width: 100%;">
    <form method="post" id="profile_checkout">
        <div class="row">
            <div class="col-6 mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $profile->first_name ?>" default>
            </div>
            <div class="col-6 mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $profile->last_name ?>" default>
            </div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= $user->email ?>" default>
        </div>
        <div class="mb-3">
            <label for="mobile" class="form-label">Mobile</label>
            <input type="mobile" class="form-control" id="mobile" name="mobile" value="<?= $profile->mobile ?>" default>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="checkbox" id="flexCheckChecked">
            <label class="form-check-label" for="flexCheckChecked">
                <strong>Confirm Your Above information</strong>
            </label>
        </div>
        <input type="hidden" name="total" id="total" value="<?= $product->price * ($repeat ? 1 :  $products->quantity) ?>">
        <input id="id" type="hidden" name="id" value="<?= $product->product_id ?>">
        <br>
        <button type="submit" class="btn btn-outline-success">Place Order</button>
    </form>
</div>

<script src="<?php echo base_url() ?>/static/js/orders.js"></script>