<?php

$errors = array('Oh no! ', 'Meeser Peter, ', 'Kaboom! ', 'Ooopsie! ', 'Our Bad, ');
shuffle($errors) ?>

<h1><?php echo $errors[0] ?>Error 404 - Page Not Found</h1>
<p>Were you looking for one of these perhaps?</p>
<?php theNav('sitemap') ?>