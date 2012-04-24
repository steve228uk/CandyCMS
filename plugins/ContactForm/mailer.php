<?php

include '../../core/bootstrap.php';

extract($_POST);

$to = ContactForm::getContactFormTo();

mail($to, $subject, $message);