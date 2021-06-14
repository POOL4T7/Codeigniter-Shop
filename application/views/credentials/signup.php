<!--  -->
<div class="container p-4 signup_form">
    <h1 class="text-center " id="form-title">Signup Page</h1>
    <form method="POST" id="signup_form">
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
        <div class="row">
            <div class="col-6">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name">
            </div>
            <div class="col-6">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name">
            </div>
        </div>
        <div class="mb-3">
            <label for="mobile" class="form-label">Mobile</label>
            <input type="text" class="form-control" id="mobile" name="mobile">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="row mb-3">
            <div class="col-6">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" aria-label="Default select example" name="gender" id="gender">
                    <option value="male">male</option>
                    <option value="female">female</option>
                    <option value="transgender">transgender</option>
                </select>
            </div>
            <div class="col-6">
                <label for="type" class="form-label">Type</label>
                <select class="form-select" aria-label="Default select example" name="type" id="type">
                    <option value="buyer">Buyer</option>
                    <option value="seller">Seller</option>
                </select>
            </div>
        </div>
        <button id="signup-btn" type="submit" class="btn btn-outline-primary">Submit</button>
    </form>
</div>
<script src="<?php echo base_url() ?>static/js/signup.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>static/css/credentials/signup.css">