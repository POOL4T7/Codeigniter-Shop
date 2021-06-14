<!--  -->
<?php
if ($update_mode) {
    $details = $details[0];
}
?>

<div class="container p-4 shop_form">
    <h1 class="text-center" id="form-title"><?= $update_mode ? "Your Shop" : 'Add Shop' ?></h1>
    <form method="POST" id="<?= $update_mode ? "update_shop" : 'add_shop' ?>" enctype="multipart/form-data">
        <?php if ($update_mode) { ?>
            <div class="mb-3">
                <input type="hidden" name="uploaded_image" value="<?= $details->shop_image ?>" hidden>
                <img src="<?= base_url() ?>static/images/shops/<?= $details->shop_image ?>" alt="update Your profile" name="updated_profile" srcset="" width="400px" height="300px" loading="lazy">
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
        <?php } ?>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $update_mode ? $details->shop_name : '' ?>">
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="<?= $update_mode ? $details->location : '' ?>">
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <input type="text" class="form-control" id="type" name="type" value="<?= $update_mode ? $details->type : '' ?>">
        </div>
        <div class="mb-3">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" id="description" rows="5"><?= $update_mode ? $details->description : '' ?></textarea>
        </div>
        <button type="submit" id="shop-btn" class="btn btn-outline-primary">Submit</button>
    </form>
</div>
<script src="<?php echo base_url() ?>static/js/seller/shop.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>static/css/shop.css">