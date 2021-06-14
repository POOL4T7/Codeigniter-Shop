<?php
if ($update_mode) {
    $detail = $details[0];
}
?>

<div class=" p-4 addproduct_form">
    <h1 id="form-title"><?= $update_mode ? 'Update Product' : 'Add Product'; ?></h1>
    <form class="<?= $update_mode ? 'update_product' : 'addproduct'; ?>" enctype="multipart/form-data" method="POST" id="<?= $update_mode ? 'update_product' : 'addproduct'; ?>">
        <div class="mb-3">
            <?php if ($update_mode) { ?>
                <label for="image">Image</label>
                <div class="card" style="width: 28rem;">
                    <input type="hidden" name="uploaded_image" value="<?= $detail->image_path ?>">
                    <img class="card-img-top" src="<?php base_url() ?>/static/images/products/<?= $detail->image_path ?>" alt="error" width="440" height="200">
                </div>
            <?php } else { ?>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>
            <?php } ?>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" id="title" value="<?= $update_mode ? $detail->title : ''; ?>">
        </div>
        <div class="mb-3">
            <label for="price">Price</label>
            <input type="text" class="form-control" name="price" id="price" step="0.01" value="<?= $update_mode ? $detail->price : '' ?>">
        </div>
        <div class="col-6 mb-3">
            <label for="avalibility" class="form-label">avalibility</label>
            <select class="form-select" aria-label="Default select example" name="avalibility" id="avalibility">
                <option value="<?= $update_mode ? $detail->avalibility : '' ?>"><?= $update_mode ? $detail->avalibility : '' ?></option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" id="description" rows="5"><?= $update_mode ? $detail->description : '' ?></textarea>
        </div>
        <?php if ($update_mode) { ?>
            <input type="hidden" name="id" value="<?= $update_mode ? $detail->product_id : '' ?>">
        <?php } ?>
        <button class="btn btn-outline-success " type="submit" id="<?= $update_mode ? 'update' : 'add' ?>"><?= $update_mode ? 'Update Product' : 'Add Product' ?></button>
    </form>
</div>

<script src="<?php echo base_url() ?>static/js/addproduct.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>static/css/tool/addproduct.css">