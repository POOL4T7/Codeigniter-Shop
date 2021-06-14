<?php
if ($this->session->userdata('id')) {
    $data = $user[0];
    $profile = $profile[0];
} else {
    redirect('/');
}
?>

<div class="container p-4  profile_form">
    <h1 id="form-title">Profile</h1>
    <form method="post" id="profile_form">
        <div class="mb-3">
            <input type="hidden" name="uploaded_image" value="<?= $profile->profile_image ?>" hidden>
            <img src="<?= base_url() ?>static/images/profiles/<?= $profile->profile_image ?>" alt="update Your profile" name="updated_profile" srcset="" loading="lazy">
        </div>
        <div class="row">
            <div class="col-6 mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $profile->first_name ?>">
            </div>
            <div class="col-6 mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $profile->last_name ?>">
            </div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= $data->email ?>">
        </div>
        <div class="mb-3">
            <label for="mobile" class="form-label">Mobile</label>
            <input type="mobile" class="form-control" id="mobile" name="mobile" value="<?= $profile->mobile ?>">
        </div>
        <div class="row">
            <div class="col-6">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" aria-label="Default select example" name="gender" id="gender">
                    <option value="female" <?= $profile->gender == "female" ? "Selected" : "" ?>>Female</option>
                    <option value="male" <?= $profile->gender == "male" ? "Selected" : "" ?>>Male</option>
                    <option value="transgender" <?= $profile->gender == "transgender" ? "Selected" : "" ?>>Transgender</option>
                </select>
            </div>
            <div class="col-6 mb-3">
                <input type="text" class="form-control" id="type" name="type" value="<?= $data->type ?>" hidden>
            </div>
        </div>
        <br>
        <button type="submit" id="profile-btn" class="btn btn-outline-success">Update</button>
    </form>
</div>

<script src="<?php echo base_url() ?>static/js/profile.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>static/css/credentials/profile.css">