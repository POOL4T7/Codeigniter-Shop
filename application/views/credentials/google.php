<?php
$redirect = explode('/', $page);
?>

<div class="container p-5 bg-light text-center">
    <h3><?= $message  ?></h3>
    <p>You will automatically redirect in 5 sec on <strong><em><?= $redirect[2]  ?></em></strong> </p>
    <?php
    header('Refresh: 5; ' . $page);
    ?>
</div>