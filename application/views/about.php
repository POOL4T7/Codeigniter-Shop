<div class="container p-5 bg-light text-center">
    <h1>This website is under managment by the order of <em>Peaky Blinders</em></h1>
    &copy; <?php
            $fromYear = 1999;
            $thisYear = (int)date('Y');
            echo $fromYear . (($fromYear != $thisYear) ? '-' . $thisYear : ''); ?> Company.
</div>


<div class="container p-5 text-center">
    <?php
    echo $map['js'];
    echo $map['html'];
    ?>
</div>