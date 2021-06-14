<?php
defined('BASEPATH') or exit('No direct script access allowed');
const base_url = "http://fuck.com";
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Fuck</title>
	<script src="/static/cdn/js/bootstrap.min.js" defer=''></script>
	<link rel="stylesheet" href="<?= base_url ?>/static/cdn/css/bootstrap.min.css" />
</head>

<body>
	<div class="container p-5 text-center">
		<h1><?php echo $heading; ?></h1>
		<hr>
		<p><?php echo $message; ?></p>
		<a href="<?php echo base_url; ?>">Return to Home Page</a>

	</div>
</body>

</html>