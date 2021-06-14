<!--  -->
<link rel="stylesheet" href="<?php echo base_url() ?>static/css/credentials/login.css">
<div class="container login_form p-4">
    <div id="form-title">
        <h2>Login Form</h2>
    </div>
    <form method="POST" id="login_form">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" id="login-btn" class="btn btn-outline-primary ">Login</button>
    </form>
</div>
<script src="<?php echo base_url() ?>static/js/login.js"></script>