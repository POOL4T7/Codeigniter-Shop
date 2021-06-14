<link rel="stylesheet" href="<?php echo base_url() ?>static/css/tool/product.css">
<?php
$detail = $details[0];
$role = $this->session->userdata('role');
?>
<div class="container p-5">
  <div class="row">
    <div class="col-md-3">
      <div class="accordion" id="accordionExample">
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              info-1
            </button>
          </h2>
          <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="accordion-body"><?= $detail->description ?></div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              info-2
            </button>
          </h2>
          <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
            <div class="accordion-body"><?= $detail->description ?></div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              info-3
            </button>
          </h2>
          <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <?= $detail->description ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="figure">
        <input type="hidden" name="uploaded_image" value="<?= $detail->image_path ?>">
        <img class="figure-img img-fluid rounded pinterest-img" src="<?php base_url() ?>/static/images/products/<?= $detail->image_path ?>" alt="err">
        <figcaption class="figure-caption text-right">
          <?= $detail->title ?>
        </figcaption>
      </div>
      <div class="text-center p-5">
        <p class="description">
          <?= $detail->description ?>
        </p>
        <?php if ($role == "seller") {
          if ($_SERVER) {
            if ($_SERVER['HTTP_REFERER'] == 'http://fuck.com/product/adminProduct') { ?>
              <a href="/product/addproduct/<?= $detail->product_id ?>" class="btn btn-outline-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update</a>
        <?php }
          }
        } ?>
      </div>
      <br>
    </div>
  </div>
</div>
<div class="share-btn-container">
  <a href="#" class="facebook-btn" target="_blank">
    <i class="fa fa-facebook"></i>
  </a>

  <a href="#" class="twitter-btn" target="_blank">
    <i class="fa fa-twitter"></i>
  </a>

  <a href="#" class="pinterest-btn" target="_blank">
    <i class="fa fa-pinterest"></i>
  </a>

  <a href="#" class="linkedin-btn" target="_blank">
    <i class="fa fa-linkedin"></i>
  </a>

  <a href="#" class="whatsapp-btn" target="_blank">
    <i class="fa fa-whatsapp"></i>
  </a>
</div>
<script src="<?php echo base_url() ?>static/js/delete.js"></script>