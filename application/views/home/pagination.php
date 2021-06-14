<link rel="stylesheet" href="/static/css/dashboard/home.css">
<div class="container p-5 bg-light">
    <ul class="nav justify-content-center">
        <li class="nav-item form-group">
            <input type="text" class="form-control nav-link" name="search_key" id="search_key" placeholder="Search by product name" />
        </li>
        <li class="search-button nav-item">
            <button type="button" id="searchBtn" class="btn btn-outline-info">Search</button>
        </li>
        <li class="search-button nav-item">
            <button type="button" id="resetBtn" class="btn btn-outline-warning">Reset</button>
        </li>
    </ul>
</div>
<div class="container">
    <div id="ajaxContent"></div>
</div>

<script src="<?php echo base_url('/static/js/home.js') ?>"></script>